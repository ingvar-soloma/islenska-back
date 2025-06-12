<?php

return [

'paths' => ['get_audio/*', 'get_image/*', 'api/*', 'sanctum/csrf-cookie'],

'allowed_methods' => ['*'],

'allowed_origins' => ['http://localhost:5173', 'https://vikinglingo.online'],

'allowed_origins_patterns' => [],

'allowed_headers' => ['*'],

'exposed_headers' => ['Content-Disposition'],

'max_age' => 0,

'supports_credentials' => true,

];
