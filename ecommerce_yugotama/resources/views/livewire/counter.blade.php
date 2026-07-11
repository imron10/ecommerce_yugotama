<div class="p-4 my-4 bg-gray-100 rounded-md border border-gray-200 text-center">
    <h2 class="text-lg font-semibold mb-2">Livewire Counter Test</h2>
    <div class="text-4xl font-bold text-blue-600 mb-4">
        {{ $count }}
    </div>
    <div class="flex gap-2 justify-center">
        <button wire:click="decrement"
            class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md transition">
            - Kurang
        </button>
        <button wire:click="increment"
            class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-md transition">
            + Tambah
        </button>
    </div>
</div>
