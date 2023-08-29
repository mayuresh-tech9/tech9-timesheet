<?php


namespace App\Http\Helpers;


use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class HarvestHelper
{
    static function getLogs()
    {
        $currentDate = Carbon::now()->format('Ymd');
        $startOfMonth = Carbon::now()->startOfMonth()->format('Ymd');
        list($url, $headers, $handle) = self::init();
        curl_setopt($handle, CURLOPT_URL, $url . "reports/time/projects?from=$startOfMonth&to=$currentDate");
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($handle, CURLOPT_USERAGENT, "PHP Harvest API Sample");

        $response = curl_exec($handle);
        $projectIds = collect(json_decode($response, true)['results'])->pluck('client_id')->toArray();
        $timeEntries = [];
        $projectIds = array_unique($projectIds);
        foreach ($projectIds as $projectId) {
            $currentDate = Carbon::now()->format('Y-m-d');
            $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
            curl_setopt($handle, CURLOPT_URL, $url . "time_entries?user_id=3843559&client_id=$projectId&from=$startOfMonth&to=$currentDate");
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($handle, CURLOPT_USERAGENT, "PHP Harvest API Sample");

            $response = curl_exec($handle);
            $timeEntries = array_merge($timeEntries, json_decode($response, true)['time_entries']);
        }
        $currentMonth = Carbon::now();
        $numberOfDaysInMonth = $currentMonth->daysInMonth;

        $weekdays = [];
        for ($day = 1; $day <= $numberOfDaysInMonth; $day++) {
            $date = Carbon::create($currentMonth->year, $currentMonth->month, $day);

            if ($date <= Carbon::now() && $date->isWeekday()) {
                $weekdays[] = $date->toDateString();
            }
        }
        $timeEntriesByWeekday = [];
        $timeEntriesMissingNotes = [];
        $billableEntries = [];
        $nonBillableEntries = [];
        $totalHours = 0.0;
        $billableHours = 0.0;
        $nonBillableHours = 0.0;
        Log::info(count($timeEntries));
        foreach ($timeEntries as $timeEntry) {
            if ($timeEntry['billable'] === true) {
                if (!isset($billableEntries[$timeEntry['spent_date']])) {
                    $billableEntries[$timeEntry['spent_date']] = $timeEntry['hours'];
                } else {
                    $billableEntries[$timeEntry['spent_date']] = $billableEntries[$timeEntry['spent_date']] + $timeEntry['hours'];
                }
                $billableHours +=  floatval($timeEntry['hours']);
            } else {
                if (!isset($nonBillableEntries[$timeEntry['spent_date']])) {
                    $nonBillableEntries[$timeEntry['spent_date']] = $timeEntry['hours'];
                } else {
                    $nonBillableEntries[$timeEntry['spent_date']] = $nonBillableEntries[$timeEntry['spent_date']] + $timeEntry['hours'];
                }
                Log::info($timeEntry['spent_date']);
                $nonBillableHours += floatval($timeEntry['hours']);
            }
            if (!isset($timeEntriesByWeekday[$timeEntry['spent_date']])) {
                $timeEntriesByWeekday[$timeEntry['spent_date']] = $timeEntry['hours'];
            } else {
                $timeEntriesByWeekday[$timeEntry['spent_date']] = $timeEntriesByWeekday[$timeEntry['spent_date']] + $timeEntry['hours'];
            }
            if ($timeEntry['hours'] > 0 && $timeEntry['billable'] && trim($timeEntry['notes']) === '') {
                $timeEntriesMissingNotes[$timeEntry['spent_date']] = $timeEntry['spent_date'];
            }
            $totalHours += $timeEntry['hours'];
        }

        $daysMissingTimeEntries = [];
        $daysWithLessTimeEntries = [];
        foreach ($weekdays as $weekday) {
            if (!isset($timeEntriesByWeekday[$weekday])) {
                $daysMissingTimeEntries[] = $weekday;
            } else if ($timeEntriesByWeekday[$weekday] < 8) {
                $daysWithLessTimeEntries[] = $weekday;
            }

        }
        return [
            'missingEntries' => $daysMissingTimeEntries,
            'lesserHours' => $daysWithLessTimeEntries,
            'missingNotes' => $timeEntriesMissingNotes,
            'billableEntries' => $billableEntries,
            'nonBillableEntries' => $nonBillableEntries,
            'totalHours' => $totalHours,
            'billableHours' => $billableHours,
            'nonBillableHours' => $nonBillableHours,
        ];
    }

    static function getProjects()
    {
        list($url, $headers, $handle) = self::init();
        curl_setopt($handle, CURLOPT_URL, $url . "users/me/project_assignments");
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($handle, CURLOPT_USERAGENT, "PHP Harvest API Sample");

        $response = curl_exec($handle);
        Log::info(json_decode($response, true));

        return collect(json_decode($response, true)['project_assignments'])->toArray();
    }

    /**
     * @return array
     */
    public static function init(): array
    {
        $url = "https://api.harvestapp.com/v2/";
        $jsonData = file_get_contents(storage_path('app/api_credentials.json'));
        $data = json_decode($jsonData, true);

        $accountId = $data['account_id'] ?? '';
        $apiKey = $data['api_key'] ?? '';
        $headers = array(
            "Authorization: Bearer " . $apiKey,
            "Harvest-Account-ID: " . $accountId
        );
        $handle = curl_init();
        return array($url, $headers, $handle);
    }


}
