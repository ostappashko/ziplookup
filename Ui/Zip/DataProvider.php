<?php
/**
 * Pashko_ZipLookup
 *
 * @category ZipLookup
 * @package Pashko_ZipLookup
 * @author Ostap Pashko <ostap.paashko@gmail.com>
 */

namespace Pashko\ZipLookup\Ui\Zip;

use Pashko\ZipLookup\Model\ResourceModel\Zip\CollectionFactory;

/**
 * Class DataProvider
 * @package Pashko\ZipLookup\Ui\Zip
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var array
     */
    protected $_loadedData = null;
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $zipCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $zipCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $zipCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $zip) {
            $this->_loadedData[$zip->getId()] = ["zip" => $zip->getData()];
        }
        return $this->_loadedData;
    }
}
