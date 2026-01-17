<?php
session_start();
require 'config.php';

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

if ($user && password_verify($password, $user["mot_de_passe"])) {
    $_SESSION['id'] = $user['id'];          // <-- Ajouter ceci
    $_SESSION['role'] = $user['etat'];      // <-- Ajouter ceci ('etudiant' ou 'professeur')
    $_SESSION['email'] = $email;            // tu peux garder l'email
    header("Location: index.php");          // ou devoirs.php?id_cours=1
    exit;
}
else {
        $error = "Email ou mot de passe incorrect";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="css/connexion.css"> <!-- Nouveau CSS -->
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <div class="split-container">

        <!-- SECTION FORMULAIRE -->
        <div class="left">
            <h2>User Login</h2>
            <p>Login to your account</p>

            <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

            <form method="POST">
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email" required>
                    <span class="icon"><i class="fas fa-user"></i></span>
                </div>

                <div class="form-group">
                    <input type="password" name="password" placeholder="Mot de passe" required>
                    <span class="icon"><i class="fas fa-lock"></i></span>
                </div>

                <button type="submit" name="login" class="btn">Login</button>
            </form>

            <a class="link" href="inscription.php">Créer un compte</a>
            
        </div>

        <!-- IMAGE ILLUSTRATION -->
        <div class="right">
            <img src="images/fond_connexion.jpg" alt="Login Illustration">
        </div>

    </div>

    <!-- ANIMATIONS JS -->
    <script>
        document.querySelectorAll("input").forEach(el => {
            el.addEventListener("focus", () => el.classList.add("focus"));
            el.addEventListener("blur", () => el.classList.remove("focus"));
        });

        const btn = document.querySelector(".btn");
        btn.addEventListener("mouseenter", () => btn.style.transform = "scale(1.05)");
        btn.addEventListener("mouseleave", () => btn.style.transform = "scale(1)");
    </script>

</body>
</html>