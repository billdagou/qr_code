<?php
namespace Dagou\QrCode\ViewHelpers;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class GenerateViewHelper extends AbstractViewHelper {
    public function initializeArguments(): void {
        $this->registerArgument('data', 'string', 'Data of the QR code');
        $this->registerArgument('size', 'int', 'Size of the QR code');
        $this->registerArgument('margin', 'int', 'Margin size');
        $this->registerArgument('logo', FileReference::class, 'File reference of logo');
        $this->registerArgument('logoSize', 'int', 'Size of the logo');
        $this->registerArgument('logoMargin', 'int', 'Margin size of the logo');
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext
     *
     * @return string
     * @throws \TYPO3\CMS\Core\Resource\Exception\InsufficientFolderAccessPermissionsException
     * @throws \TYPO3\CMS\Core\Resource\Exception\InsufficientFolderReadPermissionsException
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext): string {
        $filename = md5($arguments['data']).'.png';

        /** @var \TYPO3\CMS\Core\Resource\Folder $foler */
        $folder = GeneralUtility::makeInstance(ResourceFactory::class)
            ->getDefaultStorage()
                ->getFolder('qr_code');

        if ($folder->hasFile($filename) === FALSE) {
            $qrCode = QrCode::create($arguments['data'] ?? $renderChildrenClosure());

            if ($arguments['size'] ?? FALSE) {
                $qrCode->setSize($arguments['size']);
            }

            if ($arguments['margin'] !== NULL) {
                $qrCode->setMargin($arguments['margin']);
            }

            if ($arguments['logo'] ?? FALSE) {
                $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::High);

                $logo = Logo::create(Environment::getPublicPath().'/'.$arguments['logo']->getPublicUrl())
                    ->setPunchoutBackground(TRUE)
                    ->setBackgroundColor(new Color(255, 255, 255));

                if ($arguments['logoSize'] ?? FALSE) {
                    $logo->setResizeToWidth($arguments['logoSize'])
                        ->setResizeToHeight($arguments['logoSize']);
                }

                if ($arguments['logoMargin'] !== NULL) {
                    $logo->setMargin($arguments['logoMargin']);
                }
            }

            (new PngWriter())->write($qrCode, $logo ?? NULL)
                ->saveToFile(Environment::getPublicPath().'/'.$folder->getPublicUrl().$filename);
        }

        return $folder->getPublicUrl().$filename;
    }
}