<x-layout>
    <x-ui.breadcrumb class="my-3" :crumbs="[
        'Home' => route('home'),
        'Applications' => '',
    ]" />

    <div class="mx-5">
        <x-ui.header>
            <h1 class="text-blue-700">Applications</h1>
        </x-ui.header>

        @include('applications._search')


        {{-- Sorting --}}
        <div class="mt-6 flex justify-between items-center">
            <p class=" ml-4 text-sm text-gray-500">{{ $applicationCount }} applications found</p>

            <form method="GET" action="{{ route('applications.index') }}" class="flex items-center gap-2" id="sortForm">
                <label for="sort" class="text-sm text-gray-600">Sort By:</label>
                <select name="sort" id="sort" class="p-2 border rounded text-sm text-gray-600">
                    <option value="" {{ !request('sort') ? 'selected' : '' }}>No Sorting</option>
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                    <option value="vacancy_reference" {{ request('sort') == 'vacancy_reference' ? 'selected' : '' }}>
                        Vacancy Reference</option>
                </select>

                <select name="direction" id="sort_direction" class="p-2 border rounded text-sm text-gray-600">
                    <option value="" {{ !request('direction') ? 'selected' : '' }}>Default Order</option>
                    <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                    <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Descending
                    </option>
                </select>

                <button type="submit" role="button"
                    class="py-0.5 px-2 mx-2 bg-blue-500 text-white rounded">Apply</button>
            </form>

            @include('applications._pagination')

        </div>

        <div class="container mx-auto px-4 py-8 flex flex-col lg:flex-row justify-center gap-6">
            <div class="w-full lg:w-3/4">
                <div class="grid grid-cols-1 gap-6">
                    @foreach ($applications as $application)
                        <div
                            class="p-6 rounded-lg shadow-lg hover:shadow transition ease-in-out duration-300 flex flex-col lg:flex-row gap-4 items-center justify-center">
                            <div class="w-1/6 flex items-center gap-2 justify-center">
                                <h2 class="text-xl font-semibold text-blue-500 mb-2">
                                    {{ $application->vacancy_reference }}
                                </h2>
                            </div>

                            <p class="w-1/3 text-blue-500 mb-4 text-center">
                                {{ Str::limit($application->supporting_statement, 150) }}</p>

                            <div class="w-1/3 flex-1 pr-0 lg:pr-6 flex flex-col gap-2">
                                <p class="text-sm"><strong>Name:</strong> {{ ucfirst($application->name) }}</p>
                                <p class="text-sm"><strong>Mobile Number:</strong> {{ $application->mobile_number }}
                                </p>
                                <p class="text-sm"><strong>Email:</strong> {{ $application->email }}</p>
                            </div>

                            <div class="w-1/6 mt-4 lg:mt-auto flex flex-col items-end space-y-2">
                                @can('edit', App\Models\Application::class)
                                    <x-ui.link href="{{ route('applications.edit', $application->id) }}"
                                        class="w-full px-4 py-2 flex justify-center items-center gap-2" variant="green">
                                        Edit
                                        <x-ui.svg edit class="sm" />
                                    </x-ui.link>
                                @endcan

                                <x-ui.link href="{{ route('applications.show', $application->id) }}"
                                    class="w-full px-4 py-2 mt-1 flex justify-center items-center gap-2" variant="blue">
                                    View
                                    <x-ui.svg eye class="sm" />
                                </x-ui.link>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
        </div>

        {{-- Display message if no vacancies are found --}}
        @if ($applications->isEmpty())
            <h4 class="text-gray-500">No applications matching the selected criteria!</h4>
        @else
            <div class="my-3 float-right">
                @include('applications._pagination')
            </div>
        @endif
    </div>
</x-layout>
