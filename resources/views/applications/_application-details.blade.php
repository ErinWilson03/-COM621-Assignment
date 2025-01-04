<div class="w-full flex justify-between items-center gap-4 mb-4">
    <h2 class="text-3xl font-semibold text-blue-900">Application Details</h2>

    <!-- Buttons -->
    <div class="flex gap-4 ml-auto">
        @can('edit', App\Models\Application::class)
            <x-ui.link href="{{ route('applications.edit', $application->id) }}"
                class="px-4 py-2 text-white bg-green-600 hover:bg-green-500 rounded-lg transition">
                Edit
            </x-ui.link>
        @endcan

        @can('dellete', App\Models\Application::class)
            @include('applications._delete', ['application' => $application])
        @endcan

    </div>
</div>
{{-- Application Information --}}
<x-ui.card class="mb-4 p-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Applicant Name -->
        <div class="col-span-1 flex justify-center items-center">
            <h3 class="font-semibold text-blue-700 text-xl">
                Applicant Name:
                <span class="font-normal text-gray-800">{{ $application->name }}</span>
            </h3>
        </div>

        <div class="col-span-2 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
            <!-- Dates -->
            <div class="flex items-center gap-2">
                <x-ui.badge class="px-2 py-1 text-sm text-white bg-indigo-600 rounded">
                    Applied On:
                </x-ui.badge>
                <span class="text-gray-500 text-sm">{{ $application->created_at }}</span>
            </div>
            <div class="flex items-center gap-2">
                <x-ui.badge class="px-2 py-1 text-sm text-white bg-purple-600 rounded">
                    Last Update:
                </x-ui.badge>
                <span class="text-gray-500 text-sm">{{ $application->updated_at }}</span>
            </div>

            <!-- Contact info -->
            <div>
                <h4 class="text-sm text-gray-700 font-medium">
                    Mobile: <span class="font-normal">{{ $application->mobile_number }}</span>
                </h4>
                <div>
                    <h4 class="text-sm text-gray-700 font-medium">
                        Email: <span class="font-normal">{{ $application->email }}</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Supporting Statement -->
    <div class="mt-6 border-t pt-4">
        <h4 class="text-lg text-gray-700 font-medium">
            Supporting Statement:
        </h4>
        <p class="mt-2 text-gray-600 leading-relaxed">
            {{ $application->supporting_statement }}
        </p>
    </div>
</x-ui.card>


<h2 class="text-3xl font-semibold text-blue-900 mb-4">Vacancy Details</h2>
{{-- Vacancy Information --}}
<x-ui.card class="mb-4">
    <div class="flex items-center gap-4 m-4">
        <div class="flex items-center gap-4 w-full">
            <div class="w-3/4">
                <h2>{{ $vacancy->title }} </h2>
            </div>
            <div class="w1/4">
                <a href="{{ route('vacancies.show', $application->vacancy_reference) }}"
                    class="float-right w-full text-white bg-blue-900 hover:bg-blue-700 px-4 py-2 rounded-lg flex items-center justify-center">
                    View Original Vacancy Listing
                </a>
            </div>
        </div>
    </div>

    {{-- Company Logo and Name --}}
    <div class="flex items-center gap-4 m-4">

        <div class="flex items-center gap-4 w-1/3">
            <img src="{{ asset($vacancy->company->logo) }}" alt="{{ $vacancy->company->company_name }} Logo"
                class="w-24 h-24 rounded-full object-cover shadow-md">

            <h2 class="font-semibold text-blue-700 text-xl">
                {{ $vacancy->company->company_name }}
            </h2>
        </div>
        <div class="w-1/3">
            <h3 class="text-sm text-gray-500">Reference Number: {{ $vacancy->reference_number }}</h3>

            <div class="inline-flex">
                <x-ui.badge class="text-sm text-gray-500" variant="indigo">
                    {{ $vacancy->industry }}
                    Industry
                </x-ui.badge>
                <x-ui.badge class="ml-2 text-sm">{{ $vacancy->vacancy_type }}</x-ui.badge>
            </div>
        </div>

    </div>

    {{-- Vacancy Information --}}
    <div class="flex gap-2 mt-4">
        <div class="w-1/2">
            <h3 class="text-2xl font-semibold text-blue-500">Job Description</h3>
            <p class="text-lg text-gray-700 mt-2">{{ $vacancy->description }}</p>
        </div>

        <div class="w-1/2">
            <h3 class="text-2xl font-semibold text-blue-500">Skills Required</h3>
            <p class="text-lg text-gray-700 mt-2">{{ $vacancy->skills_required }}</p>
        </div>
    </div>

    <div class="flex gap-2 mt-2">
        <div class="w-1/2">
            <h3 class="text-2xl font-semibold text-blue-500">Location</h3>
            <p class="text-lg text-gray-700 mt-1">{{ $vacancy->location }}</p>
        </div>

        <div class="w-1/2">
            <h3 class="text-2xl font-semibold text-blue-500">Salary</h3>
            <p class="text-lg text-gray-700 mt-1">£{{ $vacancy->salary }}</p>
        </div>
    </div>
</x-ui.card>

<x-ui.card class="mb-4">
    <x-ui.button variant="dark" onclick="previewFile()">Preview CV</x-ui.button>
    <x-ui.button variant="red" id="close-preview-btn" class="mt-4 ml-2 hidden" onclick="closePreview()">
        Close Preview
    </x-ui.button>

    <div id="cv-preview" class="mt-4">
        <!-- Preview of the user's CV should show here onClick -->
    </div>
</x-ui.card>


<script>
    function previewFile() {
        const cvPath = "{{ $application->cv_path }}";

        const preview = document.getElementById('cv-preview');
        const closeButton = document.getElementById('close-preview-btn');

        if (cvPath) {
            preview.innerHTML = `<embed src="${cvPath}" width="100%" height="400px" type="application/pdf" />`;
            closeButton.classList.remove('hidden'); // Remove 'hidden' class to show close button
        } else {
            preview.innerHTML = '<p>No CV available to preview.</p>';
        }
    }

    function closePreview() {
        const preview = document.getElementById('cv-preview');
        const closeButton = document.getElementById('close-preview-btn');

        // Clear the preview and hide the button by adding 'hidden' class back
        preview.innerHTML = '';
        closeButton.classList.add('hidden');
    }
</script>
