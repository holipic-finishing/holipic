<?php

use Faker\Factory as Faker;
use App\Models\Photographer;
use App\Repositories\PhotographerRepository;

trait MakePhotographerTrait
{
    /**
     * Create fake instance of Photographer and save it in database
     *
     * @param array $photographerFields
     * @return Photographer
     */
    public function makePhotographer($photographerFields = [])
    {
        /** @var PhotographerRepository $photographerRepo */
        $photographerRepo = App::make(PhotographerRepository::class);
        $theme = $this->fakePhotographerData($photographerFields);
        return $photographerRepo->create($theme);
    }

    /**
     * Get fake instance of Photographer
     *
     * @param array $photographerFields
     * @return Photographer
     */
    public function fakePhotographer($photographerFields = [])
    {
        return new Photographer($this->fakePhotographerData($photographerFields));
    }

    /**
     * Get fake data of Photographer
     *
     * @param array $postFields
     * @return array
     */
    public function fakePhotographerData($photographerFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'company_id' => $fake->randomDigitNotNull,
            'branch_id' => $fake->randomDigitNotNull,
            'name' => $fake->word,
            'phone_number' => $fake->word,
            'address' => $fake->word,
            'status' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $photographerFields);
    }
}
