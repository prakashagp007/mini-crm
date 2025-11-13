@extends('layouts.app')

@section('content')
<style>
  .employee-edit-card {
    background: #fff;
    border-radius: 20px;
    padding: 35px 30px;
    max-width: 700px;
    margin: 40px auto;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
  }

  .employee-edit-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
  }

  .employee-edit-card h2 {
    text-align: center;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 25px;
  }

  label {
    font-weight: 600;
    color: #374151;
  }

  .form-control, .form-select {
    border-radius: 10px;
    padding: 10px 14px;
    border: 1px solid #cbd5e1;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
  }

  .form-control:focus, .form-select:focus {
    border-color: #9333ea;
    box-shadow: 0 0 0 0.15rem rgba(147, 51, 234, 0.25);
  }

  .btn-update {
    background: linear-gradient(135deg, #00b09b, #96c93d);
    border: none;
    color: white;
    font-weight: 600;
    padding: 10px 18px;
    border-radius: 10px;
    width: 100%;
    transition: 0.3s ease;
  }

  .btn-update:hover {
    background: linear-gradient(135deg, #11998e, #38ef7d);
    transform: translateY(-2px);
  }

  .btn-cancel {
    width: 100%;
    border-radius: 10px;
    font-weight: 600;
  }

  .alert-danger {
    border-radius: 10px;
    background: #fee2e2;
    border: none;
    color: #991b1b;
  }

  @media (max-width: 576px) {
    .employee-edit-card {
      padding: 25px 20px;
      margin-top: 20px;
    }
  }
</style>

<div class="employee-edit-card">
  <h2>✏️ Edit Employee</h2>

  {{-- Validation Errors --}}
  @if ($errors->any())
    <div class="alert alert-danger">
      <strong>⚠️ Please correct the errors below:</strong>
      <ul class="mt-2 mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('employees.update', $employee->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">
      <div class="col-md-6 mb-3">
        <label>First Name</label>
        <input type="text" name="first_name" class="form-control"
               value="{{ old('first_name', $employee->first_name) }}" required>
      </div>
      <div class="col-md-6 mb-3">
        <label>Last Name</label>
        <input type="text" name="last_name" class="form-control"
               value="{{ old('last_name', $employee->last_name) }}" required>
      </div>
    </div>

    <div class="mb-3">
      <label>Company</label>
      <select name="company_id" class="form-select" required>
        <option value="">-- Select Company --</option>
        @foreach ($companies as $company)
          <option value="{{ $company->id }}"
            {{ $company->id == old('company_id', $employee->company_id) ? 'selected' : '' }}>
            {{ $company->name }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control"
             value="{{ old('email', $employee->email) }}" required>
    </div>

    <div class="mb-4">
      <label>Phone</label>
      <input type="text" name="phone" class="form-control"
             value="{{ old('phone', $employee->phone) }}" required>
    </div>

    <div class="row">
      <div class="col-md-6 mb-2">
        <button type="submit" class="btn btn-update">Update Employee</button>
      </div>
      <div class="col-md-6 mb-2">
        <a href="{{ route('employees.index') }}" class="btn btn-secondary btn-cancel">Cancel</a>
      </div>
    </div>
  </form>
</div>
@endsection
