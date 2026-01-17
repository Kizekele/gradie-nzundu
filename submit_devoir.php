<?php
session_start();
require 'config.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'etudiant') {
    header("Location: connexion.php");
    exit;
}

$id_etudiant = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_devoir = intval($_POST['id_devoir']);

    // Vérifier le devoir
    $stmt = $conn->prepare("SELECT * FROM devoir WHERE id_devoir = ?");
    $stmt->execute([$id_devoir]);
    $devoir = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$devoir) {
        die("Devoir introuvable.");
    }

    // Vérifier la date d'expiration
    $date_expiration = new DateTime($devoir['date_expiration']);
    $now = new DateTime();
    if ($now > $date_expiration) {
        die("La date d'expiration est dépassée, vous ne pouvez plus déposer.");
    }

    // Vérifier s'il a déjà déposé
    $stmt = $conn->prepare("SELECT * FROM devoir_etudiant WHERE id_devoir = ? AND id_etudiant = ?");
    $stmt->execute([$id_devoir, $id_etudiant]);
    if ($stmt->fetch()) {
        die("Vous avez déjà déposé ce devoir.");
    }

    // Vérifier le fichier
    if (!isset($_FILES['fichier']) || $_FILES['fichier']['error'] !== UPLOAD_ERR_OK) {
        die("Erreur lors de l'upload du fichier.");
    }

    $file_tmp = $_FILES['fichier']['tmp_name'];
    $original_name = $_FILES['fichier']['name'];
    $mime_type = mime_content_type($file_tmp);
    $size_bytes = $_FILES['fichier']['size'];

    // Limiter la taille max (ex: 10Mo)
    if ($size_bytes > 10 * 1024 * 1024) {
        die("Fichier trop volumineux.");
    }

    // Autoriser certains types
    $allowed_types = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
    if (!in_array($mime_type, $allowed_types)) {
        die("Type de fichier non autorisé. Autorisé : PDF, DOC, DOCX.");
    }

    // Créer un nom unique pour le fichier
    $extension = pathinfo($original_name, PATHINFO_EXTENSION);
    $new_name = uniqid('devoir_') . '.' . $extension;

    $upload_dir = 'uploads/devoirs/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    if (move_uploaded_file($file_tmp, $upload_dir . $new_name)) {
        // Enregistrer dans la BDD
        $stmt = $conn->prepare("
            INSERT INTO devoir_etudiant 
            (id_devoir, id_etudiant, fichier, original_filename, mime_type, size_bytes, date_envoi)
            VALUES (?, ?, ?, ?, ?, ?, NOW())
        ");
        $stmt->execute([$id_devoir, $id_etudiant, $new_name, $original_name, $mime_type, $size_bytes]);

        // Redirection avec succès
        header("Location: devoirs.php?success=1");
        exit;
    } else {
        die("Erreur lors de l'enregistrement du fichier sur le serveur.");
    }
} else {
    die("Méthode non autorisée.");
}
