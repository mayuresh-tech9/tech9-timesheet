<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SettingsComponent extends Component
{
    public $apiKey;
    public $accountId;
    public $githubHandle;
    public $baseProjectFolder;

    public function mount()
    {
        $jsonData = file_get_contents(storage_path('app/api_credentials.json'));
        $data = json_decode($jsonData, true);

        if ($data) {
            $this->accountId = $data['account_id'] ?? '';
            $this->apiKey = $data['api_key'] ?? '';
            $this->githubHandle = $data['github_handle'] ?? '';
            $this->baseProjectFolder = $data['base_project_folder'] ?? '';
        }
        // Load the API key from the database or any other storage if required
//        $this->apiKey = '2708226.pt.VmS0xdJd9MQm8_uovjL5EGfvwePLBcVQKN5DvQStmmlW8Rh7N2NsHuWBYkyz1p_opMYEOna0Qt0p87dH4pcJsw'; // Load the saved API key here
//        $this->accountId = '1445776'; // Load the saved API key here
    }

    public function saveApiKey()
    {
        $data = [
            'account_id' => $this->accountId,
            'api_key' => $this->apiKey,
            'github_handle' => $this->githubHandle,
            'base_project_folder' => $this->baseProjectFolder,
        ];

        $jsonData = json_encode($data, JSON_PRETTY_PRINT);

        file_put_contents(storage_path('app/api_credentials.json'), $jsonData);

        // Save the API key to the database or any other storage
        // Implement your logic to save the API key here
        session()->flash('message', 'API key saved successfully.');
    }

    public function render()
    {
        return view('livewire.settings-component');
    }
}
