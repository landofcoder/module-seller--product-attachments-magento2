<?php

declare(strict_types = 1);

/**
 * File: Upload.php
 *
 * @author Bartosz Kubicki bartosz.kubicki@lizardmedia.pl>
 * @copyright Copyright (C) 2018 Lizard Media (http://lizardmedia.pl)
 */

namespace Lofmp\ProductAttachment\Controller\Marketplace\Attachment\File;

use Exception;
use LizardMedia\ProductAttachment\Api\Data\AttachmentInterface;
use LizardMedia\ProductAttachment\Model\Attachment;
use Magento\Framework\App\Action\Context;
use Magento\Downloadable\Controller\Adminhtml\Downloadable\File;
use Magento\Downloadable\Helper\File as FileHelper;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\FileSystemException;
use Magento\MediaStorage\Helper\File\Storage\Database;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Customer\Model\Session;
use Lof\MarketPlace\Model\SellerFactory;
use Magento\Customer\Model\Url as CustomerUrl;
use Magento\Framework\Url;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Store\Model\StoreManagerInterface;
use Lofmp\ProductAttachment\Helper\Data;

/**
 * Class Upload
 * @package Lofmp\ProductAttachment\Controller\Marketplace\Attachment\Upload
 */
class Upload extends \Lofmp\ProductAttachment\Controller\Marketplace\Upload
{
    /**
     * @var string
     */
    const DOWNLOADABLE_ATTACHEMENT_TYPE = 'attachments';

    /**
     * @var AttachmentInterface
     */
    private $attachment;

    /**
     * @var FileHelper
     */
    private $fileHelper;

    /**
     * @var Database
     */
    private $storageDatabase;

    /**
     * @var UploaderFactory
     */
    private $uploaderFactory;

    /**
     * @param AttachmentInterface $attachment
     * @param FileHelper $fileHelper
     * @param Database $storageDatabase
     * @param UploaderFactory $uploaderFactory
     * @param Context $context
     * @param Session $customerSession
     * @param CustomerUrl $customerUrl
     * @param Filter $filter
     * @param Url $frontendUrl
     * @param SellerFactory $sellerFactory
     * @param Data|null $helperData
     * @param DataPersistorInterface|null $dataPersistor
     * @param StoreManagerInterface|null $storeManager
     */
    public function __construct(
        AttachmentInterface $attachment,
        FileHelper $fileHelper,
        Database $storageDatabase,
        UploaderFactory $uploaderFactory,
        Context $context,
        Session $customerSession,
        CustomerUrl $customerUrl,
        Filter $filter,
        Url $frontendUrl,
        SellerFactory $sellerFactory,
        Data $helperData = null,
        DataPersistorInterface $dataPersistor = null,
        StoreManagerInterface $storeManager = null
    ) {
        parent::__construct($context, $customerSession, $customerUrl, $filter, $frontendUrl, $sellerFactory, $helperData, $dataPersistor, $storeManager);
        $this->attachment = $attachment;
        $this->fileHelper = $fileHelper;
        $this->uploaderFactory = $uploaderFactory;
        $this->storageDatabase = $storageDatabase;
    }

    /**
     * @return ResultInterface
     */
    public function execute() : ResultInterface
    {
        $type = $this->getRequest()->getParam(Attachment::ATTACHMENT_TYPE);
        $tmpPath = '';

        if ($type === self::DOWNLOADABLE_ATTACHEMENT_TYPE) {
            $tmpPath = $this->attachment->getBaseTmpPath();
        }

        try {
            $uploader = $this->uploaderFactory->create(['fileId' => $type]);
            $result = $this->fileHelper->uploadFromTmp($tmpPath, $uploader);

            if (!$result) {
                throw new FileSystemException(__('File can not be moved from temporary folder to the destination folder.'));
            }

            unset($result['tmp_name'], $result['path']);

            if (isset($result[Attachment::ATTACHMENT_FILE])) {
                $relativePath = rtrim(
                    $tmpPath,
                    DIRECTORY_SEPARATOR
                )
                . DIRECTORY_SEPARATOR . ltrim($result[Attachment::ATTACHMENT_FILE], DIRECTORY_SEPARATOR);

                $this->storageDatabase->saveFile($relativePath);
            }

            $result['cookie'] = [
                'name' => $this->_getSession()->getName(),
                'value' => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path' => $this->_getSession()->getCookiePath(),
                'domain' => $this->_getSession()->getCookieDomain(),
            ];
        } catch (Exception $exception) {
            $result = ['error' => $exception->getMessage(), 'errorcode' => $exception->getCode()];
        }

        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
