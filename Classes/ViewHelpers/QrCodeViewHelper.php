<?php
namespace Dagou\QrCode\ViewHelpers;

use Endroid\QrCode\QrCode;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class QrCodeViewHelper extends AbstractViewHelper {
    public function initializeArguments() {
        $this->registerArgument('data', 'string', 'Data of the QR code.');
        $this->registerArgument('logo', FileReference::class, 'Logo');
    }

    /**
     * @return string
     */
    public function render(): string {
        $filename = $this->getIdentifier($this->arguments['data']).'.png';

        /** @var \TYPO3\CMS\Core\Resource\Folder $folder */
        $folder = GeneralUtility::makeInstance(ResourceFactory::class)
            ->getDefaultStorage()
                ->getFolder('qr_code');

        if (!$folder->hasFile($filename)) {
            $qrCode = new QrCode($this->arguments['data'] ?? $this->renderChildren());

            $qrCode->setWriterByName('png');

            if ($this->arguments['logo']) {
                $qrCode->setLogoPath(Environment::getPublicPath().'/'.$this->arguments['logo']->getPublicUrl());
                $qrCode->setLogoSize(150, 200);
            }

            $qrCode->writeFile(Environment::getPublicPath().'/'.$folder->getPublicUrl().$filename);
        }

        return $folder->getPublicUrl().$filename;
    }

    protected function getIdentifier(string $data): string {
        return md5($data);
    }
}