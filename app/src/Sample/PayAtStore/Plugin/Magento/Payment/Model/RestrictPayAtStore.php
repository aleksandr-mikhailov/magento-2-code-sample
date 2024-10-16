<?php

declare(strict_types=1);

namespace Sample\PayAtStore\Plugin\Magento\Payment\Model;

use Amasty\StorePickupWithLocator\Model\Carrier\Shipping;
use Magento\OfflinePayments\Model\Cashondelivery;
use Magento\Payment\Model\MethodList;
use Magento\Quote\Api\Data\CartInterface;

class RestrictPayAtStore
{
    public function afterGetAvailableMethods(MethodList $subject, array $availableMethods, CartInterface $quote): array
    {
        $shippingAddress = $quote->getShippingAddress();
        $shippingMethod = $shippingAddress->getShippingMethod();
        foreach($availableMethods as $key => $method) {
            if (
                $shippingMethod !== Shipping::SHIPPING_NAME
                && $method->getCode() === Cashondelivery::PAYMENT_METHOD_CASHONDELIVERY_CODE
            ) {
                unset($availableMethods[$key]);
                break;
            }
        }

        return $availableMethods;
    }
}
