<div>
    <h1>Log Time: {{ $time }}</h1>
    <form wire:submit.prevent="submit">
        <div>
            <div class="git_comments">
                <label for="git_entries">Get git logs data:</label>
                <label for="dropdown">Select an option:</label>
                <select wire:model="selectedItem" id="dropdown">
                    <option value="">Select an option</option>
                    @foreach ($projects as $key => $value)
                        <option value="{{ $key }}">{{ $key }}</option>
                    @endforeach
                </select>
                @if($selectedItem)
                    <button wire:click="getCommits">Get Commits</button>
                @endif
            </div>
            @if($selectedItem)
                <select wire:model="selectedDesc" id="dropdown">
                    <option value="">Select an option</option>
                    @foreach ($output as $key => $value)
                        <option value="{{ substr($value, strpos($value, ' ') + 1) }}">{{ substr($value, strpos($value, ' ') + 1) }}</option>
                    @endforeach
                </select>
                @if($selectedDesc)
                    <button wire:click="appendString">Add to desc</button>
                @endif
            @endif
        </div>
        <div>
            <label for="time_entry">Enter Time:</label>

            <div>
                <label for="projectList">Select Project:</label>
                <select wire:model="selectedProjectId" id="projectList">
                    <option value="">Select a project...</option>
                    @foreach ($projectAssignments as $assignment)
                        <option value="{{ $assignment['project']['id'] }}">{{ $assignment['client']['name'] }} - {{ $assignment['project']['name'] }}</option>
                    @endforeach
                </select>

                @if ($selectedProjectId)
                    <div>
                        <label for="taskList">Select Task:</label>
                        <select wire:model="selectedTaskId" id="taskList">
                            <option value="">Select a task...</option>
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
                <label>
                    <input type="checkbox" wire:model="setAsDefault" wire:click="toggleCheckbox">
                    Set project as default
                </label>
            </div>

            <div class="harvest_time">
                <textarea wire:model="description" id="time_entry" rows="5" cols="40"></textarea>
                <input type="text" wire:model="hours" id="time_entry_hours" />
                <button type="submit">Submit</button>
            </div>
        </div>

    </form>
</div>
