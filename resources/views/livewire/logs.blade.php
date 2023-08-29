<div>
    <a href="{{route('logs')}}">Reload</a>

    <button wire:click="toggleDetails">
        @if($showDetails)
            Hide Details
        @else
            Show Details
        @endif</button>
    @if($showDetails)
        @if(count($data['missingEntries']) > 0)
            <table>
                <thead>
                <tr class="headerRow">
                    <td>Dates missing time entries</td>
                    <td>Action</td>
                </tr>

                </thead>
                <tbody>

                @foreach ($data['missingEntries'] as $key => $item)
                    <tr>
                        <!-- Your table rows here -->
                        <td>
                            {{$item}}
                        </td>
                        <td>
                            <a href="/log-time/{{$item}}"> Add time </a>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
        @if(count($data['lesserHours']) > 0)
            <table>
                <thead class="headerRow">
                <tr>
                    <td>Dates having less than 8 hours logged</td>
                    <td>Action</td>
                </tr>

                </thead>
                <tbody>

                @foreach ($data['lesserHours'] as $key => $item)
                    <tr>
                        <!-- Your table rows here -->
                        <td>
                            {{$item}}
                        </td>
                        <td>
                            <a href="/log-time/{{$item}}"> Add time </a>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
        @if(count($data['missingNotes']) > 0)
            <table>
                <thead>
                <tr class="headerRow">
                    <td>Dates missing notes</td>
                    <td>Action</td>
                </tr>

                </thead>
                <tbody>

                @foreach ($data['missingNotes'] as $key => $item)
                    <tr>
                        <!-- Your table rows here -->
                        <td>
                            {{$item}}
                        </td>
                        <td>
                            <a href="/log-time/{{$item}}"> Add notes </a>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
{{--        @if(count($data['billableEntries']) > 0)--}}
{{--            <table>--}}
{{--                <thead>--}}
{{--                <tr class="headerRow">--}}
{{--                    <td>Billable Entries</td>--}}
{{--                    <td>Action</td>--}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody>--}}

{{--                @foreach ($data['billableEntries'] as $key => $item)--}}
{{--                    <tr>--}}
{{--                        <!-- Your table rows here -->--}}
{{--                        <td>--}}
{{--                            {{$key}}--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <a href="/log-time/{{$key}}"> View </a>--}}
{{--                        </td>--}}

{{--                    </tr>--}}
{{--                @endforeach--}}
{{--                </tbody>--}}
{{--            </table>--}}
{{--        @endif--}}
{{--        @if(count($data['nonBillableEntries']) > 0)--}}
{{--            <table>--}}
{{--                <thead>--}}
{{--                <tr class="headerRow">--}}
{{--                    <td>Dates missing notes</td>--}}
{{--                    <td>Action</td>--}}
{{--                </tr>--}}

{{--                </thead>--}}
{{--                <tbody>--}}

{{--                @foreach ($data['nonBillableEntries'] as $key => $item)--}}
{{--                    <tr>--}}
{{--                        <!-- Your table rows here -->--}}
{{--                        <td>--}}
{{--                            {{$key}}--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <a href="/log-time/{{$key}}"> View </a>--}}
{{--                        </td>--}}

{{--                    </tr>--}}
{{--                @endforeach--}}
{{--                </tbody>--}}
{{--            </table>--}}
{{--        @endif--}}
    @else
        <div class="row">
            <div class="columns-1">
                <div class="p-4 text-center bg-blue-100">
                    Total Hours
                </div>
                <div class="p-4 text-center">
                    {{ $data['totalHours'] }}
                </div>
            </div>
            <div class="columns-2">
                <div class="p-4 text-center bg-blue-100">
                    Billable Hours
                </div>
                <div class="p-4 text-center">
                    {{ $data['billableHours'] }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="columns-1">
                <div class="p-4 text-center bg-blue-100">
                    Non-billable Hours
                </div>
                <div class="p-4 text-center">
                    {{ $data['nonBillableHours'] }}
                </div>
            </div>
            <div class="columns-2">
                <div class="p-4 text-center bg-blue-100">
                    Time-entry Missing Days
                </div>
                <div class="p-4 text-center">
                    {{ count($data['missingEntries']) }}
                </div>
            </div>
        </div>
    @endif

</div>
