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
    [
        ZipInterface::ZIP => "60090",
        ZipInterface::CITY => "Wheeling",
        ZipInterface::REGION_ID => "23",
        ZipInterface::COUNTRY_ID => "US"
    ],
    [
        ZipInterface::ZIP => "81700",
        ZipInterface::CITY => "Zhydachiv",
        ZipInterface::REGION => "Lviv Oblast",
        ZipInterface::COUNTRY_ID => "UA"
    ]
];

foreach ($zipsData as $zipData) {
    try {
        /** @var ZipInterface $zip */
        $zip = $zipFactory->create();
        $zip->setData($zipData);
        $zipRepository->save($zip);
    } catch (\Exception $e) {
       // @TODO log this
    }
}
