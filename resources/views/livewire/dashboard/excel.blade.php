@section('title', 'Import & Export')

<div class="space-y-6">

  <div class="space-y-2">
    <div class="block">Export</div>
    <div class="flex items-start justify-start gap-6">
      <div class="flex items-center justify-start w-full p-6 space-x-6 bg-white rounded-2xl">

        <button wire:click="exportProduct1c" class="text-white bg-green-500 btn hover:bg-green-600">
          <div wire:loading wire:target="exportProduct1c">
            <svg class="w-5 h-5 mr-3 -ml-1 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
              </path>
            </svg>
          </div>
          <div>Products 1C</div>
        </button>

      </div>
      <div class="flex items-center justify-start w-full p-6 space-x-6 bg-white rounded-2xl">

      </div>
    </div>
  </div>



  <div class="space-y-2">
    <div class="block">Import</div>
    <div class="flex items-start justify-start space-x-6">

      <div class="p-6 space-y-6 bg-white rounded-2xl">
        <div class="block">import data from excel file (xlsx)</div>

        <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
          x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false"
          x-on:livewire-upload-progress="progress = $event.detail.progress">
          <!-- File Input -->
          <input type="file" wire:model="excel">

          <!-- Progress Bar -->
          <div x-show="isUploading">
            <progress max="100" x-bind:value="progress"></progress>
          </div>
        </div>

        @error('excel') <span class="text-sm text-red-500">{{ $message }}</span> @enderror

        <div class="flex items-center justify-start space-x-4">
          <button wire:click="getFile" class="text-white bg-blue-500 btn hover:bg-blue-600">
            <div wire:loading wire:target="getFile">
              <svg class="w-5 h-5 mr-3 -ml-1 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
              </svg>
            </div>
            <div>import</div>
          </button>
        </div>

      </div>

      <div class="p-6 space-y-6 text-gray-800 bg-white rounded-2xl">
        <div class="block">Import products 1C from <strong>import.xml</strong></div>
        <div>
          <button wire:click="importProducts1Cimport"
            class="text-white bg-blue-500 btn hover:bg-blue-600">Import</button>
        </div>
      </div>

      <div class="p-6 space-y-6 text-gray-800 bg-white rounded-2xl">
        <div class="block">Import from <strong>offers.xml</strong></div>
        <div>
          <button wire:click="importProducts1Coffers"
            class="text-white bg-blue-500 btn hover:bg-blue-600">Import</button>
        </div>
      </div>

    </div>
  </div>

</div>
