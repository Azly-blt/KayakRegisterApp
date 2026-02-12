<?php
// Chargeur de .env (à mettre au début)
function loadEnv($path) {
    if (!file_exists($path)) {
        die("Fichier .env introuvable à l'emplacement : " . $path);
    }
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        
        // On nettoie les espaces et les guillemets
        $name = trim($name);
        $value = trim(trim($value), '"\''); 
        
        $_ENV[$name] = $value;
        putenv("$name=$value");
    }
}

loadEnv(__DIR__ . '/../.env');

// Récupération des variables
$host     = getenv('DB_HOST'); 
$port     = getenv('DB_PORT'); 
$dbname   = getenv('DB_NAME');
$user     = getenv('DB_USER');
$password = getenv('DB_PASS');

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";
    
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

} catch (PDOException $e) {

    die("Erreur de connexion à la base de données.");
}
?>