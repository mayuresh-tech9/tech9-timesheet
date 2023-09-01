<?php

namespace App\Http\Livewire;

use App\Http\Helpers\HarvestHelper;
use App\Http\Helpers\SettingsHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Native\Laravel\Facades\Notification;

class LogTimeComponent extends Component
{
    public $time;
    public $hours;
    public $description;
    public $selectedItem;
    public $selectedDesc;
    public $projects;
    public $clients;
    public $output;
    public $projectAssignments;
    public $selectedProjectId;

    public $setAsDefault = true;
    public $selectedTaskId;
    public $existingEntries;
    public $idToEdit = null;
    public $updated = false;
    protected $rules = [
        'time' => 'required',
        'hours' => ['required', 'regex:/^(?:[0-9]|0[0-9]|1[0-9]|2[0-3])(?::[0-5][0-9])?$/'],
    ];
    public function mount($time)
    {
        // This method is called when the component is mounted.
        // Here, we'll set the $time property from the URL parameter.
        $this->time = $time;
        $this->output = [];
        $this->projectAssignments = HarvestHelper::getProjects();
        $data = SettingsHelper::getSettings();
        $this->selectedProjectId = $data['default_project_id'] ?? '';
        $this->selectedTaskId = $data['default_task_id'] ?? '';
        $this->getLocalProjects();
        $this->existingEntries = HarvestHelper::getLogs($time);
    }

    public function toggleCheckbox()
    {
        $this->setAsDefault = !$this->setAsDefault;
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
    public function setUpdated()
    {
        Log::info("setting updated true");
        $this->updated = true;
    }
    public function submitForm()
    {
        $this->validate();
        Log::info($this->idToEdit);
        Log::info($this->updated === true);
        if ($this->idToEdit) {
            if (!$this->updated) {
                return;
            }
            $postData = array(
                'hours' => $this->hours,
                'notes' => $this->description
            );
            $postFields = http_build_query($postData);
            list($url, $headers, $handle) = HarvestHelper::init();
            curl_setopt($handle, CURLOPT_URL, $url . "time_entries/" . $this->idToEdit);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($handle, CURLOPT_POSTFIELDS, $postFields);
            curl_setopt($handle, CURLOPT_HTTPHEADER, array(
                'Content-Length: ' . strlen($postFields)
            ));
            curl_setopt($handle, CURLOPT_CUSTOMREQUEST, "PATCH");
            curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($handle, CURLOPT_USERAGENT, "PHP Harvest API Sample");

        } else {
            list($url, $headers, $handle) = HarvestHelper::init();
            if ($this->setAsDefault) {
                SettingsHelper::updateSetting('default_project_id', $this->selectedProjectId);
                SettingsHelper::updateSetting('default_task_id', $this->selectedTaskId);
            }
            $postData = array(
                'hours' => $this->hours,
                'notes' => $this->description
            );
            $postFields = http_build_query($postData);
            curl_setopt($handle, CURLOPT_URL, $url . "time_entries?project_id=$this->selectedProjectId&task_id=$this->selectedTaskId&spent_date=$this->time");
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($handle, CURLOPT_POSTFIELDS, $postFields);
            curl_setopt($handle, CURLOPT_HTTPHEADER, array(
                'Content-Length: ' . strlen($postFields)
            ));
            curl_setopt($handle, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($handle, CURLOPT_USERAGENT, "PHP Harvest API Sample");

        }
        $response = curl_exec($handle);
        if ($response !== false) {
            $this->cancelEdit();
            Notification::title('Time logged successfully')
                ->message(!$this->idToEdit ? 'Time log added successfully.' : 'Time log updated successfully.')
                ->show();
        } else {
            Notification::title('Error  logging time')
                ->message('Something went wrong.')
                ->show();
        }
        $this->idToEdit = null;
        $this->updated = false;

        return redirect()->route('logs');

    }

    public function render()
    {
        return view('livewire.log-time-component');
    }

    public function getCommits()
    {
        $jsonData = file_get_contents(storage_path('app/api_credentials.json'));
        $data = json_decode($jsonData, true);

        $githubHanlde = $data['github_handle'] ?? '';
        $path = $this->projects[$this->selectedItem];
        chdir($path);
        $formatted_date = Carbon::parse($this->time)->startOfDay()->format('Y-m-d H:i:s');
        $next_day = Carbon::parse($this->time)->endOfDay()->format('Y-m-d H:i:s');
        exec("git log --all --no-merges --pretty=oneline --abbrev-commit --date=short --author=$githubHanlde --since='$formatted_date' --before='$next_day'", $this->output);
    }

    public function appendString()
    {
        $this->description .= trim($this->description) === '' ? $this->selectedDesc : PHP_EOL . $this->selectedDesc;
    }
    public function editLog($id)
    {
        $this->idToEdit = $id;
        $logDetails = HarvestHelper::getTimeEntryDetails($id);
        $this->selectedProjectId = $logDetails['project']['id'];
        $this->selectedTaskId = $logDetails['task']['id'];
        $this->hours = $logDetails['hours'];
        $this->description = $logDetails['notes'];
        Log::info($logDetails);

    }
    public function cancelEdit()
    {
        $this->hours = null;
        $this->description = '';
        $this->idToEdit = null;
    }



}
