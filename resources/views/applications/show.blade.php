<x-layout>
    <x-ui.breadcrumb class="my-3" :crumbs="[
        'Home' => route('home'),
        'Applications' => route('applications.index'),
        $application->vacancy_reference => '',
    ]" />

    <div class="mx-5">
        <x-ui.header>
            <h1 class="text3xl font-bold text-blue-500 ml-4">{{ $application->vacancy_reference }} -
                <span class="text-blue-900">{{ $vacancy->title }}</span>
            </h1>
        </x-ui.header>

        @include('applications._application-details', ['application' => $application])
    </div>
</x-layout>
