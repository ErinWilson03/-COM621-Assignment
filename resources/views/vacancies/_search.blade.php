<form method="GET" action="{{ route('vacancies.index') }}" class="flex gap-2 items-center my-2">
    <x-ui.form.input placeholder="Search vacancies..." name="search" value="{{ $search }}" class="px-4 py-2 w-full border-2 border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-blue-700" />
    <x-ui.button variant="blue" >Search</x-ui.button>
    <x-ui.link variant="light" href="{{ route('vacancies.index') }}">
        Clear
    </x-ui.link>
</form>
