<?php
/**
 * Pashko_ZipLookup
 *
 * @category ZipLookup
 * @package Pashko_ZipLookup
 * @author Ostap Pashko <ostap.paashko@gmail.com>
 */

namespace Pashko\ZipLookup\Plugin\Block\Checkout;

/**
 * Class LayoutProcessorPlugin
 * @package Pashko\ZipLookup\Plugin\Block\Checkout
 */
class LayoutProcessorPlugin
{
    /**
     * This plugin resets component for the postcode element, this allows us to control custom behavior
     * @param \Magento\Checkout\BLock\Checkout\LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(\Magento\Checkout\BLock\Checkout\LayoutProcessor $subject, array $jsLayout)
    {
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['postcode']['component'] = "Pashko_ZipLookup/js/form/element/post-code";
        $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
        ['billingAddress']['children']['billing-address-fieldset']['children']['postcode']['component'] = "Pashko_ZipLookup/js/form/element/post-code";
        return $jsLayout;
    }
}
