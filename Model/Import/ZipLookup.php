<?php
/**
 * Pashko_ZipLookup
 *
 * @category ZipLookup
 * @package Pashko_ZipLookup
 * @author Ostap Pashko <ostap.paashko@gmail.com>
 */

namespace Pashko\ZipLookup\Model\Import;

use Magento\Framework\App\ResourceConnection;
use Magento\ImportExport\Model\Import\ErrorProcessing\ProcessingErrorAggregatorInterface;
use Pashko\ZipLookup\Api\Data\ZipInterface;

/**
 * Class ZipLookup
 * @package Pashko\ZipLookup\Model\Import
 */
class ZipLookup extends \Magento\ImportExport\Model\Import\Entity\AbstractEntity
{
    /**
     * @var ZipFactory
     */
    protected $zipFactory;
    /**
     * @var \Pashko\ZipLookup\Api\ZipRepositoryInterface
     */
    protected $zipRepository;

    /**
     * Need to log in import history
     *
     * @var bool
     */
    protected $logInHistory = true;

    /**
     * @var array
     */
    protected $_validators = [];
    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_connection;

    /**
     * @var
     */
    protected $_resource;

    /**
     * Countries and regions
     *
     * Example array: array(
     *   [country_id_lowercased_1] => array(
     *     [region_code_lowercased_1]         => region_id_1,
     *     [region_default_name_lowercased_1] => region_id_1,
     *     ...,
     *     [region_code_lowercased_n]         => region_id_n,
     *     [region_default_name_lowercased_n] => region_id_n
     *   ),
     *   ...
     * )
     *
     * @var array
     */
    protected $_countryRegions = [];

    /**
     * Region ID to region default name pairs
     *
     * @var array
     */
    protected $_regions = [];

    /**
     * Permanent entity columns.
     */
    protected $_permanentAttributes = [
        ZipInterface::ENTITY_ID
    ];

    /**
     * Valid column names
     *
     * @array
     */
    protected $validColumnNames = [
        ZipInterface::ENTITY_ID,
        ZipInterface::ZIP,
        ZipInterface::COUNTRY_ID,
        ZipInterface::REGION,
        ZipInterface::REGION_ID,
        ZipInterface::CITY,
    ];
    /**
     * @var \Magento\Directory\Model\ResourceModel\Region\CollectionFactory
     */
    private $regionColFactory;

    /**
     * CsvImport constructor.
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     * @param \Magento\ImportExport\Helper\Data $importExportData
     * @param \Magento\ImportExport\Model\ResourceModel\Import\Data $importData
     * @param \Magento\Eav\Model\Config $config
     * @param ResourceConnection $resource
     * @param \Magento\ImportExport\Model\ResourceModel\Helper $resourceHelper
     * @param \Magento\Framework\Stdlib\StringUtils $string
     * @param ProcessingErrorAggregatorInterface $errorAggregator
     * @param ZipFactory $zipFactory
     * @param \Pashko\ZipLookup\Api\ZipRepositoryInterface $zipRepository
     * @param \Magento\Directory\Model\ResourceModel\Region\CollectionFactory $regionColFactory
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function __construct(
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\ImportExport\Helper\Data $importExportData,
        \Magento\ImportExport\Model\ResourceModel\Import\Data $importData,
        \Magento\Eav\Model\Config $config,
        ResourceConnection $resource,
        \Magento\ImportExport\Model\ResourceModel\Helper $resourceHelper,
        \Magento\Framework\Stdlib\StringUtils $string,
        ProcessingErrorAggregatorInterface $errorAggregator,
        \Pashko\ZipLookup\Model\ZipFactory $zipFactory,
        \Pashko\ZipLookup\Api\ZipRepositoryInterface $zipRepository,
        \Magento\Directory\Model\ResourceModel\Region\CollectionFactory $regionColFactory
    ) {
        $this->zipFactory = $zipFactory;
        $this->zipRepository = $zipRepository;
        $this->regionColFactory = $regionColFactory;
        parent::__construct($jsonHelper, $importExportData, $importData, $config, $resource, $resourceHelper, $string, $errorAggregator);
        $this->_initCountryRegions();
    }
    /**
     * Import data rows.
     *
     * @return boolean
     */
    protected function _importData()
    {
        while ($bunch = $this->_dataSourceModel->getNextBunch()) {
            foreach ($bunch as $rowNum => $rowData) {
                try {
                    if (!$this->validateRow($rowData, $rowNum)) {
                        continue;
                    }
                    if ($this->getErrorAggregator()->hasToBeTerminated()) {
                        $this->getErrorAggregator()->addRowToSkip($rowNum);
                        continue;
                    }

                    if (!empty($rowData[ZipInterface::REGION]) && empty($rowData[ZipInterface::REGION_ID])
                        && $this->getCountryRegionId($rowData[ZipInterface::COUNTRY_ID], $rowData[ZipInterface::REGION]) !== false) {
                        $regionId = $this->getCountryRegionId($rowData[ZipInterface::COUNTRY_ID], $rowData[ZipInterface::REGION]);
                        $rowData[ZipInterface::REGION] = $this->_regions[$regionId];
                        $rowData[ZipInterface::REGION_ID] = $regionId;
                    }
                    $zip = $this->zipFactory->create();
                    $zip->setData($rowData);
                    $this->zipRepository->save($zip);
                } catch (\Exception $e) {
                }
            }
        }
    }

    /**
     * Get RegionID from the initialized data
     *
     * @param string $countryId
     * @param string $region
     * @return bool|int
     */
    private function getCountryRegionId(string $countryId, string $region)
    {
        $countryNormalized = strtolower($countryId);
        $regionNormalized = strtolower($region);

        if (isset($this->_countryRegions[$countryNormalized])
            && isset($this->_countryRegions[$countryNormalized][$regionNormalized])) {
            return $this->_countryRegions[$countryNormalized][$regionNormalized];
        }

        return false;
    }

    /**
     * Initialize country regions hash for clever recognition
     *
     * @return $this
     */
    protected function _initCountryRegions()
    {
        /** @var $collection \Magento\Directory\Model\ResourceModel\Region\Collection */
        $collection = $this->regionColFactory->create();
        /** @var $region \Magento\Directory\Model\Region */
        foreach ($collection as $region) {
            $countryNormalized = strtolower($region->getCountryId());
            $regionCode = strtolower($region->getCode());
            $regionName = strtolower($region->getDefaultName());
            $this->_countryRegions[$countryNormalized][$regionCode] = $region->getId();
            $this->_countryRegions[$countryNormalized][$regionName] = $region->getId();
            $this->_regions[$region->getId()] = $region->getDefaultName();
        }
        return $this;
    }

    /**
     * EAV entity type code getter.
     *
     * @return string
     */
    public function getEntityTypeCode()
    {
        // This is a work around, as magento doesn't take a custom import without a real eav entity
        return "customer_address";
    }

    /**
     * Validate data row.
     *
     * @param array $rowData
     * @param int $rowNum
     * @return boolean
     */
    public function validateRow(array $rowData, $rowNum)
    {
        // Take data raw
        return true;
    }

    /**
     * Get available columns
     *
     * @return array
     */
    public function getValidColumnNames(): array
    {
        return $this->validColumnNames;
    }

    /**
     * Get available columns
     *
     * @return array
     */
    private function getAvailableColumns(): array
    {
        return $this->validColumnNames;
    }
}
