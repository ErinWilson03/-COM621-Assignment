<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Vacancy;
use App\Models\User;
use Psy\CodeCleaner\FunctionReturnInWriteContextPass;
use Illuminate\Support\Facades\Gate;
use App\Enums\Role;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        if (!Gate::allows('view', Application::class)) {
            return redirect()->route('login')->with('warning', 'Please login to view applications');
        }

        // Sorting, filtering, and pagination setup
        $size = $request->input('size', 10);  // Default to 10 items per page
        $sort = $request->input('sort', 'id'); // Default sort by id
        $direction = $request->input('direction', 'asc');
        $search = $request->input('search', null);

        $query = Application::with('vacancy');

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('vacancy_reference', 'like', "%{$search}%");
            });
        }

        $query->orderBy($sort, $direction);

        // for documenting purposes: user() shows here as an undefined method but it works perfectly fine ...
        $user = auth()->user();

        // Filter applications based on user role
        if ($user && $user->role == Role::USER) {
            // Only pull applications for the specific user
            $applications = $this->getApplicationsForUser($user, $query);
        } elseif ($user && $user->role == Role::AUTHOR) {
            // Only pull applications for vacancies at the company of the user
            $applications = $this->getApplicationsForCompanyVacancies($user, $query);
        } else {
            // Admins: show all applications
            // for documenting purposes: withQueryString shows here as an error but it works perfectly fine ...
            $applications = $query->paginate($size)->withQueryString();
        }

        return view('applications.index', [
            'applications' => $applications,
            'search' => $search,
            'applicationCount' => $applications->total(),
            'currentPage' => $applications->currentPage(),
            'totalPages' => $applications->lastPage(),
            'size' => $size,
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $application = Application::findOrFail($id);
        $vacancy = Vacancy::where('reference_number', $application->vacancy_reference)->first();
        return view('applications.show', ['application' => $application, 'vacancy' => $vacancy]);
    }

    public function apply(string $vacancy_reference)
    {
        $vacancy = Vacancy::where('reference_number', $vacancy_reference)->firstOrFail();
        $user = auth()->user();
        $application = new Application;

        return view('applications.apply', ['vacancy' => $vacancy, 'user' => $user, 'application'=> $application]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'mobile_number' => ['required', 'string', 'min:10'],
            'supporting_statement' => ['nullable', 'string', 'max:1000'],
            'cv_path' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:2048'],
            'vacancy_reference' => ['required', 'exists:vacancies,reference_number'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        // Handle CV file upload
        if ($request->hasFile('cv')) {
            $cvFile = $request->file('cv');
            $cvPath = $cvFile->store('applications/cvs', 'public'); // Store the file in the public disk
            $data['cv_path'] = $cvPath; // Save the file path in the database
        }

        // Create the application record in the database
        $application = Application::create($data);

        return redirect()->route('applications.index')->with('success', 'Your application has been submitted successfully!');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $application = Application::findOrFail($id);
        $vacancy = Vacancy::where('reference_number', $application->vacancy_reference)->first();

        return view('applications.edit', ['application' => $application, 'vacancy' => $vacancy]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'mobile_number' => ['required', 'string', 'min:10'],
            'supporting_statement' => ['nullable', 'string', 'max:1000'],
            'cv' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:2048'],
        ]);

        // Handle CV file upload if a new CV is uploaded
        if ($request->hasFile('cv')) {
            $cvFile = $request->file('cv');
            $cvPath = $cvFile->store('applications/cvs', 'public'); // Store the file
            $data['cv_path'] = $cvPath; // Save the new file path
        }

        $application = Application::findOrFail($id);
        $application->update($data);
        return redirect()->route('applications.show', parameters: $id)->with('success', 'Application updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $application = Application::findOrFail($id);
        $application->delete();

        return redirect()->route('applications.index')->with('success', 'Application deleted successfully!');

    }


    // Helpers for the index method
    public function getApplicationsForUser(User $user, $query)
    {
        // Filter applications based on the user's ID
        return $query->where('user_id', $user->id)->paginate(10)->withQueryString();
    }

    public function getApplicationsForCompanyVacancies(User $user, $query)
    {
        // Assuming the user is an author associated with a company, filter applications by their company ID
        return $query->whereHas('vacancy', function ($vacancyQuery) use ($user) {
            $vacancyQuery->where('company_id', $user->company_id);
        })->paginate(10)->withQueryString();
    }

}
