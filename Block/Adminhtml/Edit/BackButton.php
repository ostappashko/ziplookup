<?php
/**
 * Pashko_ZipLookup
 *
 * @category ZipLookup
 * @package Pashko_ZipLookup
 * @author Ostap Pashko <ostap.paashko@gmail.com>
 */

namespace Pashko\ZipLookup\Block\Adminhtml\Edit;


use Magento\Customer\Block\Adminhtml\Edit\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class BackButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10
        ];
    }

    /**
     * Get URL for back (reset) button
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('*/*/');
    }
}
