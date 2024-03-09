<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class TypeOrderData implements DataPatchInterface
{

    public function __construct(
        private readonly ModuleDataSetupInterface $moduleDataSetup
    ) {
    }

    public function apply(): void
    {
        $this->moduleDataSetup->startSetup();

        $data[] = ['name' => 'Standardowe'];
        $data[] = ['name' => 'Ekspozycyjne'];
        $data[] = ['name' => 'Testowe'];

        $this->moduleDataSetup->getConnection()->insertArray(
            $this->moduleDataSetup->getTable('type_order'),
            ['name'],
            $data
        );

        $this->moduleDataSetup->endSetup();
    }

    public function getAliases(): array
    {
        return [];
    }

    public static function getDependencies(): array
    {
        return [];
    }
}
