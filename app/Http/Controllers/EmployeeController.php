<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use App\Models\Company;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $employees = Employee::with('company')->orderBy('id','desc')->paginate(10);
        if ($request->ajax()) {
            return view('employees.table', compact('employees'))->render();
        }
        $companies = Company::all();
        return view('employees.index', compact('employees','companies'));
    }

    public function create()
    {
        $companies = Company::all();
        return view('employees.create', compact('companies'));
    }

    public function store(StoreEmployeeRequest $request)
    {
        $data = $request->only(['first_name','last_name','company_id','email','phone']);

        // optional document
        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $name = 'employee_doc_'.time().'_'.Str::random(6).'.'.$file->getClientOriginalExtension();
            $file->storeAs('documents', $name);
            $data['document_path'] = 'storage/documents/'.$name;
        }

        $employee = Employee::create($data);

        // auto-create user record for employee to login
        if (!empty($employee->email)) {
            User::create([
                'name' => $employee->first_name . ' ' . $employee->last_name,
                'email' => $employee->email,
                'password' => Hash::make('password'),
                'role' => 'employee',
                'employee_id' => $employee->id,
                'company_id' => $employee->company_id,
            ]);
        }

        if ($request->ajax()) {
            $employees = Employee::with('company')->orderBy('id','desc')->paginate(10);
            return response()->json([
                'status'=>'ok',
                'table' => view('employees.table', compact('employees'))->render(),
                'message'=>'Employee created'
            ]);
        }

        return redirect()->route('employees.index')->with('success','Employee created.');
    }

    public function edit(Employee $employee)
    {
        $companies = Company::all();
        return view('employees.edit', compact('employee','companies'));
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $data = $request->only(['first_name','last_name','company_id','email','phone']);
        if ($request->hasFile('document')) {
            if (isset($employee->document_path)) {
                $old = str_replace('storage/','public/',$employee->document_path);
                if (Storage::exists($old)) Storage::delete($old);
            }
            $file = $request->file('document');
            $name = 'employee_doc_'.time().'_'.Str::random(6).'.'.$file->getClientOriginalExtension();
            $file->storeAs('documents', $name);
            $data['document_path'] = 'storage/documents/'.$name;
        }

        $employee->update($data);

        // update user if exists
        $user = User::where('employee_id', $employee->id)->first();
        if ($user) {
            $user->update(['name' => $employee->first_name.' '.$employee->last_name, 'email' => $employee->email]);
        }

        if ($request->ajax()) {
            $employees = Employee::with('company')->orderBy('id','desc')->paginate(10);
            return response()->json([
                'status'=>'ok',
                'table' => view('employees.table', compact('employees'))->render(),
                'message'=>'Employee updated'
            ]);
        }

        return redirect()->route('employees.index')->with('success','Employee updated.');
    }

    public function destroy(Request $request, Employee $employee)
    {
        // delete document if exists
        if (isset($employee->document_path)) {
            $old = str_replace('storage/','public/',$employee->document_path);
            if (Storage::exists($old)) Storage::delete($old);
        }

        // delete user
        \App\Models\User::where('employee_id', $employee->id)->delete();
        $employee->delete();

        if ($request->ajax()) {
            $employees = Employee::with('company')->orderBy('id','desc')->paginate(10);
            return response()->json([
                'status'=>'ok',
                'table' => view('employees.table', compact('employees'))->render(),
                'message'=>'Employee deleted'
            ]);
        }

        return redirect()->route('employees.index')->with('success','Employee deleted.');
    }
}
