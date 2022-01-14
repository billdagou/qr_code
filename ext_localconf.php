<?php
defined('TYPO3_MODE') || die();

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['qr_code'] = \Dagou\QrCode\Updates\QrCode::class;

$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['qrcode'] = [
    'Dagou\\QrCode\\ViewHelpers',
];