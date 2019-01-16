<?php

use Faker\Factory as Faker;
use App\Models\CompanyPackage;
use App\Repositories\CompanyPackageRepository;

trait MakeCompanyPackageTrait
{
    /**
     * Create fake instance of CompanyPackage and save it in database
     *
     * @param array $companyPackageFields
     * @return CompanyPackage
     */
    public function makeCompanyPackage($companyPackageFields = [])
    {
        /** @var CompanyPackageRepository $companyPackageRepo */
        $companyPackageRepo = App::make(CompanyPackageRepository::class);
        $theme = $this->fakeCompanyPackageData($companyPackageFields);
        return $companyPackageRepo->create($theme);
    }

    /**
     * Get fake instance of CompanyPackage
     *
     * @param array $companyPackageFields
     * @return CompanyPackage
     */
    public function fakeCompanyPackage($companyPackageFields = [])
    {
        return new CompanyPackage($this->fakeCompanyPackageData($companyPackageFields));
    }

    /**
     * Get fake data of CompanyPackage
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCompanyPackageData($companyPackageFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'price' => $fake->word,
            'offer' => $fake->word,
            'detail' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $companyPackageFields);
    }
}
