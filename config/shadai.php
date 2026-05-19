<?php

return [
    'device_cookie' => env('SHADAI_DEVICE_COOKIE', 'shadai_device'),
    'device_fingerprint_cookie' => env('SHADAI_DEVICE_FINGERPRINT_COOKIE', 'shadai_device_fingerprint'),
    'device_token_ttl_minutes' => (int) env('SHADAI_DEVICE_TOKEN_TTL_MINUTES', 180),
];
