<?php

namespace App\Http\Livewire;


use App\Http\Helpers\HarvestHelper;
use App\Http\Helpers\SettingsHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Native\Laravel\Facades\Notification;

class AutoImport extends Component
{
    public $dayOfMonth;
    public $result;
    public $projects;
    public $selectedItem;
    public $description;
    public $defaultDescription = '';
    public $defaultTime = '0:00';
    public $hours = 0;
    public $selectedTaskId;
    public $selectedProjectId;
    public $projectAssignments;


    public function mount()
    {
        $data = SettingsHelper::getSettings();
        $this->selectedProjectId = $data['default_project_id'] ?? '';
        $this->selectedTaskId = $data['default_task_id'] ?? '';
        $this->projectAssignments = HarvestHelper::getProjects();
        $this->getLocalProjects();
    }

    public function submit()
    {

//        $this->validate([
//            'dayOfMonth' => [
//                'required',
//                'regex:/^(\d{1,2}(?:-\d{1,2})?(?:,\d{1,2}(?:-\d{1,2})?)*)$/',
//            ],
//            'defaultTime' => 'sometimes|string',
//        ]);

        // Use Carbon to create a date with the provided day of the month
        $days = explode(',', $this->dayOfMonth);

        $validDays = [];

        foreach ($days as $day) {
            // Check if the input contains a range
            if (strpos($day, '-') !== false) {
                list($start, $end) = explode('-', $day);

                // Validate that both start and end are integers within the range 1-31
                if (is_numeric($start) && is_numeric($end) && $start >= 1 && $start <= 31 && $end >= 1 && $end <= 31) {
                    for ($i = $start; $i <= $end; $i++) {
                        $validDays[] = $i;
                    }
                }
            } else {
                // Validate single day
                $day = trim($day);

                if (is_numeric($day) && $day >= 1 && $day <= 31) {
                    $validDays[] = (int)$day;
                }
            }
        }

        // Use Carbon to create dates with the selected days
        foreach ($validDays as $validDay) {
            $this->description = '';
            $this->hours = "0:00";
            $currentDate = Carbon::now();
            $date = Carbon::now()->day($validDay)->format('Y-m-d');
            if ($currentDate->day < $validDay || Carbon::now()->day($validDay)->isWeekend()) {
                continue;
            }
            $commits = $this->getCommits($date);
            foreach ($commits as $commit) {
                $this->appendString($commit);
            }

            list($url, $headers, $handle) = HarvestHelper::init();
            if ($this->description === '') {
                $this->description = $this->defaultDescription;
            } else {
                $this->description .= PHP_EOL . $this->defaultDescription;
            }
            $postData = array(
                'hours' => $this->hours === "0:00" ? $this->defaultTime : $this->hours,
                'notes' => $this->description
            );

            $postFields = http_build_query($postData);
            curl_setopt($handle, CURLOPT_URL, $url . "time_entries?project_id=$this->selectedProjectId&task_id=$this->selectedTaskId&spent_date=$date");
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($handle, CURLOPT_POSTFIELDS, $postFields);
            curl_setopt($handle, CURLOPT_HTTPHEADER, array(
                'Content-Length: ' . strlen($postFields)
            ));
            curl_setopt($handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($handle, CURLOPT_USERAGENT, "PHP Harvest API Sample");

            $response = curl_exec($handle);
            if ($response !== false) {
                Notification::title('Time logged successfully')
                    ->message('Time log added successfully for ' . $date . '.')
                    ->show();
            } else {
                Notification::title('Error  logging time')
                    ->message('Something went wrong.')
                    ->show();
            }
        }


        // Set the result property with the formatted dates
        $this->result = $this->description . PHP_EOL . PHP_EOL . 'Total time: ' . $this->hours;
    }
    public function appendString($desc)
    {
        $position = strpos($desc, '[time]');
        if ($position !== false) {
            $extractedPart = substr($desc, $position + strlen('[time]'));
            $extractedPart = trim($extractedPart);
            $this->hours = HarvestHelper::minutesToTime(HarvestHelper::timeToMinutes($extractedPart) + HarvestHelper::timeToMinutes($this->hours));
            $desc = strstr($desc, "[time]", true);
        }
        $this->description .= trim($this->description) === '' ? $desc : PHP_EOL . $desc;
    }

    public function getLocalProjects()
    {
        $jsonData = file_get_contents(storage_path('app/api_credentials.json'));
        $data = json_decode($jsonData, true);

        $path = $data['base_project_folder'];
        $directories = File::directories($path);

        $sortedFolders = [];
        foreach ($directories as $directory) {
            $folderName = basename($directory);
            $sortedFolders[$folderName] = $directory;
        }

        // Sort the folders by their names
        ksort($sortedFolders);
        $this->projects = $sortedFolders;
    }

    public function getCommits($date)
    {
        $jsonData = file_get_contents(storage_path('app/api_credentials.json'));
        $data = json_decode($jsonData, true);

        $githubHanlde = $data['github_handle'] ?? '';
        $path = $this->projects[$this->selectedItem];
        chdir($path);
        $formatted_date = Carbon::parse($date)->startOfDay()->format('Y-m-d H:i:s');
        $next_day = Carbon::parse($date)->endOfDay()->format('Y-m-d H:i:s');
        exec("git log --all --no-merges --pretty=oneline --abbrev-commit --date=short --author=$githubHanlde --since='$formatted_date' --before='$next_day'", $output);
        $result = [];
        foreach ($output as $res) {
            preg_match('/^([a-zA-Z0-9]+) /', $res, $matches);
            $result[$matches[1]] = substr($res, strpos($res, ' ') + 1);
        }
        return $result;
    }
    public function render()
    {
        return view('livewire.auto-import');
    }
}
