{{--<div class="flex justify-center items-center">--}}
{{--    <h1>Log Time: {{ $time }}</h1>--}}
{{--</div>--}}
<div class="flex justify-center items-center border-2 m-5 bg-gray-50">
    <form wire:submit.prevent="submitForm">
        <div class="flex justify-center items-center border-2 m-1.5">
            <h1>Date: {{ $time }}</h1>
        </div>
        <div>
            <div class="flex justify-center items-center border-2 m-1.5 p-1.5">
                <select wire:model="selectedItem" id="dropdown">
                    <option value="">Select project</option>
                    @foreach ($projects as $key => $value)
                        <option value="{{ $key }}">{{ $key }}</option>
                    @endforeach
                </select>
                <button wire:click="getCommits" class="@if(!$selectedItem) bg-gray-400 @else bg-blue-400 @endif text-white rounded p-1.5 ml-2" @if(!$selectedItem) disabled @endif>Get Commits</button>
            </div>
                <div class="flex justify-center items-center border-2 m-1.5 p-1.5">
                    <select wire:model="selectedDesc" id="dropdown" @if(!$selectedItem) disabled @endif>
                        <option value="">Select an commit</option>
                        @foreach ($output as $key => $value)
                            <option value="{{ substr($value, strpos($value, ' ') + 1) }}">{{ substr($value, strpos($value, ' ') + 1) }}</option>
                        @endforeach
                    </select>
                    <button wire:click="appendString" class="@if(!$selectedDesc) bg-gray-400 @else bg-blue-400 @endif text-white rounded p-1.5 ml-2" @if(!$selectedDesc) disabled @endif>Add</button>
                </div>
        </div>
        <div>


            <div class="flex justify-center items-center border-2">
                <select wire:model="selectedProjectId" id="projectList">
                    <option value="">Select Project...</option>
                    @foreach ($projectAssignments as $assignment)
                        <option value="{{ $assignment['project']['id'] }}">{{ $assignment['client']['name'] }} - {{ $assignment['project']['name'] }}</option>
                    @endforeach
                </select>
            </div>
                @if ($selectedProjectId)
                    <div class="flex justify-center items-center border-2">
                        <select wire:model="selectedTaskId" id="taskList">
                            <option value="">Select a Task</option>
                            @foreach ($projectAssignments as $assignment)
                                @if ($assignment['project']['id'] == $selectedProjectId)
                                    @foreach ($assignment['task_assignments'] as $taskAssignment)
                                        <option value="{{ $taskAssignment['task']['id'] }}">{{ $taskAssignment['task']['name'] }}</option>
                                    @endforeach
                                @endif
                            @endforeach
                        </select>
                    </div>
                @endif
                <label class="flex justify-center items-center border-2">
                    <input type="checkbox" wire:model="setAsDefault" wire:click="toggleCheckbox">
                    Set project as default
                </label>
        </div>
            <div class="flex justify-center items-center">
                <textarea wire:model="description" id="time_entry" rows="5" cols="40" class="border-2 rounded" placeholder="Description"></textarea>
            </div>
            <div class="flex justify-center items-center">
                <input type="text" wire:model="hours" id="time_entry_hours" class="border-2 rounded p-2 w-11/12" placeholder="8:00"  />
            </div>
             <div class="flex justify-center items-center">
                    <button type="submit" class="bg-blue-400 text-white rounded p-1.5 mt-2 hidden" >Submit</button>
                    <button wire:click="toggleSubmit" class="bg-blue-400 text-white rounded p-1.5 mt-2 @if($idToEdit) hidden @endif" @if($idToEdit) disabled  @endif>Submit</button>
            @if($idToEdit)
                <button wire:click="setUpdated" class="bg-blue-400 text-white rounded p-1.5 mt-2">Update</button>
                <button wire:click="cancelEdit" class="bg-gray-400 text-white rounded p-1.5 mt-2">Cancel</button>
           @endif
        </div>
            @if(!$idToEdit)
                <div class="flex justify-center items-center border-2 m-5">
                    @if(count($existingEntries) > 0)
                        <div class="flex justify-center items-center">
                            <div class="p-4 rounded-lg shadow-lg">
                                <h1 class="text-xl font-bold mb-4">Time entries</h1>
                                <table>
                                    <thead class="bg-blue-400 text-white">
                                    <tr>
                                        <td class="px-4 py-2">Project</td>
                                        <td class="px-4 py-2">Notes</td>
                                        <td class="px-4 py-2">Hours</td>
                                        <td class="px-4 py-2">Action</td>
                                    </tr>

                                    </thead>
                                    <tbody>

                                    @foreach ($existingEntries as $key => $item)
                                        <tr>
                                            <!-- Your table rows here -->
                                            <td class="px-4 py-2">{{$item['project']['name'] . '-' . $item['task']['name']}}</td>
                                            <td class="px-4 py-2">
                                                {{$item['notes']}}
                                            </td>
                                            <td class="px-4 py-2">
                                                {{$item['hours']}}
                                            </td>
                                            <td class="px-4 py-2">
                                                <button wire:click="editLog({{ $item['id'] }})" class="bg-blue-400 text-white rounded p-1.5">Edit</button>
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>

            @endif

    </form>
</div>

