<?php
use Pashko\ZipLookup\Model\ZipFactory;
use Magento\Framework\Api\DataObjectHelper;
use Pashko\ZipLookup\Api\Data\ZipInterface;
use Magento\TestFramework\Helper\Bootstrap;
use Pashko\ZipLookup\Api\ZipRepositoryInterface;
/** @var ZipFactory\ $zipFactory */
$zipFactory = Bootstrap::getObjectManager()->get(ZipFactory::class);
/** @var DataObjectHelper $dataObjectHelper */
$dataObjectHelper = Bootstrap::getObjectManager()->get(DataObjectHelper::class);
/** @var ZipRepositoryInterface $zipRepository */
$zipRepository = Bootstrap::getObjectManager()->get(ZipRepositoryInterface::class);
$zipsData = [
    "60090",
    "81700"
];

foreach ($zipsData as $zipData) {
    try {
        /** @var ZipInterface $zip */
        $zip = $zipRepository->getByZipCode($zipData);
        $zipRepository->delete($zip);
    } catch (\Exception $e) {
        // @TODO log this
    }
}
