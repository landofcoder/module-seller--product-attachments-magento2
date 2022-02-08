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
 * @copyright  Copyright (c) 2022 Landofcoder (https://landofcoder.com/)
 * @license    https://landofcoder.com/LICENSE-1.0.html
 */

namespace Lofmp\ProductAttachment\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Framework\Stdlib\ArrayManager;
use Magento\Ui\Component\Form;
use Lofmp\ProductAttachment\Helper\Data;

/**
 * Class AttachmentPanel
 * @package LizardMedia\ProductAttachment\Ui\DataProvider\Product\Form\Modifier
 */
class AttachmentPanel extends AbstractModifier
{
    /**
     * @var ArrayManager
     */
    private $arrayManager;

    /**
     * @var array
     */
    private $meta = [];

    /**
     * @var Data
     */
    protected $helperData;

    /**
     * @param ArrayManager $arrayManager
     * @param Data $helperDdata
     */
    public function __construct(ArrayManager $arrayManager, Data $helperData)
    {
        $this->arrayManager = $arrayManager;
        $this->helperData = $helperData;
    }

    /**
     * @param array $data
     * @return array $data
     */
    public function modifyData(array $data) : array
    {
        return $data;
    }

    /**
     * @param array $meta
     * @return array $meta
     */
    public function modifyMeta(array $meta) : array
    {
        if (!$this->helperData->isEnabled()) {
            return $meta;
        }
        $this->meta = $meta;

        $panelConfig['arguments']['data']['config'] = [
            'componentType' => Form\Fieldset::NAME,
            'label' => __('Product attachments'),
            'collapsible' => true,
            'opened' => true,
            'sortOrder' => '900',
            'dataScope' => 'data'
        ];

        $this->meta = $this->arrayManager->set('product_attachment', $this->meta, $panelConfig);

        return $this->meta;
    }
}
