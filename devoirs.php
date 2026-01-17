<?php
require 'config.php';
require __DIR__ . '/inc/auth.php';
require_login();

$page_title = 'Devoirs';
$id_etudiant = (int)$_SESSION['id'];
$role = $_SESSION['role'] ?? '';
$q = trim($_GET['q'] ?? '');

// All assignments
$stmt = $conn->prepare(
  'SELECT d.*, c.nom_cours FROM devoir d JOIN cours c ON d.id_cours = c.id ORDER BY d.date_creation DESC'
);
$stmt->execute();
$devoirs = $stmt->fetchAll(PDO::FETCH_ASSOC);

function depot(PDO $conn, int $id_devoir, int $id_etudiant): ?array {
  $st = $conn->prepare('SELECT * FROM devoir_etudiant WHERE id_devoir = ? AND id_etudiant = ?');
  $st->execute([$id_devoir, $id_etudiant]);
  $r = $st->fetch(PDO::FETCH_ASSOC);
  return $r ?: null;
}

if ($q !== '') {
  $devoirs = array_values(array_filter($devoirs, function($d) use ($q){
    $hay = strtolower(($d['enonce_devoir'] ?? '').' '.($d['nom_cours'] ?? ''));
    return strpos($hay, strtolower($q)) !== false;
  }));
}

include __DIR__ . '/inc/layout_start.php';
?>

<div class="d-flex flex-wrap align-items-end justify-content-between gap-2 mb-4">
  <div>
    <h1 class="h3 mb-1">Devoirs</h1>
    <div class="muted">Soumission, suivi des deadlines, et état des notes.</div>
  </div>
  <form class="d-flex gap-2" method="get">
    <input class="form-control" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Rechercher un devoir ou un cours..." />
    <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
  </form>
</div>

<?php if (isset($_GET['success'])): ?>
  <div class="alert alert-success app-card">🎉 Devoir envoyé avec succès !</div>
<?php endif; ?>

<?php if ($role !== 'etudiant'): ?>
  <div class="alert alert-warning app-card">Seuls les étudiants peuvent soumettre des devoirs. Les professeurs peuvent noter dans la page <a href="resultats.php">Résultats</a>.</div>
<?php endif; ?>

<?php if (empty($devoirs)): ?>
  <div class="app-card p-3 muted">Aucun devoir disponible pour le moment.</div>
<?php else: ?>
  <div class="row g-3">
    <?php foreach ($devoirs as $devoir):
      $depot = ($role === 'etudiant') ? depot($conn, (int)$devoir['id_devoir'], $id_etudiant) : null;
      $date_expiration = new DateTime($devoir['date_expiration']);
      $now = new DateTime();
      $expired = $now > $date_expiration;
    ?>
      <div class="col-md-6 col-xl-4">
        <div class="app-card p-3 h-100">
          <div class="d-flex justify-content-between align-items-start gap-2">
            <div>
              <div class="fw-bold"><?= htmlspecialchars($devoir['enonce_devoir']) ?></div>
              <div class="muted small"><i class="bi bi-book"></i> <?= htmlspecialchars($devoir['nom_cours']) ?></div>
            </div>
            <?php if ($expired): ?>
              <span class="badge text-bg-danger">Expiré</span>
            <?php else: ?>
              <span class="badge text-bg-secondary">Ouvert</span>
            <?php endif; ?>
          </div>

          <hr class="border-opacity-25" />

          <div class="muted small mb-2"><i class="bi bi-clock"></i> Expire le : <?= $date_expiration->format('d/m/Y H:i') ?></div>

          <?php if ($role === 'etudiant'): ?>
            <?php if ($depot): ?>
              <div class="mb-2">📄 Déposé : <span class="badge text-bg-secondary"><?= htmlspecialchars($depot['original_filename']) ?></span></div>
              <div>
                <?php if ($depot['note'] === null || $depot['note'] === ''): ?>
                  <span class="badge text-bg-warning">📝 Note : En attente</span>
                <?php else: ?>
                  <span class="badge text-bg-success">📝 Note : <?= htmlspecialchars((string)$depot['note']) ?></span>
                <?php endif; ?>
              </div>
            <?php elseif ($expired): ?>
              <div class="text-danger fw-semibold">⛔ Date d'expiration dépassée.</div>
            <?php else: ?>
              <form action="submit_devoir.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_devoir" value="<?= (int)$devoir['id_devoir'] ?>" />
                <input type="file" name="fichier" class="form-control mb-2" required />
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-upload"></i> Envoyer</button>
              </form>
              <div class="muted small mt-2">Formats : PDF/DOC/DOCX · Max 10Mo</div>
            <?php endif; ?>
          <?php else: ?>
            <div class="muted">Consultez les dépôts et notez dans <a href="resultats.php">Résultats</a>.</div>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php include __DIR__ . '/inc/layout_end.php'; ?>
