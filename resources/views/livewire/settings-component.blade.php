<div class="settings">
    <h1>Settings</h1>
    <form wire:submit.prevent="saveApiKey">
        <p><input class="border rounded-md p-2" width="80%" type="text" wire:model="apiKey" placeholder="Enter your harvest token"></p>
        <p><input class="border rounded-md p-2" width="80%" type="text" wire:model="accountId" placeholder="Enter your harvest Account Id"></p>
        <p><input class="border rounded-md p-2" width="80%" type="text" wire:model="githubHandle" placeholder="Enter your gitHub handle"></p>
        <p><input class="border rounded-md p-2" width="80%" type="text" wire:model="baseProjectFolder" placeholder="Base project path"></p>
        <button class="settings-save" type="submit">Save</button>
    </form>
</div>
