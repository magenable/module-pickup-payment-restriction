<?php

declare(strict_types=1);

namespace Magenable\PickupPaymentRestriction\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class ConfigProvider
{
    public const CONFIG_ENABLED = 'magenable_pickup_payment_restriction/general/enabled';
    public const CONFIG_PAYMENT_METHODS = 'magenable_pickup_payment_restriction/general/payment_methods';

    public function __construct(
        private ScopeConfigInterface $scopeConfig
    ) {
    }

    public function isModuleEnabled(): bool
    {
        return (bool)$this->scopeConfig->getValue(
            self::CONFIG_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getPaymentMethods(): array
    {
        $methods = (string)$this->scopeConfig->getValue(
            self::CONFIG_PAYMENT_METHODS,
            ScopeInterface::SCOPE_STORE
        );
        return explode(',', $methods);
    }
}
