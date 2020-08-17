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

class SaveButton extends GenericButton implements ButtonProviderInterface
{

    /**
     * @return array
     */
    public function getButtonData()
    {
        $data = [
            'label' => __('Save Zip Code'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
        return $data;
    }
}
