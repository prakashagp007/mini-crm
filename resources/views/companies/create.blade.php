@extends('layouts.app')

@section('content')
<style>
  .add-company-container {
    max-width: 650px;
    margin: 50px auto;
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 6px 24px rgba(0, 0, 0, 0.1);
    padding: 40px 35px;
  }

  .add-company-container h4 {
    font-weight: 700;
    color: #1f2937;
    text-align: center;
    margin-bottom: 25px;
    font-family: "Merienda", cursive;
  }

  label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 6px;
    display: inline-block;
  }

  .form-control {
    border-radius: 10px;
    border: 1px solid #d1d5db;
    padding: 10px 14px;
    transition: all 0.3s;
    background-color: #f9fafb;
  }

  .form-control:focus {
    background-color: #fff;
    border-color: #3b82f6;
    box-shadow: 0 0 0 0.15rem rgba(59, 130, 246, 0.25);
  }

  .btn-primary {
    background: linear-gradient(135deg, #00b09b, #96c93d);
    border: none;
    color: #fff;
    font-weight: 600;
    transition: 0.3s ease;
  }

  .btn-primary:hover {
    background: linear-gradient(135deg, #00a389, #89b92e);
  }

  .btn-secondary {
    border-radius: 10px;
    /* padding: 10px 20px; */
  }

  .form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
  }

  @media (max-width: 576px) {
    .add-company-container {
      padding: 25px 20px;
    }
    .form-actions {
      flex-direction: column;
      gap: 10px;
    }
  }
</style>

<div class="add-company-container">
  <h4>➕ Add New Company</h4>
  <form id="company-form" method="POST" action="{{ route('companies.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
      <label>Name</label>
      <input name="name" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Email</label>
      <input name="email" class="form-control" type="email">
    </div>

    <div class="mb-3">
      <label>Website</label>
      <input name="website" class="form-control">
    </div>

    <div class="mb-3">
      <label>Logo (jpg, png, min 100x100)</label>
      <input type="file" name="logo" accept=".jpg,.png" class="form-control">
    </div>

    <div class="form-actions">
      <button class="btn btn-primary btn-sm">Save</button>
      <a href="{{ route('companies.index') }}" class="btn btn-dark btn-sm">Back</a>
    </div>
  </form>
</div>

<script>
$(function(){
  $('#company-form').on('submit', function(e){
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
        alert('✅ Company Created Successfully!');
        window.location = "{{ route('companies.index') }}";
      },
      error: function(xhr){
        alert('❌ Failed: '+xhr.responseText);
      }
    });
  });
});
</script>
@endsection
