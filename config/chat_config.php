<?php
// config/chat_config.php
$config = require __DIR__ . '/config.php';
return [
    'chatId' => getenv('CHAT_ID') ?: '-5180034812',
    'botToken' => getenv('BOT_TOKEN') ?: '8634923330:AAH31BhUWH8O2LuD9IQdwZyUTUyc0Ij-Hxo'
];
?>
