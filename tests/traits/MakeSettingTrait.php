<?php

use Faker\Factory as Faker;
use App\Models\Setting;
use App\Repositories\SettingRepository;

trait MakeSettingTrait
{
    /**
     * Create fake instance of Setting and save it in database
     *
     * @param array $settingFields
     * @return Setting
     */
    public function makeSetting($settingFields = [])
    {
        /** @var SettingRepository $settingRepo */
        $settingRepo = App::make(SettingRepository::class);
        $theme = $this->fakeSettingData($settingFields);
        return $settingRepo->create($theme);
    }

    /**
     * Get fake instance of Setting
     *
     * @param array $settingFields
     * @return Setting
     */
    public function fakeSetting($settingFields = [])
    {
        return new Setting($this->fakeSettingData($settingFields));
    }

    /**
     * Get fake data of Setting
     *
     * @param array $postFields
     * @return array
     */
    public function fakeSettingData($settingFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'expiration_date' => $fake->randomDigitNotNull,
            'fee' => $fake->word,
            'card_fee' => $fake->word,
            'bonus' => $fake->word,
            'sms' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $settingFields);
    }
}
