<?php

return [
    'key' => env('WHATSAPP_API_KEY'),
    'sender' => env('WHATSAPP_API_SENDER'),
    'device' => env('WHATSAPP_API_DEVICE'),
    'url' => env('WHATSAPP_API_URL', 'https://kedeka.com/api'),
    'enable' => env('WHATSAPP_API_ENABLE') ?: false,
    'receipts' => explode(',', env('WHATSAPP_API_RECEIPTS', '082254417914')),
    'timeout' => env('WHATSAPP_API_TIMEOUT') ?: 120,
    'otp' => [
        'timeout' => 2,
    ],
    'default_footer' => fn () => ('*Ini adalah pesan otomatis, jangan membalas ke nomor ini*'
                .PHP_EOL
                .PHP_EOL.'jika ada pertanyaan silakan hubungi kontak varianiaga samarinda berikut'
                .PHP_EOL.'082393379788 (Yayat)'
                .PHP_EOL.'085247533131 (Dewi)'
                .PHP_EOL.'Informasi pengambilan'
                .PHP_EOL.'Buka Senin-Sabtu'
                .PHP_EOL.'Jam Pelayanan 09:00-15:00 WITA'
                .PHP_EOL.'Jl. Teuku Umar (Komplek Pergudangan) Rusunawa II, Sei. Kunjang'),
];
