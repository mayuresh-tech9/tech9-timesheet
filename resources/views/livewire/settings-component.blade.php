<div class="settings">
{{--    <div class="grid-cols-1 w-6/12 ml-24">--}}
{{--        <div class="grid grid-cols-1 gap-1">--}}
{{--            <h1>Settings</h1>--}}
{{--        </div>--}}
{{--    </div>--}}
    <form wire:submit.prevent="saveApiKey" class="justify-center mt-8">
        <div class="grid-cols-1 w-6/12 ml-20">
            <div class="grid grid-cols-2 gap-1">
                <label class="col-span-1"> API key </label>
                <input class="border rounded-md p-2" width="80%" type="text" wire:model="apiKey" placeholder="Enter your harvest token">
            </div>

        <div class="grid grid-cols-2 gap-1">
            <label> Account Id </label>
            <input class="border rounded-md p-2" width="80%" type="text" wire:model="accountId" placeholder="Enter your harvest Account Id">
        </div>
        <div class="grid grid-cols-2 gap-1">
            <label> GitHub handle </label>
            <input class="border rounded-md p-2" width="80%" type="text" wire:model="githubHandle" placeholder="Enter your gitHub handle">
        </div>
        <div class="grid grid-cols-2 gap-1">
            <label> Base project path </label>
            <input class="border rounded-md p-2" width="80%" type="text" wire:model="baseProjectFolder" placeholder="Base project path">
        </div>
        <div class="grid grid-cols-1 gap-1">
            <button class="bg-orange-500 text-white rounded justify-center mt-2" type="submit">Save</button>
        </div>
        </div>
    </form>
</div>
