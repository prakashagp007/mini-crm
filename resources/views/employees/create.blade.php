@extends('layouts.app')

@section('content')
<style>
  .employee-form-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 35px 30px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    max-width: 700px;
    margin: 40px auto;
    transition: all 0.3s ease;
  }

  .employee-form-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
  }

  .employee-form-card h4 {
    text-align: center;
    font-weight: 700;
    margin-bottom: 25px;
    color: #1e293b;
  }

  label {
    font-weight: 600;
    color: #374151;
  }

  .form-control {
    border-radius: 10px;
    padding: 10px 14px;
    border: 1px solid #cbd5e1;
    transition: 0.2s ease;
  }

  .form-control:focus {
    border-color: #7c3aed;
    box-shadow: 0 0 0 0.15rem rgba(124, 58, 237, 0.25);
  }

  .btn-save {
    background: linear-gradient(135deg, #ff9966, #ff5e62);
    border: none;
    color: white;
    font-weight: 600;
    padding: 10px 18px;
    border-radius: 10px;
    width: 100%;
    transition: all 0.3s ease;
  }

  .btn-save:hover {
    background: linear-gradient(135deg, #ff5e62, #ff9966);
    transform: translateY(-2px);
  }

  .btn-back {
    width: 100%;
    border-radius: 10px;
    font-weight: 600;
  }

  @media (max-width: 576px) {
    .employee-form-card {
      padding: 25px 20px;
      margin-top: 20px;
    }
  }
</style>

<div class="employee-form-card">
  <h4>➕ Add New Employee</h4>
  <form id="employee-form" method="POST" action="{{ route('employees.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="row">
      <div class="col-md-6 mb-3">
        <label>First Name</label>
        <input name="first_name" class="form-control" required>
      </div>
      <div class="col-md-6 mb-3">
        <label>Last Name</label>
        <input name="last_name" class="form-control" required>
      </div>
    </div>

    <div class="mb-3">
      <label>Company</label>
      <select name="company_id" class="form-control">
        <option value="">-- Select Company --</option>
        @foreach($companies as $c)
          <option value="{{ $c->id }}">{{ $c->name }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label>Email</label>
      <input name="email" type="email" class="form-control" placeholder="example@domain.com">
    </div>

    <div class="mb-3">
      <label>Phone</label>
      <input name="phone" class="form-control" placeholder="+91 9876543210">
    </div>

    <div class="mb-4">
      <label>Document (PDF only)</label>
      <input type="file" name="document" accept=".pdf" class="form-control">
    </div>

    <div class="row">
      <div class="col-md-6 mb-2">
        <button class="btn btn-save">Save Employee</button>
      </div>
      <div class="col-md-6 mb-2">
        <a href="{{ route('employees.index') }}" class="btn btn-secondary btn-back">Back</a>
      </div>
    </div>
  </form>
</div>

<script>
$(function(){
  $('#employee-form').on('submit', function(e){
    e.preventDefault();
    var form = new FormData(this);
    $.ajax({
      url: $(this).attr('action'),
      type: 'POST',
      data: form,
      processData: false,
      contentType: false,
      headers: {'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')},
      success: function(res){
        alert('✅ Employee Added Successfully');
        window.location = "{{ route('employees.index') }}";
      },
      error: function(xhr){
        alert('❌ Failed: ' + xhr.responseText);
      }
    });
  });
});
</script>
@endsection
