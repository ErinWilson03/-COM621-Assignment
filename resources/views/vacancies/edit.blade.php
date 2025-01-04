<x-layout>
    <x-ui.breadcrumb class="my-3" :crumbs="[
        'Home' => route('home'),
        'Vacancies' => route('vacancies.index'),
        $vacancy->reference_number => route('vacancies.show',  $vacancy->reference_number),
        'Edit' => '',
    ]" />

    <x-ui.header>
        <h2 class="ml-5">Edit Vacancy {{ $vacancy->reference_number }}</h2>
    </x-ui.header>

    <x-ui.card>
        <form method="POST" action="{{ route('vacancies.update',  $vacancy->reference_number) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('vacancies._inputs')

            <div class="mt-4">
                <x-ui.button variant="blue" type="submit">Save</x-ui.button>
                <x-ui.link variant="blue" href="{{ route('vacancies.show',  $vacancy->reference_number) }}">Cancel</x-ui.link>
            </div>
        </form>
    </x-ui.card>

</x-layout>