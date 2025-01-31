<?php

declare(strict_types=1);

namespace Magenable\PickupPaymentRestriction\Plugin;

use Magento\Checkout\Model\Session;
use Magenable\PickupPaymentRestriction\Model\ConfigProvider;
use Hyva\Checkout\Model\Magewire\Payment\PlaceOrderServiceProcessor;
use Magewirephp\Magewire\Component;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Framework\Exception\PaymentException;
use Exception;

readonly class PlaceOrder
{
    public function __construct(
        private Session $checkoutSession,
        private ConfigProvider $configProvider,
    ) {
    }

    /**
     * @throws PaymentException
     */
    public function afterProcess(
        PlaceOrderServiceProcessor $subject,
        $result,
        Component $component,
        CartInterface $quote = null,
        array $data = []
    )
    {
        if (!$this->configProvider->isModuleEnabled()) {
            return $result;
        }

        try {
            $quote = $this->checkoutSession->getQuote();
            $shippingMethod = $quote->getShippingAddress()->getShippingMethod();
            $paymentMethod = $quote->getPayment()->getMethod();
        } catch (Exception) {
            return $result;
        }

        $paymentMethods = $this->configProvider->getPaymentMethods();
        if ($shippingMethod === 'instore_pickup' && in_array($paymentMethod, $paymentMethods)) {
            throw new PaymentException(
                __('We are unable to process your order due to a missing service. Please consider an alternative payment method.')
            );
        }

        return $result;
    }
}
