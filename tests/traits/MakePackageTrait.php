<?php

use Faker\Factory as Faker;
use App\Models\Package;
use App\Repositories\PackageRepository;

trait MakePackageTrait
{
    /**
     * Create fake instance of Package and save it in database
     *
     * @param array $packageFields
     * @return Package
     */
    public function makePackage($packageFields = [])
    {
        /** @var PackageRepository $packageRepo */
        $packageRepo = App::make(PackageRepository::class);
        $theme = $this->fakePackageData($packageFields);
        return $packageRepo->create($theme);
    }

    /**
     * Get fake instance of Package
     *
     * @param array $packageFields
     * @return Package
     */
    public function fakePackage($packageFields = [])
    {
        return new Package($this->fakePackageData($packageFields));
    }

    /**
     * Get fake data of Package
     *
     * @param array $postFields
     * @return array
     */
    public function fakePackageData($packageFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'package_name' => $fake->word,
            'short_description' => $fake->word,
            'full_description' => $fake->word,
            'secure_storage' => $fake->word,
            'file_upload' => $fake->word,
            'minimum_user' => $fake->word,
            'max_user' => $fake->word,
            'company_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $packageFields);
    }
}
