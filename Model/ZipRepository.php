<?php
/**
 * Pashko_ZipLookup
 *
 * @category ZipLookup
 * @package Pashko_ZipLookup
 * @author Ostap Pashko <ostap.paashko@gmail.com>
 */

namespace Pashko\ZipLookup\Model;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Pashko\ZipLookup\Api\Data\ZipInterface;
use Pashko\ZipLookup\Api\ZipRepositoryInterface;

/**
 * Class ZipRepository
 * @package Pashko\ZipLookup\Model
 */
class ZipRepository implements ZipRepositoryInterface
{
    /**
     * @var ResourceModel\Zip
     */
    protected $recourceModel;
    /**
     * @var ZipFactory
     */
    protected $zipFactory;

    /**
     * ZipRepository constructor.
     * @param ResourceModel\Zip $recourceModel
     * @param ZipFactory $zipFactory
     */
    public function __construct(
        \Pashko\ZipLookup\Model\ResourceModel\Zip $recourceModel,
        \Pashko\ZipLookup\Model\ZipFactory $zipFactory
    ) {
        $this->recourceModel = $recourceModel;
        $this->zipFactory = $zipFactory;
    }

    /**
     * @inheritDoc
     */
    public function getByZipCode(string $zipCode) : ZipInterface
    {
        /** @var ZipInterface $zip */
        $zip = $this->zipFactory->create()->load($zipCode, "zip");
        if (!$zip->getId()) {
            throw new NoSuchEntityException(__("This Zip does not exist"));
        }
        return $zip;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id) : ZipInterface
    {
        /** @var ZipInterface $zip */
        $zip = $this->zipFactory->create()->load($id);
        if (!$zip->getId()) {
            throw new NoSuchEntityException(__("This Zip does not exist"));
        }
        return $zip;
    }

    /**
     * @inheritDoc
     */
    public function delete(ZipInterface $zip) : bool
    {
        try {
            $this->recourceModel->delete($zip);
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\StateException(
                __('Entity couldn\'t be removed.'),
                $e
            );
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById(int $id) : bool
    {
        $zip = $this->getById($id);
        return $this->delete($zip);
    }

    /**
     * @inheritDoc
     */
    public function save(ZipInterface $zip): ZipInterface
    {
        try {
            $this->recourceModel->save($zip);
            return $zip;
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
    }
}
