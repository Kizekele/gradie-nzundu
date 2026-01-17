<?php
require 'config.php';
require __DIR__ . '/inc/auth.php';
require_login();

$page_title = 'Profil';
$user_id = (int)$_SESSION['id'];

// Fetch current user
$stmt = $conn->prepare('SELECT id, nom, postnom, prenom, email, etat, faculte, cycle, promotion FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header('Location: deconnexion.php');
    exit;
}

$success = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $postnom = trim($_POST['postnom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $faculte = trim($_POST['faculte'] ?? '');
    $cycle = trim($_POST['cycle'] ?? '');
    $promotion = trim($_POST['promotion'] ?? '');

    if ($nom === '' || $postnom === '' || $prenom === '') {
        $error = 'Veuillez remplir les champs obligatoires.';
    } else {
        $up = $conn->prepare('UPDATE users SET nom=?, postnom=?, prenom=?, faculte=?, cycle=?, promotion=? WHERE id=?');
        $ok = $up->execute([$nom, $postnom, $prenom, $faculte, $cycle, $promotion, $user_id]);
        if ($ok) {
            $success = 'Profil mis à jour.';
            $stmt->execute([$user_id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $error = 'Erreur lors de la mise à jour.';
        }
    }
}

include __DIR__ . '/inc/layout_start.php';
?>

<div class="d-flex align-items-center justify-content-between mb-4">
  <div>
    <h1 class="h3 mb-1">Profil</h1>
    <div class="muted">Gérez vos informations personnelles et votre compte.</div>
  </div>
</div>

<?php if ($success): ?>
  <div class="alert alert-success app-card">✅ <?= htmlspecialchars($success) ?></div>
<?php endif; ?>
<?php if ($error): ?>
  <div class="alert alert-danger app-card">❌ <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="row g-3">
  <div class="col-lg-5">
    <div class="app-card p-3">
      <div class="d-flex align-items-center gap-3">
        <div class="kpi-icon"><i class="bi bi-person-badge"></i></div>
        <div>
          <div class="muted">Compte</div>
          <div class="fw-bold"><?= htmlspecialchars($user['prenom'].' '.$user['nom']) ?></div>
          <div class="muted small"><?= htmlspecialchars($user['email']) ?> · <?= htmlspecialchars(ucfirst($user['etat'])) ?></div>
        </div>
      </div>
      <hr class="border-opacity-25" />
      <div class="muted small">Astuce : gardez vos infos à jour pour recevoir les notifications et accéder rapidement aux cours.</div>
    </div>
  </div>
  <div class="col-lg-7">
    <div class="app-card p-3">
      <h2 class="h5 mb-3">Modifier mes informations</h2>
      <form method="post" class="row g-3">
        <div class="col-md-4">
          <label class="form-label">Nom *</label>
          <input class="form-control" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" required />
        </div>
        <div class="col-md-4">
          <label class="form-label">Postnom *</label>
          <input class="form-control" name="postnom" value="<?= htmlspecialchars($user['postnom']) ?>" required />
        </div>
        <div class="col-md-4">
          <label class="form-label">Prénom *</label>
          <input class="form-control" name="prenom" value="<?= htmlspecialchars($user['prenom']) ?>" required />
        </div>
        <div class="col-md-6">
          <label class="form-label">Faculté</label>
          <input class="form-control" name="faculte" value="<?= htmlspecialchars($user['faculte'] ?? '') ?>" />
        </div>
        <div class="col-md-3">
          <label class="form-label">Cycle</label>
          <input class="form-control" name="cycle" value="<?= htmlspecialchars($user['cycle'] ?? '') ?>" />
        </div>
        <div class="col-md-3">
          <label class="form-label">Promotion</label>
          <input class="form-control" name="promotion" value="<?= htmlspecialchars($user['promotion'] ?? '') ?>" />
        </div>
        <div class="col-12 d-flex justify-content-end gap-2">
          <a class="btn btn-outline-secondary" href="index.php">Annuler</a>
          <button class="btn btn-primary" type="submit"><i class="bi bi-save"></i> Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include __DIR__ . '/inc/layout_end.php'; ?>
