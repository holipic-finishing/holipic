<?php

namespace App\Repositories;

use InfyOm\Generator\Common\BaseRepository;

class BaseRepo extends BaseRepository
{
	public function model()
    {
        
    }

    public function getLimit($limit = null)
    {
    	if(is_null($limit)) return config('repository.pagination.limit');

    	return $limit;
    }
}