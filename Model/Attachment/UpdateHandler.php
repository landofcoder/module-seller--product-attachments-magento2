<?php

declare(strict_types = 1);

/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * https://landofcoder.com/license
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lofmp_ProductAttachment
 * @copyright  Copyright (c) 2021 Landofcoder (https://landofcoder.com/)
 * @license    https://landofcoder.com/LICENSE-1.0.html
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
class UpdateHandler extends \LizardMedia\ProductAttachment\Model\Attachment\UpdateHandler
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
