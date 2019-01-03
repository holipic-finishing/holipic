<?php

use Faker\Factory as Faker;
use App\Models\PhotoPackage;
use App\Repositories\PhotoPackageRepository;

trait MakePhotoPackageTrait
{
    /**
     * Create fake instance of PhotoPackage and save it in database
     *
     * @param array $photoPackageFields
     * @return PhotoPackage
     */
    public function makePhotoPackage($photoPackageFields = [])
    {
        /** @var PhotoPackageRepository $photoPackageRepo */
        $photoPackageRepo = App::make(PhotoPackageRepository::class);
        $theme = $this->fakePhotoPackageData($photoPackageFields);
        return $photoPackageRepo->create($theme);
    }

    /**
     * Get fake instance of PhotoPackage
     *
     * @param array $photoPackageFields
     * @return PhotoPackage
     */
    public function fakePhotoPackage($photoPackageFields = [])
    {
        return new PhotoPackage($this->fakePhotoPackageData($photoPackageFields));
    }

    /**
     * Get fake data of PhotoPackage
     *
     * @param array $postFields
     * @return array
     */
    public function fakePhotoPackageData($photoPackageFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'size' => $fake->word,
            'price' => $fake->word,
            'free_photo' => $fake->word,
            'currency_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $photoPackageFields);
    }
}
