<?php
require 'config.php';

if (isset($_POST['submit'])) {
    $nom = trim($_POST['nom']);
    $postnom = trim($_POST['postnom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $etat = $_POST['etat'];
    $faculte = $_POST['faculte'];
    $cycle = $_POST['cycle'];
    $promotion = $_POST['promotion'];

    $sql = "INSERT INTO users (nom, postnom, prenom, email, mot_de_passe, etat, faculte, cycle, promotion)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt->execute([$nom, $postnom, $prenom, $email, $password, $etat, $faculte, $cycle, $promotion])) {
        header("Location: connexion.php");
        exit;
    } else {
        $error = "Erreur lors de l'inscription.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="css/inscription.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <div class="split-container">

        <div class="left">
            <h2>Créer un compte</h2>
            <p>Rejoignez notre communauté</p>

            <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

            <form method="POST">

                <div class="form-group">
                    <input type="text" name="nom" placeholder="Nom" required>
                    <span class="icon"><i class="fas fa-signature"></i></span>
                </div>

                <div class="form-group">
                    <input type="text" name="postnom" placeholder="Postnom" required>
                    <span class="icon"><i class="fas fa-signature"></i></span>
                </div>

                <div class="form-group">
                    <input type="text" name="prenom" placeholder="Prénom" required>
                    <span class="icon"><i class="fas fa-user"></i></span>
                </div>

                <div class="form-group">
                    <input type="email" name="email" placeholder="Email" required>
                    <span class="icon"><i class="fas fa-envelope"></i></span>
                </div>

                <div class="form-group">
                    <input type="password" name="password" placeholder="Mot de passe" required>
                    <span class="icon"><i class="fas fa-lock"></i></span>
                </div>

                <div class="form-group">
                    <select name="etat" required>
                        <option disabled selected>Statut</option>
                        <option value="etudiant">Étudiant</option>
                        <option value="professeur">Professeur</option>
                    </select>
                    <span class="icon"><i class="fas fa-id-badge"></i></span>
                </div>

                <div class="form-group">
                    <select name="faculte" required>
                        <option disabled selected>Faculté</option>
                        <option>Gestion, management et developpement</option>
                        <option>Sante publique</option>
                        <option>Science psychologique et de l'education</option>
                        <option>Sciences et techniques</option>
                        <option>Sciences informatiques</option>
                        <option>Theologie, philosophie et histoire</option>
                        <option>Sciences des Bio-ingenieurs</option>
                        <option>Science de l'information et de la communication</option>
                    </select>
                    <span class="icon"><i class="fas fa-graduation-cap"></i></span>
                </div>

                <div class="form-group">
                    <select name="cycle" id="cycle" required>
                        <option disabled selected>Cycle</option>
                        <option value="ancien">Ancien système</option>
                        <option value="lmd">LMD</option>
                    </select>
                    <span class="icon"><i class="fas fa-sync-alt"></i></span>
                </div>

                <div class="form-group">
                    <select name="promotion" id="promotion" required>
                        <option disabled selected>Promotion</option>
                    </select>
                    <span class="icon"><i class="fas fa-calendar-alt"></i></span>
                </div>

                <button type="submit" name="submit" class="btn">S'inscrire</button>
            </form>

            <a class="link" href="connexion.php">Déjà inscrit ? Connectez-vous</a>
        </div>

        <div class="right">
            <img src="images/fond_inscription.jpg" alt="Signup Illustration">
        </div>

    </div>

    <script>
        const cycleSelect = document.getElementById('cycle');
        const promotionSelect = document.getElementById('promotion');

        const promotions = {
            ancien: ['G1', 'G2', 'L1', 'L2', 'L3'],
            lmd: ['L1', 'L2', 'L3', 'Master 1', 'Master 2']
        };

        cycleSelect.addEventListener('change', () => {
            const cycle = cycleSelect.value;
            promotionSelect.innerHTML = '<option disabled selected>Promotion</option>';

            if (promotions[cycle]) {
                promotions[cycle].forEach(p => {
                    const option = document.createElement('option');
                    option.value = p;
                    option.textContent = p;
                    promotionSelect.appendChild(option);
                });
            }

            promotionSelect.classList.add("flash");
            setTimeout(() => promotionSelect.classList.remove("flash"), 600);
        });

        // Gestion focus/blur pour inputs et selects
        document.querySelectorAll("input, select").forEach(el => {
            el.addEventListener("focus", () => el.classList.add("focus"));
            el.addEventListener("blur", () => el.classList.remove("focus"));
        });

        // Effet bouton
        const btn = document.querySelector(".btn");
        if (btn) {
            btn.addEventListener("mouseenter", () => btn.style.transform = "scale(1.05)");
            btn.addEventListener("mouseleave", () => btn.style.transform = "scale(1)");
        }
    </script>
</body>
</html>