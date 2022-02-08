<?php
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

namespace Lofmp\ProductAttachment\Helper;

use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\App\Helper\AbstractHelper;
use Lof\MarketPlace\Model\SellerFactory;
use Lof\MarketPlace\Model\ConfigFactory;

/**
 * Class Data
 * @package Lofmp\ProductAttachment\Helper
 */
class Data extends AbstractHelper
{
    const XML_PATH_SECTION = 'catalog/';
    const XML_PATH_GROUP = 'product_attachments/';
    const XML_PATH_ENABLE = 'catalog/product_attachments/enable_for_seller';

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Customer\Model\SessionFactory
     */
    protected $customerSession;

    /**
     * @var SellerFactory
     */
    protected $sellerFactory;

    /**
     * @var ConfigFactory
     */
    protected $sellerConfigFactory;

    /**
     * @var mixed|array
     */
    protected $_seller = [];

    /**
     * @var array|mixed|null
     */
    protected $_sellerConfigData = null;

    /**
     * @var array|mixed|null
     */
    protected $_attribute_sets = null;

    /**
     * Data constructor.
     * @param StoreManagerInterface $storeManager
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Customer\Model\SessionFactory $customerSession
     * @param SellerFactory $sellerFactory
     * @param ConfigFactory $sellerConfigFactory
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Customer\Model\SessionFactory $customerSession,
        SellerFactory $sellerFactory,
        ConfigFactory $sellerConfigFactory
    ) {
        $this->storeManager = $storeManager;
        $this->customerSession = $customerSession;
        $this->sellerFactory = $sellerFactory;
        $this->sellerConfigFactory = $sellerConfigFactory;
        parent::__construct($context);
    }

    /**
     * Get
     */

    /**
     * @param $field
     * @param null $storeId
     * @return mixed
     */
    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * get config
     * @param $field
     * @param null $storeId
     * @return mixed
     */
    public function getConfig($key, $store = null)
    {
        $store = $this->storeManager->getStore($store);
        $websiteId = $store->getWebsiteId();
        $result = $this->scopeConfig->getValue(
            self::XML_PATH_SECTION.$key,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store);
        return $result;
    }

    /**
     * @param int $storeId
     * @return int|bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function isEnabled($storeId = 0)
    {
        return (int)$this->getConfig('product_attachments/enable_for_seller', $storeId);
    }

    /**
     * get current Seller
     *
     * @param int|null $customerId
     * @return \Lof\MarketPlace\Model\Seller|Object|null
     */
    public function getCurrentSeller($customerId = null)
    {
        if (!$customerId) {
            $customerSession = $this->customerSession->create();
            $customerId = $customerSession->getId();
        }
        if (!isset($this->_seller[$customerId])) {
            $this->_seller[$customerId] = $this->sellerFactory->create()
                ->load($customerId, 'customer_id');
        }
        return $this->_seller[$customerId];
    }
}
