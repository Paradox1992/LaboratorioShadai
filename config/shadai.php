<?php

return [
    'device_cookie' => env('SHADAI_DEVICE_COOKIE', 'shadai_device'),
    'device_token_ttl_minutes' => (int) env('SHADAI_DEVICE_TOKEN_TTL_MINUTES', 180),
];
