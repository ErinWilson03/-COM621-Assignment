<x-layout>
    <x-ui.breadcrumb class="my-3" :crumbs="[
        'Home' => route('home'),
        'Vacancies' => '',
    ]" />

    <div class="mx-5">
        <x-ui.header>
            <h1 class="text-blue-700">Vacancies</h1>
            @can('create', App\Models\Vacancy::class)
                <x-ui.link variant="light" href="{{ route('vacancies.create') }}"
                    class="flex gap-1 items-center text-blue-600 hover:text-blue-800">
                    <x-ui.svg plus size="sm" />
                    <span>Add New Vacancy</span>
                </x-ui.link>
            @endcan
        </x-ui.header>

        @include('vacancies._search')

        <div class="mt-6 flex justify-between items-center">
            <p class=" ml-4 text-sm text-gray-500">{{ $vacancyCount }} vacancies found</p>

            <div class="flex items-center gap-4">
                <!-- Sort By Dropdown -->
                <form method="GET" action="{{ route('vacancies.index') }}" class="flex items-center gap-2"
                    id="sortForm">
                    <label for="sort" class="text-sm text-gray-600">Sort By:</label>
                    <select name="sort" id="sort" class="p-2 border rounded text-sm text-gray-600">
                        <option value="" {{ !request('sort') ? 'selected' : '' }}>No Sorting</option>
                        <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Title</option>
                        <option value="application_open_date"
                            {{ request('sort') == 'application_open_date' ? 'selected' : '' }}>Opening Date</option>
                        <option value="application_close_date"
                            {{ request('sort') == 'application_close_date' ? 'selected' : '' }}>Closing Date</option>
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

                <!-- Pagination -->
                @include('vacancies._pagination')
            </div>
        </div>

        <div class="container mx-auto px-4 py-8 flex flex-col lg:flex-row gap-6">
            <!-- Filters Section -->
            <aside class="w-full lg:w-1/4 bg-white p-4 rounded-lg shadow-md border border-gray-200">
                <h3 class="text-xl font-semibold text-blue-700 mb-4">Filter Vacancies</h3>

                <form method="GET" action="{{ route('vacancies.index') }}">
                    <input type="hidden" name="sort" value="{{ request('sort', 'id') }}">
                    <input type="hidden" name="direction" value="{{ request('direction', 'asc') }}">

                    <div class="mb-4">
                        <h4 class="text-md font-medium mb-2">Industry</h4>
                        <select name="industry" class="w-full p-2 border rounded text-blue-700">
                            <option value="all">All Industries</option>
                            @foreach (App\Enums\IndustryEnum::cases() as $industry)
                                <option value="{{ $industry->value }}"
                                    {{ request('industry') == $industry->value ? 'selected' : '' }}>
                                    {{ $industry->value }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <h4 class="text-md font-medium mb-2">Vacancy</h4>
                        <select name="vacancy_type" class="w-full p-2 border rounded text-blue-700">
                            <option value="all">All Vacancy Types</option>
                            @foreach (App\Enums\VacancyTypeEnum::cases() as $type)
                                <option value="{{ $type->value }}"
                                    {{ request('vacancy_type') == $type->value ? 'selected' : '' }}>
                                    {{ $type->value }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <h4 class="text-md font-medium mb-2">Location</h4>
                        <select name="location" class="w-full p-2 border rounded text-blue-700">
                            <option value="all">All Locations</option>
                            @foreach (App\Enums\LocationEnum::cases() as $location)
                                <option value="{{ $location->value }}"
                                    {{ request('location') == $location->value ? 'selected' : '' }}>
                                    {{ $location->value }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <x-ui.button type="submit" class="w-full bg-blue-800 text-white p-2 rounded hover:bg-blue-700">
                        Apply Filters
                    </x-ui.button>
                </form>

            </aside>

            <!-- Vacancy Listings Section -->
            <div class="w-full lg:w-3/4">
                <div class="grid grid-cols-1 gap-6">
                    @foreach ($vacancies as $vacancy)
                        <div
                            class="p-6 rounded-lg shadow-lg hover:shadow transition ease-in-out duration-300 flex flex-col lg:flex-row gap-4">
                            <div class="flex-1 pr-0 lg:pr-6">
                                @if ($vacancy->isDeadlineApproaching)
                                    <p class="text-red-600 mt-2">Hurry! The application deadline is approaching.</p>
                                @elseif ($vacancy->isDeadlinePassed)
                                    <p class="text-gray-600 mt-2">Sorry, unfortunately the application deadline has
                                        passed.</p>
                                @endif

                                <div class="flex items-center gap-2">
                                    @if ($vacancy->company->logo)
                                        <img src="{{ asset($vacancy->company->logo) }}"
                                            class="hidden lg:block w-10 h-10 rounded-full object-cover">
                                    @else
                                        <span
                                            class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-white font-bold">{{ substr($vacancy->company->company_name, 0, 1) }}</span>
                                    @endif
                                    <h2 class="text-2xl font-semibold text-blue-500 mb-2">
                                        {{ $vacancy->title }}
                                    </h2>
                                </div>
                                <p class="text-blue-500 mb-4">{{ Str::limit($vacancy->description, 150) }}</p>

                                <div class="flex flex-col gap-2">
                                    <p class="w-fit text-sm"><strong>Industry:</strong> {{ $vacancy->industry }}</p>
                                    <p class="w-fit text-sm"><strong>Vacancy Type:
                                        </strong>{{ ucfirst($vacancy->vacancy_type->value) }}</p>
                                </div>
                            </div>

                            <div
                                class="flex flex-col gap-2 lg:items-start lg:w-1/4 border-t lg:border-t-0 lg:border-l lg:pl-4 pt-4 lg:pt-0 relative">
                                <x-ui.badge class="w-fit text-sm">Opening Date:
                                    {{ \Carbon\Carbon::parse($vacancy->application_open_date)->format('d-m-Y') }}
                                </x-ui.badge>

                                <x-ui.badge class="w-fit text-sm">Closing Date:
                                    {{ \Carbon\Carbon::parse($vacancy->application_close_date)->format('d-m-Y') }}
                                </x-ui.badge>

                                <div class="mt-4 lg:mt-auto w-full">
                                    @if ($vacancy->isDeadlinePassed)
                                        <a
                                            class="disabled w-full text-blue-900 bg-blue-200 px-4 py-2 rounded-lg flex items-center justify-center">
                                            Vacancy Unavailable
                                        </a>
                                    @else
                                        <a href="{{ route('vacancies.show', $vacancy->reference_number) }}"
                                            class="w-full text-white bg-blue-900 hover:bg-blue-700 px-4 py-2 rounded-lg flex items-center justify-center">
                                            View Vacancy
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- Display message if no vacancies are found --}}
                    @if ($vacancies->isEmpty())
                        <p class="text-gray-500">Oops! No vacancies matching the selected criteria.</p>
                    @endif
                </div>

                <!-- Pagination -->
                @if ($vacancies->isNotEmpty())
                    <div class="mt-3 float-right">
                        @include('vacancies._pagination')
                    </div>
                @endif
            </div>
        </div>
</x-layout>
