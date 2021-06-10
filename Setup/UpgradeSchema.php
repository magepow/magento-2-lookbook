<?php
namespace Magiccart\Lookbook\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $version = $context->getVersion();
        $connection = $installer->getConnection();

        if (version_compare($version, '2.1') < 0) {

            $connection->addColumn(
                $installer->getTable('magiccart_lookbook'),
                'description',
                [
                    'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length'    => 255,
                    'nullable'  => true,
                    'default'   => NULL,
                    'comment'   => 'Description',
                ]
            );

            $connection->addColumn(
                $installer->getTable('magiccart_lookbook'),
                'config',
                [
                    'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length'    => '2M',
                    'nullable'  => true,
                    'default'   => NULL,
                    'comment'   => 'Config',
                ]
            );
        }

        $setup->endSetup();
    }
}