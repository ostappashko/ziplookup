<?php
/**
 * Pashko_ZipLookup
 *
 * @category ZipLookup
 * @package Pashko_ZipLookup
 * @author Ostap Pashko <ostap.paashko@gmail.com>
 */

namespace Pashko\ZipLookup\Model\Source\Import\Behavior;

use Magento\ImportExport\Model\Import;
use Magento\ImportExport\Model\Source\Import\AbstractBehavior;

/**
 * Class AddUpdateBasic
 * @package Pashko\ZipLookup\Model\Source\Import\Behavior
 */
class AddUpdateBasic extends AbstractBehavior
{
    /**
     * Behavior code
     */
    const IMPORT_BEHAVIOR_CODE = 'add_update_basic';

    /**
     * Get Options
     *
     * @return array
     */
    public function toArray()
    {
        return [
            Import::BEHAVIOR_ADD_UPDATE => __('Import/Update'),
        ];
    }

    /**
     * Get Code
     *
     * @return string
     */
    public function getCode()
    {
        return self::IMPORT_BEHAVIOR_CODE;
    }
}
