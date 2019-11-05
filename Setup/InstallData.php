<?php

namespace Checkout\Task\Setup;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Sales\Model\Order;
use Magento\Sales\Setup\SalesSetupFactory;

/**
 * InstallData class.
 *
 * @author      Radu Ardeleanu <raduardeleanu91@gmail.com>
 */
class InstallData implements InstallDataInterface
{
    /**
     * @var \Magento\Framework\App\Config\Storage\WriterInterface
     */
    protected $configWriter;

    /**
     * @var \Magento\Sales\Setup\SalesSetupFactory
     */
    protected $salesSetupFactory;

    /**
     * InstallData constructor.
     * @param SalesSetupFactory $salesSetupFactory
     * @param \Magento\Framework\App\Config\Storage\WriterInterface $configWriter
     */
    public function __construct(
        \Magento\Sales\Setup\SalesSetupFactory $salesSetupFactory,
        \Magento\Framework\App\Config\Storage\WriterInterface $configWriter
    )
    {
        $this->salesSetupFactory = $salesSetupFactory;
        $this->configWriter = $configWriter;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        // Change Magento configuration to disable guest checkout (force login on checkout).
        $this->configWriter->save('checkout/options/guest_checkout', 0, $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeId = 0);

        // Create External Order Id order attribute.
        $salesSetup = $this->salesSetupFactory->create(['resourceName' => 'sales_setup', 'setup' => $setup]);
        $salesSetup->addAttribute(Order::ENTITY, 'external_order_id', [
            'type' => Table::TYPE_TEXT,
            'length' => 40,
            'comment' =>'External Order Id'
        ]);

        // Create External Order Id quote attribute.
        $setup->getConnection()->addColumn(
            $setup->getTable('quote'),
            'external_order_id',
            [
                'type' => Table::TYPE_TEXT,
                'length' => 40,
                'comment' =>'External Order Id'
            ]
        );

        // Add the Create External Order Id order attribute to the grid.
        $setup->getConnection()->addColumn(
            $setup->getTable('sales_order_grid'),
            'external_order_id',
            [
                'type' => Table::TYPE_TEXT,
                'length' => 40,
                'comment' =>'External Order Id'
            ]
        );

        $setup->endSetup();
    }
}
