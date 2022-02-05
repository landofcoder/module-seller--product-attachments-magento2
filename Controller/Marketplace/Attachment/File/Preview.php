<?php

declare(strict_types = 1);

/**
 * File: Preview.php
 *
 * @author Bartosz Kubicki bartosz.kubicki@lizardmedia.pl>
 * @copyright Copyright (C) 2018 Lizard Media (http://lizardmedia.pl)
 */

namespace Lofmp\ProductAttachment\Controller\Marketplace\Attachment\File;


use LizardMedia\ProductAttachment\Api\AttachmentRepositoryInterface;
use LizardMedia\ProductAttachment\Api\Data\AttachmentInterface;
use LizardMedia\ProductAttachment\Controller\DownloadProcessor;
use LizardMedia\ProductAttachment\Model\Attachment;
use Magento\Framework\App\Action\Context;;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\NoSuchEntityException;
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
 * Class Preview
 * @package Lofmp\ProductAttachment\Controller\Marketplace\Attachment\File
 */
class Preview extends \Lofmp\ProductAttachment\Controller\Marketplace\Preview
{
    /**
     * @var AttachmentRepositoryInterface
     */
    private $attachmentRepository;

    /**
     * @var DownloadProcessor
     */
    private $downloadProcessor;

    /**
     * @param AttachmentRepositoryInterface $attachmentRepository
     * @param DownloadProcessor $downloadProcessor
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
        AttachmentRepositoryInterface $attachmentRepository,
        DownloadProcessor $downloadProcessor,
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
        $this->attachmentRepository = $attachmentRepository;
        $this->downloadProcessor = $downloadProcessor;
    }

    /**
     * @return ResponseInterface
     */
    public function execute(): ResponseInterface
    {
        $attachmentId = $this->getRequest()->getParam(Attachment::ID, 0);
        $attachment = $this->loadAttachmentById((int) $attachmentId);
        if ($attachment instanceof AttachmentInterface) {
            try {
                $this->downloadProcessor->processDownload($attachment);
                return $this->_response;
            } catch (FileSystemException $exception) {
                $this->messageManager->addErrorMessage(__('Sorry, there was an error getting requested content.'));
            }
        }

        $this->_redirect->redirect($this->_response, $this->_redirect->getRefererUrl());
        return $this->_response;
    }

    /**
     * @param int $id
     * @return AttachmentInterface | null
     */
    private function loadAttachmentById(int $id) : ?AttachmentInterface
    {
        try {
            return $this->attachmentRepository->getById($id);
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(__('Attachment not found.'));
            return null;
        }
    }
}
