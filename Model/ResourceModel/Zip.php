<?php
/**
 * Pashko_ZipLookup
 *
 * @category ZipLookup
 * @package Pashko_ZipLookup
 * @author Ostap Pashko <ostap.paashko@gmail.com>
 */

namespace Pashko\ZipLookup\Model\ResourceModel;


/**
 * Class Zip
 * @package Pashko\ZipLookup\Model\ResourceModel
 */
class Zip extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Table name
     */
    const TABLE_NAME = "pashko_ziplookup";

    /**
     * Entity ID
     */
    const ENTITY_ID = "entity_id";

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, self:: ENTITY_ID);
    }
}
