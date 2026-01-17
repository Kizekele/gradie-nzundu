<?php
require 'config.php';
require __DIR__ . '/inc/auth.php';
require_login();

$page_title = 'Cours';
$q = trim($_GET['q'] ?? '');

$stmt = $conn->query('SELECT * FROM cours ORDER BY created_at DESC');
$cours = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($q !== '') {
  $cours = array_values(array_filter($cours, function($c) use ($q){
    $hay = strtolower(($c['nom_cours'] ?? '').' '.($c['nom_prof'] ?? '').' '.($c['ressources'] ?? ''));
    return strpos($hay, strtolower($q)) !== false;
  }));
}

include __DIR__ . '/inc/layout_start.php';
?>

<div class="d-flex flex-wrap align-items-end justify-content-between gap-2 mb-4">
  <div>
    <h1 class="h3 mb-1">Cours</h1>
    <div class="muted">Consultez vos cours et ressources. Recherche ultra rapide.</div>
  </div>
  <form class="d-flex gap-2" method="get">
    <input class="form-control" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Rechercher (cours, professeur...)" />
    <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
  </form>
</div>

<?php if (empty($cours)): ?>
  <div class="app-card p-3 muted">Aucun cours pour le moment.</div>
<?php else: ?>
  <div class="row g-3">
    <?php foreach ($cours as $c): ?>
      <div class="col-md-6 col-xl-4">
        <div class="app-card p-3 h-100">
          <div class="d-flex justify-content-between align-items-start gap-2">
            <div>
              <div class="fw-bold fs-5"><?= htmlspecialchars($c['nom_cours'] ?? '') ?></div>
              <div class="muted small"><i class="bi bi-person-fill"></i> <?= htmlspecialchars($c['nom_prof'] ?? '—') ?></div>
            </div>
            <span class="badge text-bg-secondary">Cours</span>
          </div>

          <hr class="border-opacity-25" />

          <?php if (!empty($c['ressources'])): ?>
            <div class="mb-2">
              <div class="muted small">Ressource</div>
              <a class="link-light link-underline-opacity-0" target="_blank" href="<?= htmlspecialchars($c['ressources']) ?>">
                <i class="bi bi-link-45deg"></i> Ouvrir la ressource
              </a>
            </div>
          <?php endif; ?>

          <?php if (!empty($c['note'])): ?>
            <div>
              <div class="muted small">Document</div>
              <a class="btn btn-sm btn-outline-danger" target="_blank" href="notes/<?= htmlspecialchars($c['note']) ?>">
                <i class="bi bi-file-earmark-pdf-fill"></i> Télécharger PDF
              </a>
            </div>
          <?php else: ?>
            <div class="muted small">Aucun document associé pour l’instant.</div>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php include __DIR__ . '/inc/layout_end.php'; ?>
