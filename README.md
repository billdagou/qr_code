# TYPO3 Extension: QR Code

EXT:qr_code provides a ViewHelper to generate the QR code with [QR Code](https://github.com/endroid/qr-code) library.

**The extension version only matches the QR Code library version, it doesn't mean anything else.**

## How to use it

First of all, you need to install [QR Code](https://github.com/endroid/qr-code) via [Composer](https://getcomposer.org/) under `EXT:qr_code/Resources/Private/QrCode/`.

    cd typo3conf/ext/qr_code/Resources/Private/QrCode/
    composer install --no-dev --prefer-dist

After that, you can use the ViewHelper to generate the QR code.

    <f:image src="{qrcode:generate(data: '...')}" />

#### Attributes

- `data` (string) The data of the QR code.
- `logo` (FileReference) File reference of logo.