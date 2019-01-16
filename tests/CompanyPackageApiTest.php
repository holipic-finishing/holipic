<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CompanyPackageApiTest extends TestCase
{
    use MakeCompanyPackageTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCompanyPackage()
    {
        $companyPackage = $this->fakeCompanyPackageData();
        $this->json('POST', '/api/v1/companyPackages', $companyPackage);

        $this->assertApiResponse($companyPackage);
    }

    /**
     * @test
     */
    public function testReadCompanyPackage()
    {
        $companyPackage = $this->makeCompanyPackage();
        $this->json('GET', '/api/v1/companyPackages/'.$companyPackage->id);

        $this->assertApiResponse($companyPackage->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCompanyPackage()
    {
        $companyPackage = $this->makeCompanyPackage();
        $editedCompanyPackage = $this->fakeCompanyPackageData();

        $this->json('PUT', '/api/v1/companyPackages/'.$companyPackage->id, $editedCompanyPackage);

        $this->assertApiResponse($editedCompanyPackage);
    }

    /**
     * @test
     */
    public function testDeleteCompanyPackage()
    {
        $companyPackage = $this->makeCompanyPackage();
        $this->json('DELETE', '/api/v1/companyPackages/'.$companyPackage->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/companyPackages/'.$companyPackage->id);

        $this->assertResponseStatus(404);
    }
}
