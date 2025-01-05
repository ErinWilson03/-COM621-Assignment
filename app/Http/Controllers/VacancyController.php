<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vacancy;
use App\Enums\IndustryEnum;
use App\Enums\LocationEnum;
use App\Enums\VacancyTypeEnum;
use App\Http\Requests\VacancyRequest;
use App\Models\Company;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

class VacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the pagination size, defaulting to 10 if not provided
        $size = $request->input('size', 10);
        $search = $request->input('search', null);

        // Prepare filters and sorting parameters
        $filters = [
            'search' => $search,
            'vacancy_type' => $request->input('vacancy_type'),
            'industry' => $request->input('industry'),
            'location' => $request->input('location'),
        ];
        $sort = $request->input('sort', 'application_close_date');
        $direction = $request->input('direction', 'desc');

        $vacancies = $this->filterVacancies($filters, $sort, $direction)
            ->paginate($size)
            ->withQueryString();

        $vacancies = $this->addDeadlineWarnings($vacancies);

        // Return the view with necessary data
        return view('vacancies.index', [
            'vacancies' => $vacancies,
            'search' => $search,
            'vacancyCount' => $vacancies->total(),
            'currentPage' => $vacancies->currentPage(),
            'totalPages' => $vacancies->lastPage(),
            'size' => $size,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $vacancy_reference)
    {
        if (!Gate::allows('view', Vacancy::class)) {
            return redirect()->route('login')->with('warning', 'Please Login to view Vacancy');
        }
        $vacancy = Vacancy::where('reference_number', $vacancy_reference)->firstOrFail();
        $company = Company::where('id', $vacancy->company_id)->first();

        return view('vacancies.show', ['vacancy' => $vacancy, 'company' => $company]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'vacancy' => new Vacancy(),
            'industries' => IndustryEnum::cases(),
            'vacancyTypes' => VacancyTypeEnum::cases(),
            'locations' => LocationEnum::cases(),
            'companies' => Company::all()->pluck('name', 'id'),
        ];

        return view('vacancies.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'title' => ['required', 'string', 'max:100'],
                'company_id' => ['required', 'exists:companies,id'],
                'skills_required' => ['nullable', 'string'],
                'description' => ['nullable', 'string'],
                'application_open_date' => ['required', 'date'],
                'application_close_date' => ['required', 'date', 'after:application_open_date'],
                'location' => ['required', Rule::enum(LocationEnum::class)],
                'salary' => ['nullable'],
                'industry' => ['required', Rule::enum(IndustryEnum::class)],
                'vacancy_type' => ['required', Rule::enum(VacancyTypeEnum::class)],
            ]
        );

        $data['reference_number'] = $this->generateReferenceNumber(); // add the reference number to the data

        $vacancy = Vacancy::create($data);
        $vacancy->save();

        if (!$vacancy) {
            return redirect()->route('vacancies.index')->with('error', 'Error: vacancy not created. Try again later.');
        }

        return redirect()->route('vacancies.index')->with('success', 'Vacancy created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $vacancy_reference)
    {
        $vacancy = Vacancy::where('reference_number', $vacancy_reference)->firstOrFail();
        $data = [
            'vacancy' => $vacancy,
            'industries' => IndustryEnum::cases(),
            'vacancyTypes' => VacancyTypeEnum::cases(),
            'locations' => LocationEnum::cases(),
            'companies' => Company::all()->pluck('name', 'id'),
        ];

        return view('vacancies.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VacancyRequest $request, string $vacancy_reference)
    {
        $vacancy = Vacancy::where('reference_number', $vacancy_reference)->firstOrFail();
        // Validate the data and update existing vacancy
        $updates = $request->validated();
        $vacancy->update($updates);

        return redirect()->route('vacancies.index')->with('success', 'Vacancy updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $vacancy_reference)
    {
        $vacancy = Vacancy::where('reference_number', $vacancy_reference)->firstOrFail();
        $vacancy->delete();
        return redirect()->route('vacancies.index')->with('info', 'Vacancy deleted');
    }

    /**
     * Helper Methods
     */
    public function filterVacancies(array $filters, string $sort = 'application_close_date', string $direction = 'desc')
    {
        // Start building query for vacancies
        $query = Vacancy::with('company');

        // Apply filters if selected
        if (!empty($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }

        if (!empty($filters['vacancy_type']) && $filters['vacancy_type'] !== 'all') {
            $query->where('vacancy_type', $filters['vacancy_type']);
        }

        if (!empty($filters['industry']) && $filters['industry'] !== 'all') {
            $query->where('industry', $filters['industry']);
        }

        if (!empty($filters['location']) && $filters['location'] !== 'all') {
            $query->where('location', $filters['location']);
        }

        // Apply sorting
        return $query->orderBy($sort, $direction);
    }

    public function addDeadlineWarnings($vacancies)
    {
        $vacancies->each(function ($vacancy) {
            $currentDate = now();
            $applicationDeadline = $vacancy->application_close_date;

            $vacancy->isDeadlineApproaching = $currentDate->lt($applicationDeadline) && $currentDate->diffInDays($applicationDeadline) <= 3;
            $vacancy->isDeadlinePassed = $currentDate->greaterThanOrEqualTo($applicationDeadline);
        });

        return $vacancies;
    }

    private function generateReferenceNumber(): string
    {
        $maxAttempts = 10;
        $attempt = 0;

        // Preventing an edge case of an infinite loop
        do {
            $randomNumber = mt_rand(1000, 9999);
            $referenceNumber = "VAC-{$randomNumber}";
            $attempt++;
        } while (Vacancy::where('reference_number', $referenceNumber)->exists() && $attempt < $maxAttempts);

        if ($attempt >= $maxAttempts) {
            throw new \Exception('Failed to generate a unique reference number');
        }

        return $referenceNumber;
    }
}
