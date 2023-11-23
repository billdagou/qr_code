<?php
namespace Dagou\QrCode\ViewHelpers;

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
        $this->registerArgument('logo', FileReference::class, 'File reference of logo');
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
            $qrCode = QrCode::create($arguments['data']);

            if ($arguments['logo'] ?? FALSE) {
                $logo = Logo::create(Environment::getPublicPath().'/'.$arguments['logo']->getPublicUrl())
                    ->setResizeToWidth(50)
                    ->setResizeToHeight(50)
                    ->setPunchoutBackground(TRUE);
            }

            (new PngWriter())->write($qrCode, $logo ?? NULL)
                ->saveToFile(Environment::getPublicPath().'/'.$folder->getPublicUrl().$filename);
        }

        return $folder->getPublicUrl().$filename;
    }
}