<x-layout>
    <x-ui.breadcrumb class="my-3" :crumbs="['Home' => '']" />

    <!-- Banner Section -->
    <section class="relative py-16 px-6 lg:px-16 mb-16">
        <div class="absolute inset-0 bg-cover bg-center bg-fixed opacity-40"
            style="background-image: url('{{ asset('site-banner.webp') }}');" role="img"
            aria-label="A welcoming banner for job search">
        </div>
    </section>

    <!-- Main Content Section -->
    <section class="py-5 lg:px-6 mb-16">
        <div class="flex flex-col items-center justify-center mx-auto max-w-screen-xl text-center">
            <h1
                class="flex gap-2 items-baseline mb-8 text-4xl font-extrabold tracking-tight leading-tight text-blue-700 md:text-5xl lg:text-6xl">
                <span>VacancyPal</span>
                <x-ui.svg logo size="lg" alt="VacancyPal logo" role="img" aria-label="VacancyPal logo" />
            </h1>
            <div class="text-lg font-medium text-gray-700 mb-8 px-6 md:px-0">
                <!-- For Authors/Admins -->
                @can('create', App\Models\Vacancy::class)
                    <p class="text-xl font-semibold text-gray-800">Welcome back to the leading place to manage vacancies and
                        applications!</p>
                @endcan

                <!-- For Users -->
                @can('apply', App\Models\Application::class)
                    <p class="text-xl font-semibold text-gray-800">Continue your job search journey now</p>
                @endcan

                <!-- For Guests -->
                @guest
                    <p class="text-xl font-semibold text-gray-800">Start your job searching journey now!</p>
                @endguest
            </div>

            <!-- Action Links Container -->
            <div class="flex flex-wrap justify-center gap-6">
                <!-- For Authors/Admins (only roles which can create vacancies)-->
                @can('create', App\Models\Vacancy::class)
                    <div class="transform hover:scale-105 hover:shadow-xl transition-all duration-300 ease-in-out">
                        <x-ui.link variant="light" href="{{ route('applications.index') }}"
                            class="flex flex-col items-center gap-4 text-gray-800" aria-label="View all applications">
                            <x-ui.svg icon="eye" size="lg" alt="View applications" />
                            <span class="text-xl font-semibold">View Applications</span>
                        </x-ui.link>
                    </div>

                    <div class="transform hover:scale-105 hover:shadow-xl transition-all duration-300 ease-in-out">
                        <x-ui.link variant="blue" href="{{ route('vacancies.index') }}"
                            class="flex flex-col items-center gap-4" aria-label="View all vacancies">
                            <x-ui.svg icon="briefcase" size="lg" alt="View all vacancies" />
                            <span class="text-xl font-semibold">View All Vacancies</span>
                        </x-ui.link>
                    </div>

                    <div class="transform hover:scale-105 hover:shadow-xl transition-all duration-300 ease-in-out">
                        <x-ui.link variant="light" href="{{ route('vacancies.create') }}"
                            class="flex flex-col items-center gap-4" aria-label="Create a new vacancy">
                            <x-ui.svg icon="plus-circle" size="lg" alt="Create a new vacancy" />
                            <span class="text-xl font-semibold">Create a New Vacancy</span>
                        </x-ui.link>
                    </div>
                @endcan

                <!-- For users (only roles which can apply) -->
                @can('apply', App\Models\Application::class)
                    <div class="transform hover:scale-105 hover:shadow-xl transition-all duration-300 ease-in-out">
                        <x-ui.link href="{{ route('vacancies.index') }}" role="button"
                            class="flex flex-col items-center gap-4 " variant="blue"
                            aria-label="Browse available vacancies">
                            <x-ui.svg icon="search" size="lg" alt="Browse vacancies" />
                            <span class="text-xl font-semibold">Browse Vacancies</span>
                        </x-ui.link>
                    </div>
                @endcan

                <!-- For guests -->
                @guest
                    <div class="transform hover:scale-105 hover:shadow-xl transition-all duration-300 ease-in-out">
                        <x-ui.link href="{{ route('vacancies.index') }}" role="button"
                            class="flex flex-col items-center gap-4" variant="blue"
                            aria-label="Start your job search journey">
                            <x-ui.svg icon="search" size="lg" alt="Start job search" />
                            <span class="text-xl font-semibold">Start Your Job Search</span>
                        </x-ui.link>
                    </div>
                @endguest
            </div>
        </div>
    </section>
</x-layout>
