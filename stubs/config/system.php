<?php

return [
    'extensionsPath' => '/extensions',
    'linkPolicy' => env('LINK_POLICY', 'detect'),
    'enableCsrfProtection' => env('ENABLE_CSRF', TRUE),
];
