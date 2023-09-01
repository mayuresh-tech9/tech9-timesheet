<div>
    <div class="flex justify-center items-center">
    <div class="grid-cols-1 w-6/12 ml-20">
        <div class="grid grid-cols-2 gap-2">
        <a href="{{route('logs')}}" >
            &#8635; Refresh
        </a>

        <button wire:click="toggleDetails">
            @if($showDetails)
                <h>Hide Details</h>
            @else
                Show Details
            @endif</button>
        </div>
    </div></div>
    @if(count($data['missingEntries']) === 0 && count($data['lesserHours']) === 0 && count($data['missingNotes']) === 0)
        <div class="flex justify-center items-center">
            <div class="p-4 rounded-lg shadow-lg">
                <h1 class="text-xl font-bold mb-4">You are awesome!!!</h1>
                Jason Loves you :)
            </div>
        </div>
    @elseif($showDetails)
        @if(count($data['missingEntries']) > 0)
            <div class="flex justify-center items-center">
                <div class="p-4 rounded-lg shadow-lg">
                    <h1 class="text-xl font-bold mb-4">Missing time entries</h1>
                    <table>
                        <thead class="bg-blue-400 text-white">
                        <tr>
                            <td class="px-4 py-2">Date</td>
                            <td class="px-4 py-2">Action</td>
                        </tr>

                        </thead>
                        <tbody>

                        @foreach ($data['missingEntries'] as $key => $item)
                            <tr>
                                <!-- Your table rows here -->
                                <td class="px-4 py-2">
                                    {{$item}}
                                </td>
                                <td class="px-4 py-2">
                                    <a href="/log-time/{{$item}}"> Add </a>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        @if(count($data['lesserHours']) > 0)
                <div class="flex justify-center items-center">
                    <div class="p-4 rounded-lg shadow-lg">
                        <h1 class="text-xl font-bold mb-4">Dates missing hours</h1>
                    <table>
                        <thead class="bg-blue-400 text-white">
                        <tr class="bg-blue-400 text-white">
                        <tr>
                            <td class="px-4 py-2">Date</td>
                            <td class="px-4 py-2">Action</td>
                        </tr>

                        </thead>
                        <tbody>

                        @foreach ($data['lesserHours'] as $key => $item)
                            <tr>
                                <!-- Your table rows here -->
                                <td class="px-4 py-2">
                                    {{$item}}
                                </td>
                                <td class="px-4 py-2">
                                    <a href="/log-time/{{$item}}"> Add/Update </a>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        @if(count($data['missingNotes']) > 0)
                <div class="flex justify-center items-center">
                    <div class="p-4 rounded-lg shadow-lg">
                        <h1 class="text-xl font-bold mb-4">Dates missing notes</h1>
                        <table>
                            <thead class="bg-blue-400 text-white">
                            <tr class="bg-blue-400 text-white">
                                <td class="px-4 py-2">Date</td>
                                <td class="px-4 py-2">Action</td>
                            </tr>

                            </thead>
                            <tbody>

                            @foreach ($data['missingNotes'] as $key => $item)
                                <tr>
                                    <!-- Your table rows here -->
                                    <td class="px-4 py-2">
                                        {{$item}}
                                    </td>
                                    <td class="px-4 py-2">
                                        <a href="/log-time/{{$item}}"> Add notes </a>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                    </table>
                </div>
            </div>
        @endif
    @else
        <div class="flex justify-center items-center">
            <div class="grid-cols-1 w-6/12 ml-20">
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
                    Billable Hours
                </div>
                <div class="p-4 text-center">
                    {{ $data['billableHours'] }}
                </div>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-2">
            <div class="grid-cols-1">
                <div class="p-4 text-center bg-blue-100">
                    Non-billable Hours
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
