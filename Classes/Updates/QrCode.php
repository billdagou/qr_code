<?php
namespace Dagou\QrCode\Updates;

use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

class QrCode implements UpgradeWizardInterface {
    /**
     * @var \TYPO3\CMS\Core\Resource\ResourceFactory
     */
    protected $resourceFactory;

    /**
     * @param \TYPO3\CMS\Core\Resource\ResourceFactory $resourceFactory
     */
    public function __construct(ResourceFactory $resourceFactory) {
        $this->resourceFactory = $resourceFactory;
    }

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
        return '';
    }

    /**
     * @return bool
     * @throws \TYPO3\CMS\Core\Resource\Exception\ExistingTargetFolderException
     * @throws \TYPO3\CMS\Core\Resource\Exception\InsufficientFolderAccessPermissionsException
     * @throws \TYPO3\CMS\Core\Resource\Exception\InsufficientFolderWritePermissionsException
     */
    public function executeUpdate(): bool {
        $this->resourceFactory->getDefaultStorage()
            ->createFolder('qr_code');

        return TRUE;
    }

    /**
     * @return bool
     */
    public function updateNecessary(): bool {
        return $this->resourceFactory->getDefaultStorage()
            ->hasFolder('qr_code');
    }

    /**
     * @return array
     */
    public function getPrerequisites(): array {
        return [];
    }
}