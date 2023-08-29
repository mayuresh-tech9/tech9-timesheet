<?php


namespace App\Http\Helpers;


use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SettingsHelper
{

    static function getSettings()
    {
        $jsonData = file_get_contents(storage_path('app/api_credentials.json'));
        $data = json_decode($jsonData, true);

        return $data;
    }
    static function updateSetting($key, $value)
    {
        $jsonData = file_get_contents(storage_path('app/api_credentials.json'));
        $data = json_decode($jsonData, true);
        $data[$key] = $value;
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents(storage_path('app/api_credentials.json'), $jsonData);
    }

}
