<?php
require 'config.php';
require __DIR__ . '/inc/auth.php';
require_login();

$page_title = 'Résultats';
$role = $_SESSION['role'] ?? '';
$user_id = (int)($_SESSION['id'] ?? 0);

$success = null;
$error = null;

// Prof can grade a submission
if ($role === 'professeur' && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['grade_id'])) {
    $grade_id = (int)$_POST['grade_id'];
    $note = trim($_POST['note'] ?? '');
    if ($note === '' || !is_numeric($note)) {
        $error = 'Veuillez entrer une note numérique.';
    } else {
        $up = $conn->prepare('UPDATE devoir_etudiant SET note=? WHERE id=?');
        if ($up->execute([$note, $grade_id])) {
            $success = 'Note enregistrée.';
        } else {
            $error = 'Erreur lors de l\'enregistrement.';
        }
    }
}

$q = trim($_GET['q'] ?? '');

if ($role === 'etudiant') {
    $sql = "
        SELECT de.id, de.original_filename, de.date_envoi, de.note,
               d.enonce_devoir, d.date_expiration,
               c.nom_cours
        FROM devoir_etudiant de
        JOIN devoir d ON de.id_devoir = d.id_devoir
        JOIN cours c ON d.id_cours = c.id
        WHERE de.id_etudiant = ?
        ORDER BY de.date_envoi DESC
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Prof view: all submissions (can be filtered)
    $sql = "
        SELECT de.id, de.original_filename, de.date_envoi, de.note,
               u.nom, u.postnom, u.prenom, u.email,
               d.enonce_devoir, d.date_expiration,
               c.nom_cours
        FROM devoir_etudiant de
        JOIN users u ON de.id_etudiant = u.id
        JOIN devoir d ON de.id_devoir = d.id_devoir
        JOIN cours c ON d.id_cours = c.id
        ORDER BY de.date_envoi DESC
    ";
    $rows = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

// Client-side filter (simple, fast)
if ($q !== '') {
    $rows = array_values(array_filter($rows, function($r) use ($q){
        $hay = strtolower(json_encode($r));
        return strpos($hay, strtolower($q)) !== false;
    }));
}

include __DIR__ . '/inc/layout_start.php';
?>

<div class="d-flex flex-wrap align-items-end justify-content-between gap-2 mb-4">
  <div>
    <h1 class="h3 mb-1">Résultats</h1>
    <div class="muted">Notes, dépôts et suivi de progression.</div>
  </div>
  <form class="d-flex gap-2" method="get">
    <input class="form-control" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Rechercher (cours, devoir, étudiant, email...)" />
    <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
  </form>
</div>

<?php if ($success): ?>
  <div class="alert alert-success app-card">✅ <?= htmlspecialchars($success) ?></div>
<?php endif; ?>
<?php if ($error): ?>
  <div class="alert alert-danger app-card">❌ <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="app-card p-3">
  <div class="table-responsive">
    <table class="table align-middle">
      <thead>
        <tr>
          <?php if ($role === 'professeur'): ?>
            <th>Étudiant</th>
            <th>Email</th>
          <?php endif; ?>
          <th>Cours</th>
          <th>Devoir</th>
          <th>Fichier</th>
          <th>Envoyé le</th>
          <th>Note</th>
          <?php if ($role === 'professeur'): ?>
            <th class="text-end">Action</th>
          <?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($rows)): ?>
          <tr><td colspan="9" class="muted">Aucun résultat.</td></tr>
        <?php endif; ?>
        <?php foreach ($rows as $r): ?>
          <tr>
            <?php if ($role === 'professeur'): ?>
              <td><?= htmlspecialchars(trim(($r['prenom'] ?? '').' '.($r['nom'] ?? ''))) ?></td>
              <td class="muted"><?= htmlspecialchars($r['email'] ?? '') ?></td>
            <?php endif; ?>
            <td><?= htmlspecialchars($r['nom_cours'] ?? '') ?></td>
            <td><?= htmlspecialchars($r['enonce_devoir'] ?? '') ?></td>
            <td>
              <span class="badge text-bg-secondary"><?= htmlspecialchars($r['original_filename'] ?? '') ?></span>
            </td>
            <td class="muted"><?= htmlspecialchars($r['date_envoi'] ?? '') ?></td>
            <td>
              <?php if ($r['note'] === null || $r['note'] === ''): ?>
                <span class="badge text-bg-warning">En attente</span>
              <?php else: ?>
                <span class="badge text-bg-success"><?= htmlspecialchars((string)$r['note']) ?></span>
              <?php endif; ?>
            </td>
            <?php if ($role === 'professeur'): ?>
              <td class="text-end">
                <form method="post" class="d-flex justify-content-end gap-2">
                  <input type="hidden" name="grade_id" value="<?= (int)$r['id'] ?>" />
                  <input class="form-control form-control-sm" style="max-width:120px" name="note" placeholder="Note" value="<?= htmlspecialchars((string)($r['note'] ?? '')) ?>" />
                  <button class="btn btn-sm btn-primary" type="submit"><i class="bi bi-check2"></i></button>
                </form>
              </td>
            <?php endif; ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . '/inc/layout_end.php'; ?>
