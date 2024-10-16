<?php

declare(strict_types=1);

namespace Sample\PayAtStore\Setup\Patch\Data;

use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class ConfigureOfflinePaymentMethod implements DataPatchInterface
{
    private const CASH_ON_DELIVERY_ACTIVE_XML_PATH = 'payment/cashondelivery/active';
    private const CASH_ON_DELIVERY_TITLE_XML_PATH = 'payment/cashondelivery/title';
    private const CASH_ON_DELIVERY_TITLE_VALUE = 'Pay at Store';

    public function __construct(
        private readonly WriterInterface $configWriter
    ) {
    }

    public function apply(): self
    {
        $this->configWriter->save(self::CASH_ON_DELIVERY_ACTIVE_XML_PATH, 1);
        $this->configWriter->save(self::CASH_ON_DELIVERY_TITLE_XML_PATH, self::CASH_ON_DELIVERY_TITLE_VALUE);

        return $this;
    }

    public static function getDependencies(): array
    {
        return [];
    }

    public function getAliases(): array
    {
        return [];
    }
}
