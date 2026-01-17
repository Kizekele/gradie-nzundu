<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$current = basename($_SERVER['PHP_SELF'] ?? 'index.php');
$role = $_SESSION['role'] ?? null;
$email = $_SESSION['email'] ?? null;

function nav_active(string $file, string $current): string {
    return $file === $current ? 'active' : '';
}
?>

<aside class="app-sidebar" id="appSidebar">
  <div class="app-sidebar__brand">
    <div class="brand-mark">
      <i class="bi bi-mortarboard-fill"></i>
    </div>
    <div class="brand-text">
      <div class="brand-name">EduSpace</div>
      <div class="brand-sub">E-learning · Devoirs · Calendrier</div>
    </div>
  </div>

  <div class="app-sidebar__user">
    <div class="user-avatar">
      <i class="bi bi-person-circle"></i>
    </div>
    <div class="user-meta">
      <div class="user-email"><?= $email ? htmlspecialchars($email) : 'Invité' ?></div>
      <div class="user-role"><?= $role ? htmlspecialchars(ucfirst($role)) : 'Non connecté' ?></div>
    </div>
  </div>

  <nav class="app-nav">
    <a class="app-nav__link <?= nav_active('index.php', $current) ?>" href="index.php">
      <i class="bi bi-grid-1x2-fill"></i><span>Dashboard</span>
    </a>
    <a class="app-nav__link <?= nav_active('cours.php', $current) ?>" href="cours.php">
      <i class="bi bi-journal-bookmark-fill"></i><span>Cours</span>
    </a>
    <a class="app-nav__link <?= nav_active('devoirs.php', $current) ?>" href="devoirs.php">
      <i class="bi bi-pencil-square"></i><span>Devoirs</span>
    </a>
    <a class="app-nav__link <?= nav_active('calendrier.php', $current) ?>" href="calendrier.php">
      <i class="bi bi-calendar-event-fill"></i><span>Calendrier</span>
    </a>
    <a class="app-nav__link <?= nav_active('resultats.php', $current) ?>" href="resultats.php">
      <i class="bi bi-bar-chart-fill"></i><span>Résultats</span>
    </a>
    <a class="app-nav__link <?= nav_active('profil.php', $current) ?>" href="profil.php">
      <i class="bi bi-person-badge-fill"></i><span>Profil</span>
    </a>
  </nav>

  <div class="app-sidebar__footer">
    <button class="btn btn-sm btn-outline-secondary w-100 mb-2" id="themeToggle" type="button">
      <i class="bi bi-moon-stars"></i> <span>Thème</span>
    </button>

    <?php if ($role): ?>
      <a class="btn btn-sm btn-outline-danger w-100" href="deconnexion.php">
        <i class="bi bi-box-arrow-right"></i> Déconnexion
      </a>
    <?php else: ?>
      <a class="btn btn-sm btn-primary w-100" href="connexion.php">
        <i class="bi bi-box-arrow-in-right"></i> Connexion
      </a>
    <?php endif; ?>
  </div>
</aside>

<button class="app-sidebar-toggle" id="sidebarToggle" type="button" aria-label="Menu">
  <i class="bi bi-list"></i>
</button>