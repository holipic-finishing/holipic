<?php

use App\Models\CompanyPackage;
use App\Repositories\CompanyPackageRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CompanyPackageRepositoryTest extends TestCase
{
    use MakeCompanyPackageTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CompanyPackageRepository
     */
    protected $companyPackageRepo;

    public function setUp()
    {
        parent::setUp();
        $this->companyPackageRepo = App::make(CompanyPackageRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCompanyPackage()
    {
        $companyPackage = $this->fakeCompanyPackageData();
        $createdCompanyPackage = $this->companyPackageRepo->create($companyPackage);
        $createdCompanyPackage = $createdCompanyPackage->toArray();
        $this->assertArrayHasKey('id', $createdCompanyPackage);
        $this->assertNotNull($createdCompanyPackage['id'], 'Created CompanyPackage must have id specified');
        $this->assertNotNull(CompanyPackage::find($createdCompanyPackage['id']), 'CompanyPackage with given id must be in DB');
        $this->assertModelData($companyPackage, $createdCompanyPackage);
    }

    /**
     * @test read
     */
    public function testReadCompanyPackage()
    {
        $companyPackage = $this->makeCompanyPackage();
        $dbCompanyPackage = $this->companyPackageRepo->find($companyPackage->id);
        $dbCompanyPackage = $dbCompanyPackage->toArray();
        $this->assertModelData($companyPackage->toArray(), $dbCompanyPackage);
    }

    /**
     * @test update
     */
    public function testUpdateCompanyPackage()
    {
        $companyPackage = $this->makeCompanyPackage();
        $fakeCompanyPackage = $this->fakeCompanyPackageData();
        $updatedCompanyPackage = $this->companyPackageRepo->update($fakeCompanyPackage, $companyPackage->id);
        $this->assertModelData($fakeCompanyPackage, $updatedCompanyPackage->toArray());
        $dbCompanyPackage = $this->companyPackageRepo->find($companyPackage->id);
        $this->assertModelData($fakeCompanyPackage, $dbCompanyPackage->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCompanyPackage()
    {
        $companyPackage = $this->makeCompanyPackage();
        $resp = $this->companyPackageRepo->delete($companyPackage->id);
        $this->assertTrue($resp);
        $this->assertNull(CompanyPackage::find($companyPackage->id), 'CompanyPackage should not exist in DB');
    }
}
