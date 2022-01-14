<?php
namespace Dagou\QrCode\Updates;

use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

class QrCode implements UpgradeWizardInterface {
    /**
     * @return string
     */
    public function getIdentifier(): string {
        return 'qr_code';
    }

    /**
     * @return string
     */
    public function getTitle(): string {
        return 'Install extension "qr_code"';
    }

    /**
     * @return string
     */
    public function getDescription(): string {
        return 'The extension "qr_code" provides a ViewHelper to generate the QR code.';
    }

    /**
     * @return bool
     * @throws \TYPO3\CMS\Core\Resource\Exception\ExistingTargetFolderException
     * @throws \TYPO3\CMS\Core\Resource\Exception\InsufficientFolderAccessPermissionsException
     * @throws \TYPO3\CMS\Core\Resource\Exception\InsufficientFolderWritePermissionsException
     */
    public function executeUpdate(): bool {
        GeneralUtility::makeInstance(ResourceFactory::class)
            ->getDefaultStorage()
                ->createFolder('qr_code');

        return TRUE;
    }

    /**
     * @return bool
     */
    public function updateNecessary(): bool {
        return !GeneralUtility::makeInstance(ResourceFactory::class)
            ->getDefaultStorage()
                ->hasFolder('qr_code');
    }

    /**
     * @return array
     */
    public function getPrerequisites(): array {
        return [];
    }
}