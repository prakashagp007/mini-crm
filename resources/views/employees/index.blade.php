@extends('layouts.app')
<style>
    h3 {
        font-family: merienda;
        font-size: 30px;
        font-weight: bold;
    }
</style>
@section('content')
    <div class="d-flex mt-4 justify-content-between ">
        <h3>Employees</h3>
        <a href="{{ route('employees.create') }}" class="btn btn-dark ">Add Employee</a>
    </div>

    <div id="employees-table">
        @include('employees.table', ['employees' => $employees])
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $(document).on('click', '#employees-table .pagination a', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                $.get(url, {
                    _ajax: 1
                }, function(html) {
                    $('#employees-table').html(html);
                });
            });

            $(document).on('click', '.employee-delete', function(e) {
                e.preventDefault();
                if (!confirm('Delete employee?')) return;
                let url = $(this).attr('href');
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: $('meta[name=csrf-token]').attr('content')
                    },
                    success: function(res) {
                        if (res.table) $('#employees-table').html(res.table);
                        alert(res.message || 'Deleted');
                    }
                });
            });
        });
    </script>
@endpush
