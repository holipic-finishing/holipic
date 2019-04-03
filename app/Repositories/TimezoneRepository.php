<?php

namespace App\Repositories;

use InfyOm\Generator\Common\BaseRepository;
use App\Models\Timezone;
// use ErnySans\Laraworld\Models\TimeZones;

/**
 *  Class TimezoneRepository
 *  @package App\Repositories
 *  
 */
class TimezoneRepository extends BaseRepository
{
	/**
     * Configure the Model
     **/
    public function model()
    {
        return Timezone::class;
    }

    public function handleGetTimezones()
    {
    	$timezones = $this->model->all();

    	$data = [];

    	foreach($timezones as $timezone) 
    	{
    		$time = new \DateTimeZone($timezone['zone_name']);

			$dateTime = new \DateTime('now', $time);

			$timezone['gmt_offset'] = 'GMT '.$dateTime->format('P');

			$data[] = $timezone;
    	}

    	return $data;
    }
 
}