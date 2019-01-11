<?php

use Faker\Factory as Faker;
use App\Models\CompanyAdmin\Email;
use App\Repositories\CompanyAdminRepositories\EmailRepository;

trait MakeEmailTrait
{
    /**
     * Create fake instance of Email and save it in database
     *
     * @param array $emailFields
     * @return Email
     */
    public function makeEmail($emailFields = [])
    {
        /** @var EmailRepository $emailRepo */
        $emailRepo = App::make(EmailRepository::class);
        $theme = $this->fakeEmailData($emailFields);
        return $emailRepo->create($theme);
    }

    /**
     * Get fake instance of Email
     *
     * @param array $emailFields
     * @return Email
     */
    public function fakeEmail($emailFields = [])
    {
        return new Email($this->fakeEmailData($emailFields));
    }

    /**
     * Get fake data of Email
     *
     * @param array $postFields
     * @return array
     */
    public function fakeEmailData($emailFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'email_title' => $fake->word,
            'email_content' => $fake->text,
            'format_email_content' => $fake->text,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $emailFields);
    }
}
