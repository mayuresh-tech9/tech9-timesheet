<div>
    <h1>Grid View Page</h1>
    <table>
        <thead>
        <tr>
            <!-- Your table header columns here -->
        </tr>
        </thead>
        <tbody>
        @foreach ($data as $item)
            <tr>
                <!-- Your table rows here -->
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
