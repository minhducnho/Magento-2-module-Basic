<?php
/**
 * Initom
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Initom license that is
 * available through the world-wide-web at this URL:
 * 
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Initom
 * @package     Initom_Requestform
 * @copyright   Copyright (c) Initom
 * @license     Initom
 */

namespace Initom\Requestform\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

/**
 * Class UpgradeSchema
 * @package Initom\Requestform\Setup
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @param \Magento\Framework\Setup\SchemaSetupInterface $setup
     * @param \Magento\Framework\Setup\ModuleContextInterface $context
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $connection = $setup->getConnection();

        if (version_compare($context->getVersion(), '1.1.0', '>')) {
            $connection->addColumn($setup->getTable('initom_requestform'), 'from', [
                'type'     => Table::TYPE_TEXT,
                'nullable' => true,
                'length'   => 255,
                'comment'  => 'Sender'
            ]);
            $connection->addColumn($setup->getTable('initom_requestform'), 'to', [
                'type'     => Table::TYPE_TEXT,
                'nullable' => true,
                'length'   => 255,
                'comment'  => 'Recipient'
            ]);
            $connection->addColumn($setup->getTable('initom_requestform'), 'cc', [
                'type'     => Table::TYPE_TEXT,
                'nullable' => true,
                'length'   => 255,
                'comment'  => 'Cc'
            ]);
            $connection->addColumn($setup->getTable('initom_requestform'), 'bcc', [
                'type'     => Table::TYPE_TEXT,
                'nullable' => true,
                'length'   => 255,
                'comment'  => 'Bcc'
            ]);
        }

        $setup->endSetup();
    }
}