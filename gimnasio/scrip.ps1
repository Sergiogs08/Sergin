# Contenido nuevo de index.php, sin BOM
$code = @'
<?php declare(strict_types=1);
ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting(E_ALL);

// Alias al front-controller
require __DIR__ . '/router.php';
'@

# Sobrescribe index.php con UTF-8 sin BOM
$code | Out-File .\public\index.php -Encoding utf8NoBOM

# Verifica los primeros bytes
"Primeros bytes tras recrear:"; Get-Content .\public\index.php -Encoding Byte -TotalCount 3
