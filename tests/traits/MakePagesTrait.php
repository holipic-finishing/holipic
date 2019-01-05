<?php

use Faker\Factory as Faker;
use App\Models\CompanyAdmin\Pages;
use App\Repositories\CompanyAdminRepositories\PagesRepository;

trait MakePagesTrait
{
    /**
     * Create fake instance of Pages and save it in database
     *
     * @param array $pagesFields
     * @return Pages
     */
    public function makePages($pagesFields = [])
    {
        /** @var PagesRepository $pagesRepo */
        $pagesRepo = App::make(PagesRepository::class);
        $theme = $this->fakePagesData($pagesFields);
        return $pagesRepo->create($theme);
    }

    /**
     * Get fake instance of Pages
     *
     * @param array $pagesFields
     * @return Pages
     */
    public function fakePages($pagesFields = [])
    {
        return new Pages($this->fakePagesData($pagesFields));
    }

    /**
     * Get fake data of Pages
     *
     * @param array $postFields
     * @return array
     */
    public function fakePagesData($pagesFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'page_title' => $fake->word,
            'page_content' => $fake->text,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $pagesFields);
    }
}
