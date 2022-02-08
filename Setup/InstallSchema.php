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

namespace Lofmp\ProductAttachment\Setup;

use LizardMedia\ProductAttachment\Model\Attachment;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Zend_Db_Exception;

/**
 * Class InstallSchema
 * @package Lofmp\ProductAttachment\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     *
     * @throws Zend_Db_Exception
     *
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        /** Start Setup */
        $installer = $setup;
        $installer->startSetup();

        /**
         * Create table 'lofmp_product_attachment'
         */
        /* $lofmp_product_attachment = $setup->getConnection()
        ->newTable($setup->getTable('lofmp_product_attachment'))
        ->addColumn(
            Attachment::ID,
            Table::TYPE_INTEGER,
            11,
            ['unsigned' => true, 'nullable' => false, 'primary' => true],
            'id ref table: '.Attachment::MAIN_TABLE
            )
        ->addColumn(
            'seller_id',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false, 'primary' => true],
            'Seller Id ref table: lof_marketplace_seller'
            )
        ->addColumn(
            'request_status',
            Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'default' => 0],
            'Status: 0: new, 1: approved, 2: disaproved, 3: rejected'
        )
        ->addIndex(
            $setup->getIdxName('lofmp_product_attachment', [Attachment::ID, 'seller_id']),
            [Attachment::ID, 'seller_id']
            )
        ->addForeignKey(
            $setup->getFkName('lofmp_product_attachment', Attachment::ID, Attachment::MAIN_TABLE, Attachment::ID),
            Attachment::ID,
            $setup->getTable(Attachment::MAIN_TABLE),
            Attachment::ID,
            Table::ACTION_CASCADE
            )
        ->addForeignKey(
            $setup->getFkName('lofmp_product_attachment', 'seller_id', 'lof_marketplace_seller', 'seller_id'),
            'seller_id',
            $setup->getTable('lof_marketplace_seller'),
            'seller_id',
            Table::ACTION_CASCADE
            )
        ->setComment('Retailer link to seller. '.Attachment::MAIN_TABLE.' and lof_marketplace_seller');

        $setup->getConnection()->createTable($lofmp_product_attachment); */

        /**
         * Create table 'lofmp_product_attachment_title'
         */
        /* $lofmp_product_attachment_title = $setup->getConnection()
        ->newTable($setup->getTable('lofmp_product_attachment_title'))
        ->addColumn(
            Attachment::TITLE_ID,
            Table::TYPE_INTEGER,
            11,
            ['unsigned' => true, 'nullable' => false, 'primary' => true],
            'product_attachment_id ref table: '.Attachment::TITLE_TABLE
            )
        ->addColumn(
            'seller_id',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false, 'primary' => true],
            'Seller Id ref table: lof_marketplace_seller'
            )
        ->addColumn(
            'request_status',
            Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'default' => 0],
            'Status: 0: new, 1: approved, 2: disaproved, 3: rejected'
        )
        ->addIndex(
            $setup->getIdxName('lofmp_product_attachment_title', [Attachment::TITLE_ID, 'seller_id']),
            [Attachment::TITLE_ID, 'seller_id']
            )
        ->addForeignKey(
            $setup->getFkName('lofmp_product_attachment_title', Attachment::TITLE_ID, Attachment::TITLE_TABLE, Attachment::TITLE_ID),
            Attachment::TITLE_ID,
            $setup->getTable(Attachment::TITLE_TABLE),
            Attachment::TITLE_ID,
            Table::ACTION_CASCADE
            )
        ->addForeignKey(
            $setup->getFkName('lofmp_product_attachment_title', 'seller_id', 'lof_marketplace_seller', 'seller_id'),
            'seller_id',
            $setup->getTable('lof_marketplace_seller'),
            'seller_id',
            Table::ACTION_CASCADE
            )
        ->setComment('Retailer link to seller. '.Attachment::TITLE_TABLE.' and lof_marketplace_seller');

        $setup->getConnection()->createTable($lofmp_product_attachment_title); */

        /** End Setup */

        $setup->endSetup();
    }
}
