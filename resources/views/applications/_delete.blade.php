<x-ui.button variant="ored" x-data @click="$dispatch('open-modal')">Delete</x-ui.button>

<x-ui.modal>
    <x-slot:title>
        Confirm
    </x-slot:title>

    <p class="text-center">Are you sure you want to <span class="text-blue-400 font-bold">PERMANENTLY</span> delete the
        application for: </p>
    <h3 class="text-center">{{ $application->vacancy_reference }}</h3>

    <x-slot:footer>
        <form method="POST" action="{{ route('applications.destroy', $application->id) }}">
            @csrf
            @method('DELETE')
            <div class="flex justify-center space-x-2">
                <x-ui.button type="submit" variant="red">Delete</x-ui.button>
                <x-ui.link variant="light" x-data @click="$dispatch('close-modal')">Cancel</x-ui.link>
            </div>
        </form>
    </x-slot:footer>

</x-ui.modal>
