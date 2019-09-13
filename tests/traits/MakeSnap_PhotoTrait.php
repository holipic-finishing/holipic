<?php

use Faker\Factory as Faker;
use App\Models\Snap_Photo;
use App\Repositories\Snap_PhotoRepository;

trait MakeSnap_PhotoTrait
{
    /**
     * Create fake instance of Snap_Photo and save it in database
     *
     * @param array $snapPhotoFields
     * @return Snap_Photo
     */
    public function makeSnap_Photo($snapPhotoFields = [])
    {
        /** @var Snap_PhotoRepository $snapPhotoRepo */
        $snapPhotoRepo = App::make(Snap_PhotoRepository::class);
        $theme = $this->fakeSnap_PhotoData($snapPhotoFields);
        return $snapPhotoRepo->create($theme);
    }

    /**
     * Get fake instance of Snap_Photo
     *
     * @param array $snapPhotoFields
     * @return Snap_Photo
     */
    public function fakeSnap_Photo($snapPhotoFields = [])
    {
        return new Snap_Photo($this->fakeSnap_PhotoData($snapPhotoFields));
    }

    /**
     * Get fake data of Snap_Photo
     *
     * @param array $postFields
     * @return array
     */
    public function fakeSnap_PhotoData($snapPhotoFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'branch_id' => $fake->word,
            'photographer_id' => $fake->randomDigitNotNull,
            'room_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $snapPhotoFields);
    }
}
