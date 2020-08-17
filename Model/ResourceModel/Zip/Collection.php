<?php
/**
 * Pashko_ZipLookup
 *
 * @category ZipLookup
 * @package Pashko_ZipLookup
 * @author Ostap Pashko <ostap.paashko@gmail.com>
 */

namespace Pashko\ZipLookup\Model\ResourceModel\Zip;

/**
 * Class Collection
 * @package Pashko\ZipLookup\Model\ResourceModel\Zip
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';
    /**
     * @var string
     */
    protected $_eventPrefix = 'pashko_ziplookup_collection';
    /**
     * @var string
     */
    protected $_eventObject = 'ziplookup_collection';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(\Pashko\ZipLookup\Model\Zip::class, \Pashko\ZipLookup\Model\ResourceModel\Zip::class);
    }
}
