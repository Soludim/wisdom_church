<?php

namespace App\Libraries;

use App\NewData;
use Illuminate\Support\Carbon;

class TodayData
{

    //tracking new data addition for today
    //has only 1 row record
    //update row for todays record

    //receives ['prayer_requests','testimonies','mail_received','users']
    public static function statistics($type)
    {
        $today_data = NewData::find(1);    //today's statistics
        if ($today_data == null) $today_data = NewData::create(); //create row when it does not exist

        if (Carbon::now()->format('Y-m-d') <> $today_data->date)  //getting rid of previous day data
        {
            $today_data->date = Carbon::now();
            $today_data->prayer_requests = $type['prayer_requests'];
            $today_data->testimonies = $type['testimonies'];;
            $today_data->mail_received = $type['mail_received'];;
            $today_data->users = $type['users'];;
            //date date to today and reset all counts and count prayer request
            $today_data->save();
        } else {
            //update counts
            $today_data->prayer_requests = ($today_data->prayer_requests + $type['prayer_requests']);
            $today_data->testimonies = ($today_data->testimonies + $type['testimonies']);
            $today_data->mail_received = ($today_data->mail_received + $type['mail_received']);
            $today_data->users = ($today_data->users + $type['users']);

            $today_data->save();
        }
    }
}
