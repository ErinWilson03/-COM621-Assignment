@can('delete', App\Models\Vacancy::class)
    <!-- Trigger button -->
    <x-ui.button variant="ored" x-data @click="$dispatch('open-modal')"  class="flex gap-1 items-center">
        <x-ui.svg minus class="sm" /> Delete Vacancy</x-ui.button>
@endcan

<x-ui.modal>
    <x-slot:title>
        Confirm
    </x-slot:title>

    <p class="text-center">Are you sure you want to <span class="text-blue-400 font-bold">PERMANENTLY</span> delete the vacancy for: </p>
    <h3 class="text-center">{{ $vacancy->title }}</h3>

    <x-slot:footer>
    <form method="POST" action="{{ route('vacancies.destroy', $vacancy->reference_number) }}">
        @csrf
        @method('DELETE')
        <div class="flex justify-center space-x-2">
            <x-ui.button type="submit" variant="red">Delete</x-ui.button>
            <x-ui.link variant="light" x-data @click="$dispatch('close-modal')">Cancel</x-ui.link>
        </div>
    </form>
</x-slot:footer>

</x-ui.modal>