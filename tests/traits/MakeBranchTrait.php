<?php

use Faker\Factory as Faker;
use App\Models\Branch;
use App\Repositories\BranchRepository;

trait MakeBranchTrait
{
    /**
     * Create fake instance of Branch and save it in database
     *
     * @param array $branchFields
     * @return Branch
     */
    public function makeBranch($branchFields = [])
    {
        /** @var BranchRepository $branchRepo */
        $branchRepo = App::make(BranchRepository::class);
        $theme = $this->fakeBranchData($branchFields);
        return $branchRepo->create($theme);
    }

    /**
     * Get fake instance of Branch
     *
     * @param array $branchFields
     * @return Branch
     */
    public function fakeBranch($branchFields = [])
    {
        return new Branch($this->fakeBranchData($branchFields));
    }

    /**
     * Get fake data of Branch
     *
     * @param array $postFields
     * @return array
     */
    public function fakeBranchData($branchFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $branchFields);
    }
}
