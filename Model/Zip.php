<?php
/**
 * Pashko_ZipLookup
 *
 * @category ZipLookup
 * @package Pashko_ZipLookup
 * @author Ostap Pashko <ostap.paashko@gmail.com>
 */

namespace Pashko\ZipLookup\Model;

use Magento\Framework\Model\AbstractModel;
use Pashko\ZipLookup\Api\Data\ZipInterface;

/**
 * Class Zip
 * @package Pashko\ZipLookup\Model
 */
class Zip extends AbstractModel implements ZipInterface
{

    /**
     * Cache tag for zip entity
     */
    const CACHE_TAG = "pashko_ziplookup_zip";

    /**
     * Construct for object initialization
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Zip::class);
    }

    /**
     * @return int
     */
    public function getCountryId()
    {
        return $this->getData(self::COUNTRY_ID);
    }

    /**
     * @param int $country_id
     * @return $this
     */
    public function setCountryId($country_id)
    {
        return $this->setData(self::COUNTRY_ID, $country_id);
    }

    /**
     * @return string
     */
    public function getRegion()
    {
        return $this->getData(self::REGION);
    }

    /**
     * @param string $region
     * @return $this
     */
    public function setRegion($region)
    {
        return $this->setData(self::REGION, $region);
    }

    /**
     * @return int
     */
    public function getRegionId()
    {
        return $this->getData(self::REGION_ID);
    }

    /**
     * @param int $regionId
     * @return $this
     */
    public function setRegionId($regionId)
    {
        return $this->setData(self::REGION_ID, $regionId);
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->getData(self::CITY);
    }

    /**
     * @param string $city
     * @return $this
     */
    public function setCity($city)
    {
        return $this->setData(self::CITY, $city);
    }

    /**
     * @return string
     */
    public function getZip()
    {
        return $this->getData(self::ZIP);
    }

    /**
     * @param string $zip
     * @return $this
     */
    public function setZip($zip)
    {
        return $this->setData(self::ZIP, $zip);
    }
}
