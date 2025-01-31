<?php

declare(strict_types=1);

namespace Magenable\PickupPaymentRestriction\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magenable\PickupPaymentRestriction\Model\ConfigProvider;

class PickupPaymentRestriction implements ArgumentInterface
{
    public function __construct(
        private ConfigProvider $configProvider,
    ) {
    }

    public function isModuleEnabled(): bool
    {
        return $this->configProvider->isModuleEnabled();
    }

    public function getPaymentMethods(): array
    {
        return $this->configProvider->getPaymentMethods();
    }
}
