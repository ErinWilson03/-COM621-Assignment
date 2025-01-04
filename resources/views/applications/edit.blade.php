<x-layout>
    <x-ui.breadcrumb class="my-3" :crumbs="[
        'Home' => route('home'),
        'Applications' => route('applications.index'),
        $application->vacancy_reference => '',
    ]" />

    <div class="mx-5">
        <x-ui.header>
            <div class="w-full flex justify-between items-center gap-4 mb-4">
                <h1 class="text3xl font-bold text-blue-500 ml-4">{{ $application->vacancy_reference }} -
                    <span class="text-blue-900">{{ $vacancy->title }}</span>
                </h1>
                <!-- Buttons -->
                <div class="flex gap-4 ml-auto">                    
                    @include('applications._delete', ['application' => $application])
                </div>
            </div>
        </x-ui.header>

        <form method="POST" action="{{ route('applications.update', ['id' => $application->id]) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('applications._inputs', ['application' => $application, 'vacancy' => $vacancy])

            <div class="mt-4">
                <x-ui.button variant="blue" type="submit">Save</x-ui.button>
                <x-ui.link variant="light" href="{{ route('applications.show',  ['id' => $application->id]) }}">Cancel</x-ui.link>
            </div>

    </div>
</x-layout>
