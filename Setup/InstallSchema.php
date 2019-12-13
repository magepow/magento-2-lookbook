<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2018-05-16 10:40:51
 * @@Modify Date: 2018-06-27 15:17:29
 * @@Function:
 */

namespace Magiccart\Lookbook\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        $table = $installer->getConnection()
            ->newTable($installer->getTable('magiccart_lookbook'))
            ->addColumn(
                'lookbook_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Lookbook ID'
            )
            ->addColumn('title', Table::TYPE_TEXT, 255, ['nullable' => true], 'Title')
            ->addColumn('identifier', Table::TYPE_TEXT, 255, ['nullable' => true, 'default' => null])
            ->addColumn('type_id', Table::TYPE_SMALLINT, null, ['nullable' => false, 'default' => '1'], 'Type')
            ->addColumn('link', Table::TYPE_TEXT, 255, ['nullable' => true], 'Link')
            ->addColumn('image', Table::TYPE_TEXT, 255, ['nullable' => true], 'Image')
            // ->addColumn('content', Table::TYPE_TEXT, 1024, ['nullable' => true], 'content')
            ->addColumn('options', Table::TYPE_TEXT, 1024, ['nullable' => true], 'options')
            ->addColumn('stores', Table::TYPE_TEXT, 255, ['nullable' => true], 'Stores')
            ->addColumn('order', Table::TYPE_INTEGER, null, ['nullable' => false, 'default' => '0'], 'Order')
            ->addColumn('status', Table::TYPE_SMALLINT, null, ['nullable' => false, 'default' => '1'], 'Status')
            ->setComment('Magiccart Lookbook');

        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }

}
