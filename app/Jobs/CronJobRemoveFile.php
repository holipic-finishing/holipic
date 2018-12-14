<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Setting;
use App\Models\File;
use Log;

class CronJobRemoveFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        set_time_limit(0);

        Log::channel('cron_job')->info("============== CRON JOB REMOVE START at ". date('Y-m-d H:i:s') ." ================ \r\n");

        $expiration_date = 0;

        $resultes = Setting::all();

        foreach ($resultes as $key => $item) {

            Log::channel('cron_job')->info("Package id for : ".$item->id ." \r\n");
            
            $setting = Setting::select('expiration_date')->where('id',$item->id)->first()->toArray();

            $expiration_date = $setting['expiration_date'];

            Log::channel('cron_job')->info("Expiration Date from database for : ".$expiration_date ." \r\n");

            $day = \Carbon\Carbon::now()->subDay($expiration_date);

            Log::channel('cron_job')->info("The expiration date of the image : ".$day ." \r\n");

            $package_id = $item->id;

            $resultes = $this->arrayFileRemove($package_id,$day);

            $this->updateStatusFile($resultes);

            Log::channel('cron_job')->info("Number of images has expired : ".count($resultes) ." \r\n");

        }
        Log::channel('cron_job')->info("============== CRON JOB REMOVE END at ". date('Y-m-d H:i:s') ." ================ \r\n");
    }

    public function arrayFileRemove($package_id,$day) {

        $resultes = File::whereHas('user' , function($query) use ($package_id){
                                $query->where('package_id','=',$package_id);
                        })->whereDate('uploaded_date','<',$day)->where('status','1')->get();

        return $resultes;

    } 

    public function updateStatusFile($attribute){
        
        if(count($attribute) !=0){
            
            foreach ($attribute as $key => $value) {
                $data = File::where('id',$value->id)->update([
                            'status' => '0'
                        ]);
            }
            return true;

        } else {

            return false;
        }
    } 
}
