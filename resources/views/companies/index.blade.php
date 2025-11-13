@extends('layouts.app')

<style>
    h3 {
        font-family: merienda;
        font-size: 30px;
        font-weight: bold;
    }
</style>

@section('content')
    <div class="d-flex justify-content-between mb-2 mt-4">
        <h3>Companies</h3>
        <a href="{{ route('companies.create') }}" class="btn btn-dark">Add Company</a>
    </div>

    <div id="companies-table">
        @include('companies.table', ['companies' => $companies])
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            // handle pagination & links via AJAX (delegated)
            $(document).on('click', '#companies-table .pagination a', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                loadCompanies(url);
            });

            function loadCompanies(url) {
                $.get(url, {
                    _ajax: 1
                }, function(html) {
                    $('#companies-table').html(html);
                });
            }

            // optional: use AJAX for delete
            $(document).on('click', '.company-delete', function(e) {
                e.preventDefault();
                if (!confirm('Delete company?')) return;
                let url = $(this).attr('href');
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: $('meta[name=csrf-token]').attr('content')
                    },
                    success: function(res) {
                        if (res.table) $('#companies-table').html(res.table);
                        alert(res.message || 'Deleted');
                    }
                });
            });
        });
    </script>
@endpush
