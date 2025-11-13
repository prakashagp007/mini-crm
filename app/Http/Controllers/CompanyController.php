<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    public function __construct() {
        // require auth for all company actions
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $companies = Company::orderBy('id','desc')->paginate(10);
        if ($request->ajax()) {
            // return partial table for AJAX refresh
            return view('companies.table', compact('companies'))->render();
        }
        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store(StoreCompanyRequest $request)
    {
        $data = $request->only(['name','email','website']);

        // logo handling
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $name = 'company_logo_'.time().'_'.Str::random(6).'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('logos', $name);
            $data['logo'] = 'storage/logos/'.$name; // public path
        }

        $company = Company::create($data);

        // auto create user account for company so it can login (password 'password')
        if (!empty($company->email)) {
            User::create([
                'name' => $company->name,
                'email' => $company->email,
                'password' => Hash::make('password'),
                'role' => 'company',
                'company_id' => $company->id,
            ]);
        }

        if ($request->ajax()) {
            // return updated table html and success message
            $companies = Company::orderBy('id','desc')->paginate(10);
            return response()->json([
                'status' => 'ok',
                'table' => view('companies.table', compact('companies'))->render(),
                'message' => 'Company created',
            ]);
        }

        return redirect()->route('companies.index')->with('success','Company created.');
    }

    public function show(Company $company)
    {
        return view('companies.show', compact('company'));
    }

    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $data = $request->only(['name','email','website']);

        if ($request->hasFile('logo')) {
            // delete old logo if exists (public path storage/logos/...)
            if ($company->logo) {
                $old = str_replace('storage/','public/',$company->logo);
                if (Storage::exists($old)) Storage::delete($old);
            }
            $file = $request->file('logo');
            $name = 'company_logo_'.time().'_'.Str::random(6).'.'.$file->getClientOriginalExtension();
            $file->storeAs('logos', $name);
            $data['logo'] = 'storage/logos/'.$name;
        }

        $company->update($data);

        // update associated user email/name if exists
        $user = User::where('company_id',$company->id)->first();
        if ($user) {
            $user->update(['name' => $company->name, 'email' => $company->email]);
        }

        if ($request->ajax()) {
            $companies = Company::orderBy('id','desc')->paginate(10);
            return response()->json([
                'status' => 'ok',
                'table' => view('companies.table', compact('companies'))->render(),
                'message' => 'Company updated',
            ]);
        }

        return redirect()->route('companies.index')->with('success','Company updated.');
    }

    public function destroy(Request $request, Company $company)
    {
        // delete logo file
        if ($company->logo) {
            $old = str_replace('storage/','public/',$company->logo);
            if (Storage::exists($old)) Storage::delete($old);
        }

        // delete company user if present
        \App\Models\User::where('company_id', $company->id)->delete();

        $company->delete();

        if ($request->ajax()) {
            $companies = Company::orderBy('id','desc')->paginate(10);
            return response()->json([
                'status' => 'ok',
                'table' => view('companies.table', compact('companies'))->render(),
                'message' => 'Company deleted',
            ]);
        }

        return redirect()->route('companies.index')->with('success','Company deleted.');
    }
}
