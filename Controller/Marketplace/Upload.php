<?php
/**
 * LandofCoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * https://landofcoder.com/license
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   LandofCoder
 * @package    Lofmp_ProductAttachment
 * @copyright  Copyright (c) 2022 Landofcoder (https://landofcoder.com/)
 * @license    https://landofcoder.com/LICENSE-1.0.html
 */

namespace Lofmp\ProductAttachment\Controller\Marketplace;

/**
 * Admin seller attachment Upload controller
 */
class Upload extends Actions
{
    /**
     * Form session key
     * @var string
     */
    protected $_formSessionKey  = 'lofmpproductattachment_upload';

    /**
     * Allowed Key
     * @var string
     */
    protected $_allowedKey      = 'Lofmp_ProductAttachment::upload';

    /**
     * Model class name
     * @var string
     */
    protected $_modelClass      = \LizardMedia\ProductAttachment\Model\Attachment::class;

    /**
     * Active menu key
     * @var string
     */
    protected $_activeMenu      = 'Lofmp_ProductAttachment::upload';

    /**
     * Status field name
     * @var string
     */
    protected $_statusField     = 'is_active';

    /**
     * {@inheritdoc}
     */
    protected $_idKey = 'id';
}
