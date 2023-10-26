<div class="flex justify-center items-center border-2 m-5 bg-gray-50">
  <form wire:submit.prevent="submit">
    <label for="dayOfMonth">Day of the Month (1-31):</label>
    <input type="text" wire:model="dayOfMonth" id="dayOfMonth" class="border-2 rounded" placeholder="1,12-15">
    @error('dayOfMonth') <span class="text-red-500">{{ $message }}</span> @enderror

    <div class="flex justify-center items-center border-2 m-1.5 p-1.5">
      <select wire:model="selectedItem" id="dropdown">
        <option value="">Select project</option>
        @foreach ($projects as $key => $value)
          <option value="{{ $key }}">{{ $key }}</option>
        @endforeach
      </select>
    </div>

    <div class="grid grid-cols-2">
      <div>
        <select wire:model="selectedProjectId" id="projectList">
          <option value="">Select Project...</option>
          @foreach ($projectAssignments as $assignment)
            <option value="{{ $assignment['project']['id'] }}">{{ $assignment['client']['name'] }} - {{ $assignment['project']['name'] }}</option>
          @endforeach
        </select>
      </div>
      @if ($selectedProjectId)
        <div>
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
    </div>

    <div class="grid grid-cols-2">
      <textarea wire:model="defaultDescription" id="time_entry" rows="5" cols="40" class="border-2 rounded" placeholder="Default Description"></textarea>
      <textarea wire:model="defaultTime" id="time_entry" rows="1" cols="40" class="border-2 rounded" placeholder="Default hours"></textarea>
    </div>
    <div class="flex justify-center">
      <button type="submit" class="bg-blue-400 text-white rounded p-1.5 mt-2">Submit</button>
    </div>
  </form>
</div>
