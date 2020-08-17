<?php
/**
 * Pashko_ZipLookup
 *
 * @category ZipLookup
 * @package Pashko_ZipLookup
 * @author Ostap Pashko <ostap.paashko@gmail.com>
 */

namespace Pashko\ZipLookup\Test\GraphQl;

use Magento\Framework\App\ObjectManager;
use Magento\TestFramework\TestCase\GraphQl\ResponseContainsErrorsException;
use Magento\TestFramework\TestCase\GraphQlAbstract;
use Pashko\ZipLookup\Api\ZipRepositoryInterface;

/**
 * Class ZipLookupTest
 * @package Pashko\ZipLookup\Test\GraphQl
 */
class ZipLookupTest extends GraphQlAbstract
{
    /**
     * @var ZipRepositoryInterface
     */
    private $zipRepository;

    /**
     * init needed dependencies
     */
    public function setUp(): void
    {
        $this->zipRepository = ObjectManager::getInstance()->get(ZipRepositoryInterface::class);
    }

    /**
     * @magentoApiDataFixture ../../../../app/code/Pashko/ZipLookup/Test/_files/zips.php
     */
    public function testZipLookupResolverWithRegionId() {
        $zipCode = "60090";
        $zip = $this->zipRepository->getByZipCode($zipCode);
        $query = <<<QUERY
{ziplookup(zip:"$zipCode"){zip,country_id,region_id,region,city}}
QUERY;
        $response = $this->graphQlQuery($query);
        self::assertArrayHasKey('ziplookup', $response);
        self::assertEquals($zip->getCountryId(), $response['ziplookup']['country_id']);
        self::assertEquals($zip->getRegionId(), $response['ziplookup']['region_id']);
        self::assertEquals($zip->getRegion(), $response['ziplookup']['region']);
        self::assertEquals($zip->getCity(), $response['ziplookup']['city']);

    }

    /**
     * @magentoApiDataFixture ../../../../app/code/Pashko/ZipLookup/Test/_files/zips.php
     */
    public function testZipLookupResolverWithRegion() {
        $zipCode = "81700";
        $zip = $this->zipRepository->getByZipCode($zipCode);
        $query = <<<QUERY
{ziplookup(zip:"$zipCode"){zip,country_id,region_id,region,city}}
QUERY;
        $response = $this->graphQlQuery($query);
        self::assertArrayHasKey('ziplookup', $response);
        self::assertEquals($zip->getCountryId(), $response['ziplookup']['country_id']);
        self::assertEquals($zip->getRegionId(), $response['ziplookup']['region_id']);
        self::assertEquals($zip->getRegion(), $response['ziplookup']['region']);
        self::assertEquals($zip->getCity(), $response['ziplookup']['city']);

    }


    /**
     * @throws \Exception
     */
    public function testZipLookupResolverExceptionNoSuchEntity() {
        self::expectException(ResponseContainsErrorsException::class);
        $zip = "notarealzip";
        $query = <<<QUERY
{ziplookup(zip:"$zip"){zip,country_id,region_id,region,city}}
QUERY;
        $response = $this->graphQlQuery($query);
        self::assertArrayNotHasKey('ziplookup', $response);

    }

    /**
     * @throws \Exception
     */
    public function testZipLookupResolverExceptionNotSpecified() {
        self::expectException(ResponseContainsErrorsException::class);
        $query = <<<QUERY
{ziplookup(zip:null){zip,country_id,region_id,region,city}}
QUERY;
        $response = $this->graphQlQuery($query);
        self::assertArrayNotHasKey('ziplookup', $response);

    }

}
