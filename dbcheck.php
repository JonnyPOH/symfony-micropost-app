<?php
require __DIR__ . '/vendor/autoload.php';

use App\Kernel;
use Symfony\Component\Dotenv\Dotenv;

if (file_exists(__DIR__.'/.env')) {
    (new Dotenv())->usePutenv()->bootEnv(__DIR__.'/.env');
}

$kernel = new Kernel($_SERVER['APP_ENV'] ?? 'dev', true);
$kernel->boot();

$container = $kernel->getContainer();
$conn = $container->get('doctrine')->getConnection();

$platform = $conn->getDatabasePlatform();

echo "Platform class: " . get_class($platform) . PHP_EOL;
echo "Database name: " . $conn->getDatabase() . PHP_EOL;

try {
    $version = $conn->fetchOne('SELECT VERSION()');
    echo "SELECT VERSION(): " . $version . PHP_EOL;
} catch (\Throwable $e) {
    echo "VERSION() query failed: " . $e->getMessage() . PHP_EOL;
}
