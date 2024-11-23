<?php

$host = env('GOTENBERG_HOST', '127.0.0.1');
$port = env('GOTENBERG_PORT', 3000);

return [

    # Gotenberg Server Host
    'host' => $host,

    # Gotenberg Server Port
    'port' => $port,

    # Gotenberg Server Uri
    'base_uri' => "http://$host:$port",
];
