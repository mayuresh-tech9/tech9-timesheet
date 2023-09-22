<div>
  <div class="flex justify-center items-center border-2 m-5 bg-gray-50">
    <form wire:submit.prevent="submit">
      <label for="dayOfMonth">Day of the Month (1-31):</label>
      <input type="text" wire:model="dayOfMonth" id="dayOfMonth">
      @error('dayOfMonth') <span class="text-red-500">{{ $message }}</span> @enderror
      <br>
      <div class="flex justify-center items-center border-2 m-1.5 p-1.5">
        <select wire:model="selectedItem" id="dropdown">
          <option value="">Select project</option>
          @foreach ($projects as $key => $value)
            <option value="{{ $key }}">{{ $key }}</option>
          @endforeach
        </select>
      </div>
      <button type="submit">Submit</button>
    </form>


  </div>
  @if ($result)
    <p>Selected Day of the Month: {{ $result }}</p>
  @endif
</div>
