@extends('layouts.app')

@section('content')
    <style>
        body {
            min-height: 100vh;
        }

        .edit-wrapper {
            max-width: 700px;
            margin: 40px auto;
        }

        .edit-card {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            padding: 40px 35px;
            transition: all 0.3s ease;
        }

        .edit-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.25);
        }

        .edit-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .edit-header h4 {
            font-weight: 700;
            color: #222;
            letter-spacing: 0.5px;
            font-family: "Merienda", cursive;
        }

        label {
            font-weight: 600;
            font-size: 15px;
            color: #374151;
            font-family: "Emblema One", cursive;
        }

        .form-control {
            border-radius: 12px;
            border: 1px solid #ddd;
            padding: 10px 14px;
            transition: all 0.3s;
        }

        label {
            font-family: Overlock;
        }


        .form-control:focus {
            border-color: #f97316;
            box-shadow: 0 0 0 0.15rem rgba(249, 115, 22, 0.25);
        }

        .btn-update {
            background: linear-gradient(135deg, #ff5e62, #f093fb);
            border: none;
            color: #fff;
            border-radius: 4px;
            font-weight: 600;
            transition: 0.3s;
            font-family: Overlock;
        }

        .btn-update:hover {
            background: linear-gradient(135deg, #ff416c, #ff4b2b);
        }

        .btn-secondary {
            border-radius: 12px;
        }

        .logo-preview {
            max-width: 120px;
            border-radius: 12px;
            border: 2px solid #e5e7eb;
            padding: 4px;
            background: #fff;
        }

        @media (max-width: 576px) {
            .edit-card {
                padding: 25px 20px;
            }
        }
    </style>

    <div class="container edit-wrapper">
        <div class="edit-card">
            <div class="edit-header">
                <h4>✏️ Edit Company Details</h4>
            </div>

            <form id="company-form" method="POST" action="{{ route('companies.update', $company) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Name</label>
                    <input name="name" class="form-control" value="{{ $company->name }}" required>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input name="email" type="email" class="form-control" value="{{ $company->email }}">
                </div>

                <div class="mb-3">
                    <label>Website</label>
                    <input name="website" type="url" class="form-control" value="{{ $company->website }}">
                </div>

                <div class="mb-3">
                    <label>Logo (jpg, png, min 100x100)</label>
                    <input type="file" name="logo" accept=".jpg,.png" class="form-control">
                </div>

                @if ($company->logo)
                    <div class="mb-3 text-center">
                        <img src="{{ asset($company->logo) }}" class="logo-preview" alt="Logo Preview">
                    </div>
                @endif

                <div class="d-flex justify-content-between align-items-center">
                    <button class="btn btn-update btn-sm">Update</button>
                    <a href="{{ route('companies.index') }}" class="btn btn-dark btn-sm">Back</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(function() {
            $('#company-form').on('submit', function(e) {
                e.preventDefault();
                var form = new FormData(this);
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: form,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                    },
                    success: function(res) {
                        if (res.table) {
                            window.location = "{{ route('companies.index') }}";
                        } else {
                            alert('✅ Company Updated Successfully!');
                            window.location = "{{ route('companies.index') }}";
                        }
                    },
                    error: function(xhr) {
                        alert('❌ Failed: ' + xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
