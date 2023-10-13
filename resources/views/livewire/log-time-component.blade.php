<div class="flex justify-center items-center bg-white border-2 mx-2 p-0 rounded-lg shadow-lg relative">
    <h1 class="absolute top-0 left-0 mt-2 ml-2 text-blue-400">Date: {{ $time }}</h1>
    <form wire:submit.prevent="submitForm" class="w-full">
    <div class="mt-4">
            <div class="flex justify-center items-center border-b-2 p-3">
                <select wire:model="selectedItem" id="dropdown" class="w-1/2">
                    <option value="">Select project</option>
                    @foreach ($projects as $key => $value)
                        <option value="{{ $key }}">{{ $key }}</option>
                    @endforeach
                </select>
                <button wire:click="getCommits" class="bg-blue-400 text-white rounded p-2 ml-4" @if(!$selectedItem) disabled @endif>
                    Get Commits
                </button>
            </div>
            <div class="flex justify-center items-center border-b-2 p-3" @if(!$selectedItem) style="opacity: 0.6;" @endif>
                <select wire:model="selectedDesc" id="dropdown" class="w-1/2" @if(!$selectedItem) disabled @endif>
                    <option value="">Select a commit</option>
                    @foreach ($output as $value)
                        <option value="{{ substr($value, strpos($value, ' ') + 1) }}">{{ substr($value, strpos($value, ' ') + 1) }}</option>
                    @endforeach
                </select>
                <button wire:click="appendString" class="bg-blue-400 text-white rounded p-2 ml-4 @if(!$selectedDesc) disabled @endif" @if(!$selectedDesc) disabled @endif>
                    Add
                </button>
            </div>
        </div>
        <div class="mt-4 flex justify-center items-center border-b-2 p-3">
            <select wire:model="selectedProjectId" id="projectList" class="w-1/2">
                <option value="">Select Project...</option>
                @foreach ($projectAssignments as $assignment)
                    <option value="{{ $assignment['project']['id'] }}">{{ $assignment['client']['name'] }} - {{ $assignment['project']['name'] }}</option>
                @endforeach
            </select>
            @if ($selectedProjectId)
                <select wire:model="selectedTaskId" id="taskList" class="w-1/2 ml-4">
                    <option value="">Select a Task</option>
                    @foreach ($projectAssignments as $assignment)
                        @if ($assignment['project']['id'] == $selectedProjectId)
                            @foreach ($assignment['task_assignments'] as $taskAssignment)
                                <option value="{{ $taskAssignment['task']['id'] }}">{{ $taskAssignment['task']['name'] }}</option>
                            @endforeach
                        @endif
                    @endforeach
                </select>
            @endif
        </div>

        <label class="flex justify-center items-center border-b-2 p-3 hidden">
            <input type="checkbox" wire:model="setAsDefault" wire:click="toggleCheckbox" class="text-blue-400">
            Set project as default
        </label>
        <div class="mt-4 flex items-start space-x-4">
            <textarea wire:model="description" id="time_entry" rows="2" class="border-2 rounded w-1/2 p-2" placeholder="Description"></textarea>
            <input type="text" wire:model="hours" id="time_entry_hours" class="border-2 rounded w-1/2 p-2" placeholder="8:00" />
        </div>
        <div class="mt-4 flex justify-center items-center">
            <button type="submit" class="bg-blue-400 text-white rounded p-2 hidden">Submit</button>
            <button wire:click="toggleSubmit" class="bg-blue-400 text-white rounded p-2 ml-4 @if($idToEdit) hidden @endif" @if($idToEdit) disabled @endif>
                Submit
            </button>
            @if($idToEdit)
                <button wire:click="setUpdated" class="bg-blue-400 text-white rounded p-2 ml-4">Update</button>
                <button wire:click="cancelEdit" class="bg-gray-400 text-white rounded p-2 ml-4">Cancel</button>
            @endif
        </div>
        @if(!$idToEdit)
            <div class="mt-4">
                @if(count($existingEntries) > 0)
                    <div class="p-4 rounded-lg shadow-lg">
                        <h1 class="text-xl font-bold mb-4 text-blue-400">Time entries</h1>
                        <table class="w-full">
                            <thead>
                            <tr class="bg-blue-400 text-white">
                                <th class="p-3">Project</th>
                                <th class="p-3">Notes</th>
                                <th class="p-3">Hours</th>
                                <th class="p-3">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($existingEntries as $item)
                                <tr>
                                    <td class="p-3">{{ $item['project']['name'] . ' - ' . $item['task']['name'] }}</td>
                                    <td class="p-3">{{ $item['notes'] }}</td>
                                    <td class="p-3">{{ $item['hours'] }}</td>
                                    <td class="p-3">
                                        <button wire:click="editLog({{ $item['id'] }})" class="bg-blue-400 text-white rounded p-2">
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        @endif
    </form>
</div>
