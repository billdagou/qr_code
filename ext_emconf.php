<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'QR Code',
    'description' => 'QR Code, https://github.com/endroid/qr-code',
    'category' => 'misc',
    'author' => 'Bill.Dagou',
    'author_email' => 'billdagou@gmail.com',
    'version' => '5.0.0',
    'state' => 'stable',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-12.4.99',
        ],
    ],
    'autoload' => [
        'classmap' => [
            'Classes',
            'Resources/Private/QrCode',
        ],
    ],
];