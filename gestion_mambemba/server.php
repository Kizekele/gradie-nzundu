<?php

/**
 * ============================================
 *  SERVER.PHP — Routeur pour le serveur PHP 
 *  intégré (php artisan serve / php -S)
 * ============================================
 * 
 * Ce fichier permet au serveur PHP intégré de 
 * servir les fichiers statiques et de rediriger
 * les requêtes vers le front controller (index.php)
 * de Laravel.
 * 
 * @see https://laravel.com/docs/11.x
 * ============================================
 */

// Répertoire public du projet
$publicPath = __DIR__ . '/public';

// Si la requête est pour un fichier statique existant,
// on le sert directement
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Vérifier si le fichier statique existe
if ($uri !== '/' && file_exists($publicPath . $uri)) {
    return false;
}

// Sinon, on passe la main à Laravel (index.php)
require_once $publicPath . '/index.php';
