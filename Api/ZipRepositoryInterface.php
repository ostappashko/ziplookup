<?php
/**
 * Pashko_ZipLookup
 *
 * @category ZipLookup
 * @package Pashko_ZipLookup
 * @author Ostap Pashko <ostap.paashko@gmail.com>
 */

namespace Pashko\ZipLookup\Api;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Pashko\ZipLookup\Api\Data\ZipInterface;

/**
 * Interface ZipRepositoryInterface
 * @package Pashko\ZipLookup\Api
 */
interface ZipRepositoryInterface
{

    /**
     * @param ZipInterface $zip
     * @return ZipInterface
     * @throws CouldNotSaveException
     */
    public function save(ZipInterface $zip) : ZipInterface;


    /**
     * @param string $zipCode
     * @return ZipInterface
     * @throws NoSuchEntityException
     */
    public function getByZipCode(string $zipCode) : ZipInterface;

    /**
     * @param int $id
     * @return ZipInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): ZipInterface;


    /**
     * @param ZipInterface $zip
     * @return bool
     * @throws StateException
     */
    public function delete(ZipInterface $zip) : bool;


    /**
     * @param int $id
     * @return bool
     * @throws StateException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $id) : bool;
}
