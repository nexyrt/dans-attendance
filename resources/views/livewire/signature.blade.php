<div  class="relative shadow-xl bg-white rounded-lg p-6 flex flex-col gap-4">
    <x-signature-pad wire:model.defer="signature">

    </x-signature-pad>
    <button wire:click="submit" class="text-black border-amber-500 bg-amber-400">
        Submit
    </button>
</div>