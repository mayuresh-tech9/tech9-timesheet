<div class="p-4">
  <div class="flex justify-start items-center space-x-4 ml-10">
    <a href="{{ route('logs') }}" class="btn-refresh">&#8635; Refresh</a>
    <button wire:click="toggleDetails" class="btn-details">
      @if($showDetails)
        Hide Details
      @else
        Show Details
      @endif
    </button>
    <a href="{{ route('auto-import') }}" class="btn-auto-import @if(!$showDetails) disabled @endif">Auto Import</a>
  </div>

  @if(count($data['missingEntries']) === 0 && count($data['lesserHours']) === 0 && count($data['missingNotes']) === 0)
    <div class="flex justify-center items-center mt-8">
      <div class="p-4 rounded-lg shadow-lg">
        <h1 class="text-xl font-bold mb-4">You are awesome!!!</h1>
      </div>
    </div>
  @elseif($showDetails)
    @if(count($data['missingEntries']) > 0)
      <div class="flex justify-center items-center mt-8">
        <div class="p-4 rounded-lg shadow-lg">
          <h1 class="text-xl font-bold mb-4">Missing Time Entries</h1>
          <table class="w-full">
            <thead class="bg-blue-400 text-white">
            <tr>
              <th class="px-4 py-2">Date</th>
              <th class="px-4 py-2">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($data['missingEntries'] as $item)
              <tr>
                <td class="px-4 py-2">{{ $item }}</td>
                <td class="px-4 py-2">
                  <a href="/log-time/{{ $item }}" class="btn-add">Add</a>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    @endif

    @if(count($data['lesserHours']) > 0)
      <div class="flex justify-center items-center mt-8">
        <div class="p-4 rounded-lg shadow-lg">
          <h1 class="text-xl font-bold mb-4">Dates Missing Hours</h1>
          <table class="w-full">
            <thead class="bg-blue-400 text-white">
            <tr>
              <th class="px-4 py-2">Date</th>
              <th class="px-4 py-2">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($data['lesserHours'] as $item)
              <tr>
                <td class="px-4 py-2">{{ $item }}</td>
                <td class="px-4 py-2">
                  <a href="/log-time/{{ $item }}" class="btn-add">Add/Update</a>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    @endif

    @if(count($data['missingNotes']) > 0)
      <div class="flex justify-center items-center mt-8">
        <div class="p-4 rounded-lg shadow-lg">
          <h1 class="text-xl font-bold mb-4">Dates Missing Notes</h1>
          <table class="w-full">
            <thead class="bg-blue-400 text-white">
            <tr>
              <th class="px-4 py-2">Date</th>
              <th class="px-4 py-2">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($data['missingNotes'] as $item)
              <tr>
                <td class="px-4 py-2">{{ $item }}</td>
                <td class="px-4 py-2">
                  <a href="/log-time/{{ $item }}" class="btn-add">Add Notes</a>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    @endif
  @else
    <div class="flex justify-start items-center">
      <div class="grid-cols-1 ml-10">
        <div class="grid grid-cols-2 gap-2">
          <div class="grid-cols-1">
            <div class="p-4 text-center bg-blue-100">
              Total Hours
            </div>
            <div class="p-4 text-center">
              {{ $data['totalHours'] }}
            </div>
          </div>
          <div class="grid-cols-1">
            <div class="p-4 text-center bg-blue-100">
              Billable
            </div>
            <div class="p-4 text-center">
              {{ $data['billableHours'] }}
            </div>
          </div>
        </div>
        <div class="grid grid-cols-2 gap-2">
          <div class="grid-cols-1">
            <div class="p-4 text-center bg-blue-100">
              Non-billable
            </div>
            <div class="p-4 text-center">
              {{ $data['nonBillableHours'] }}
            </div>
          </div>
          <div class="grid-cols-1">
            <div class="p-4 text-center bg-blue-100">
              Missing Days
            </div>
            <div class="p-4 text-center">
              {{ count($data['missingEntries']) }}
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif
</div>
