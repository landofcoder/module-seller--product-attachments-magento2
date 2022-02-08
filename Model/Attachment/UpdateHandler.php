<?php

declare(strict_types = 1);

/**
 * File: UpdateHandler.php
 *
 * @author Bartosz Kubicki bartosz.kubicki@lizardmedia.pl>
 * @copyright Copyright (C) 2018 Lizard Media (http://lizardmedia.pl)
 */

namespace Lofmp\ProductAttachment\Model\Attachment;

use LizardMedia\ProductAttachment\Api\AttachmentRepositoryInterface;
use LizardMedia\ProductAttachment\Api\Data\AttachmentInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\EntityManager\Operation\ExtensionInterface;
use Lofmp\ProductAttachment\Helper\Data;

/**
 * Class UpdateHandler
 * @package Lofmp\ProductAttachment\Model\Attachment
 */
class UpdateHandler extends \Lofmp\ProductAttachment\Model\Attachment\UpdateHandler
{
    /**
     * @var AttachmentRepositoryInterface
     */
    private $attachmentRepository;

    /**
     * @var Data
     */
    protected $helperData;


    /**
     * @param AttachmentRepositoryInterface $attachmentRepository
     * @param Data $helperData
     */
    public function __construct(AttachmentRepositoryInterface $attachmentRepository, Data $helperData)
    {
        $this->attachmentRepository = $attachmentRepository;
        $this->helperData = $helperData;
        parent::__construct($attachmentRepository);
    }

    /**
     * @param object $entity
     * @param array $arguments
     * @return ProductInterface|object $entity
     */
    public function execute($entity, $arguments = [])
    {
        if (!$this->helperData->isEnabled()) {
            return $entity;
        }
        return parent::execute($entity, $arguments = []);
    }
}
