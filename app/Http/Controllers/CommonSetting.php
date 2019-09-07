<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting as Settings;
use App\Store_statu as Store_statu;

//this controller is used in global wokring
class CommonSetting extends Controller
{
    static protected $settings;

    static public function timezone() {
        $settings = Settings::find(1);
        return $settings->time_zone;
    }

    static public function currency() {
        $settings = Settings::find(1);
        return $settings->currency;
    }

    static public function storestatus() {
        $settings = Store_statu::find(1);
        return $settings->store_close;
    }

}
