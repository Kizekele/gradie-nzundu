<?php
require 'config.php';
require __DIR__ . '/inc/auth.php';
require_login();

$page_title = 'Dashboard';
$role = $_SESSION['role'] ?? '';
$user_id = (int)($_SESSION['id'] ?? 0);

function safe_count(PDO $conn, string $sql, array $params = []): int {
  try {
    $st = $conn->prepare($sql);
    $st->execute($params);
    return (int)$st->fetchColumn();
  } catch (Throwable $e) {
    return 0;
  }
}

$nb_cours = safe_count($conn, 'SELECT COUNT(*) FROM cours');
$nb_devoirs = safe_count($conn, 'SELECT COUNT(*) FROM devoir');

if ($role === 'etudiant') {
  $nb_depots = safe_count($conn, 'SELECT COUNT(*) FROM devoir_etudiant WHERE id_etudiant = ?', [$user_id]);
  $en_attente = safe_count($conn, 'SELECT COUNT(*) FROM devoir_etudiant WHERE id_etudiant = ? AND (note IS NULL OR note = "")', [$user_id]);
} else {
  $nb_depots = safe_count($conn, 'SELECT COUNT(*) FROM devoir_etudiant');
  $en_attente = safe_count($conn, 'SELECT COUNT(*) FROM devoir_etudiant WHERE (note IS NULL OR note = "")');
}

// Upcoming events (next 5)
$events = [];
try {
  $st = $conn->query('SELECT titre, date_debut, date_fin FROM calendrier ORDER BY date_debut ASC LIMIT 5');
  $events = $st->fetchAll(PDO::FETCH_ASSOC);
} catch (Throwable $e) {
  $events = [];
}

include __DIR__ . '/inc/layout_start.php';
?>

<div class="d-flex flex-wrap align-items-end justify-content-between gap-2 mb-4">
  <div>
    <h1 class="h3 mb-1">Dashboard</h1>
    <div class="muted">Bienvenue sur EduSpace. Tout ton espace académique, au même endroit.</div>
  </div>
  <div class="d-flex gap-2">
    <a class="btn btn-outline-secondary" href="cours.php"><i class="bi bi-journal-bookmark-fill"></i> Voir les cours</a>
    <a class="btn btn-primary" href="devoirs.php"><i class="bi bi-pencil-square"></i> Devoirs</a>
  </div>
</div>

<div class="row g-3 mb-3">
  <div class="col-md-6 col-xl-3">
    <div class="app-card p-3">
      <div class="kpi">
        <div class="kpi-icon"><i class="bi bi-journal-bookmark-fill"></i></div>
        <div>
          <div class="kpi-label">Cours</div>
          <div class="kpi-value"><?= $nb_cours ?></div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-xl-3">
    <div class="app-card p-3">
      <div class="kpi">
        <div class="kpi-icon"><i class="bi bi-clipboard2-check"></i></div>
        <div>
          <div class="kpi-label">Devoirs</div>
          <div class="kpi-value"><?= $nb_devoirs ?></div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-xl-3">
    <div class="app-card p-3">
      <div class="kpi">
        <div class="kpi-icon"><i class="bi bi-upload"></i></div>
        <div>
          <div class="kpi-label"><?= $role === 'etudiant' ? 'Mes dépôts' : 'Dépôts' ?></div>
          <div class="kpi-value"><?= $nb_depots ?></div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-xl-3">
    <div class="app-card p-3">
      <div class="kpi">
        <div class="kpi-icon"><i class="bi bi-hourglass-split"></i></div>
        <div>
          <div class="kpi-label">En attente</div>
          <div class="kpi-value"><?= $en_attente ?></div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row g-3">
  <div class="col-lg-7">
    <div class="app-card p-3">
      <div class="d-flex align-items-center justify-content-between mb-2">
        <h2 class="h5 mb-0">Raccourcis</h2>
        <span class="badge text-bg-secondary">Rapide</span>
      </div>
      <div class="row g-2">
        <div class="col-md-6">
          <a class="app-card p-3 d-block text-decoration-none" href="devoirs.php">
            <div class="d-flex gap-2 align-items-center">
              <i class="bi bi-pencil-square"></i>
              <div>
                <div class="fw-bold">Soumettre / Voir les devoirs</div>
                <div class="muted small">Suivi complet des deadlines</div>
              </div>
            </div>
          </a>
        </div>
        <div class="col-md-6">
          <a class="app-card p-3 d-block text-decoration-none" href="resultats.php">
            <div class="d-flex gap-2 align-items-center">
              <i class="bi bi-bar-chart-fill"></i>
              <div>
                <div class="fw-bold">Résultats</div>
                <div class="muted small">Notes, dépôts et progression</div>
              </div>
            </div>
          </a>
        </div>
        <div class="col-md-6">
          <a class="app-card p-3 d-block text-decoration-none" href="calendrier.php">
            <div class="d-flex gap-2 align-items-center">
              <i class="bi bi-calendar-event-fill"></i>
              <div>
                <div class="fw-bold">Calendrier</div>
                <div class="muted small">Cours, deadlines, rappels</div>
              </div>
            </div>
          </a>
        </div>
        <div class="col-md-6">
          <a class="app-card p-3 d-block text-decoration-none" href="profil.php">
            <div class="d-flex gap-2 align-items-center">
              <i class="bi bi-person-badge-fill"></i>
              <div>
                <div class="fw-bold">Profil</div>
                <div class="muted small">Mettre à jour vos informations</div>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-5">
    <div class="app-card p-3">
      <div class="d-flex align-items-center justify-content-between mb-2">
        <h2 class="h5 mb-0">Prochains événements</h2>
        <a class="btn btn-sm btn-outline-secondary" href="calendrier.php">Voir</a>
      </div>
      <?php if (empty($events)): ?>
        <div class="muted">Aucun événement disponible.</div>
      <?php else: ?>
        <div class="list-group list-group-flush">
          <?php foreach ($events as $e): ?>
            <div class="list-group-item bg-transparent border-0 px-0">
              <div class="fw-bold"><?= htmlspecialchars($e['titre'] ?? '') ?></div>
              <div class="muted small"><?= htmlspecialchars($e['date_debut'] ?? '') ?> → <?= htmlspecialchars($e['date_fin'] ?? '') ?></div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php include __DIR__ . '/inc/layout_end.php'; ?>
