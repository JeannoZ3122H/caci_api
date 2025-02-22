<?php
try {
    // Exécutez la commande `route:clear`
    echo "Clearing route cache...<br>";
    echo shell_exec('php artisan route:clear');
    echo "Route cache cleared successfully!<br>";

    // (Optionnel) Effacez également d'autres caches si nécessaire
    echo "Clearing config cache...<br>";
    echo shell_exec('php artisan config:clear');
    echo "Config cache cleared successfully!<br>";

    echo "Clearing view cache...<br>";
    echo shell_exec('php artisan view:clear');
    echo "View cache cleared successfully!<br>";

    echo "Clearing application cache...<br>";
    echo shell_exec('php artisan cache:clear');
    echo "Application cache cleared successfully!";
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}
?>
