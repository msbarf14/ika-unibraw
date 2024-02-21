<?php

// config for Kedeka/WhatsappOtp
return [
    'table' => 'otps', // migration table name
    'expired' => 2, // in minutes
    'length' => 4, // length of otp
    'type' => \Kedeka\WhatsappOtp\Enums\OtpType::Number, // type of otp (number, string, alphanumeric)
    'message' => [ // message template
        'image' => null, // you can pass image url
        'text' => '%d Adalah Kode OTP Anda '
                    .PHP_EOL
                    .env('APP_URL'),
        'footer' => null, // you can add footer
    ],
];
