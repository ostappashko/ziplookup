<?php
/**
 * Pashko_ZipLookup
 *
 * @category ZipLookup
 * @package Pashko_ZipLookup
 * @author Ostap Pashko <ostap.paashko@gmail.com>
 */

namespace Pashko\ZipLookup\Api\Data;


/**
 * Interface ZipLookupInterface
 * @package Pashko\ZipLookup\Api\Data
 */
interface ZipInterface
{
    /**
     * Incremenental Primary Id
     */
    const ENTITY_ID = "entity_id";
    /**
     * Country ID
     */
    const COUNTRY_ID = 'country_id';
    /**
     * Region
     */
    const REGION = 'region';
    /**
     * Regiond Id
     */
    const REGION_ID = 'region_id';
    /**
     * City
     */
    const CITY = "city";
    /**
     * Zip code
     */
    const ZIP = "zip";

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set ID
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * @return int
     */
    public function getCountryId();

    /**
     * @param int $country_id
     * @return $this
     */
    public function setCountryId($country_id);

    /**
     * @return string
     */
    public function getRegion();

    /**
     * @param string $region
     * @return $this
     */
    public function setRegion($region);

    /**
     * @return int
     */
    public function getRegionId();

    /**
     * @param int $regionId
     * @return $this
     */
    public function setRegionId($regionId);

    /**
     * @return string
     */
    public function getCity();

    /**
     * @param string $city
     * @return $this
     */
    public function setCity($city);

    /**
     * @return string
     */
    public function getZip();

    /**
     * @param string $zip
     * @return $this
     */
    public function setZip($zip);




}
