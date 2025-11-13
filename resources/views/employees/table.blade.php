<style>
    .employee-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .employee-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        position: relative;
    }

    .employee-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
    }

    .employee-header {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .employee-avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, #00b09b, #96c93d);
        color: #fff;
        font-size: 22px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
    }

    .employee-name {
        font-weight: 700;
        font-size: 1.1rem;
        color: #1f2937;
    }

    .employee-company {
        font-size: 0.9rem;
        color: #6b7280;
    }

    .employee-info {
        font-size: 0.9rem;
        color: #374151;
        margin: 6px 0;
    }

    .employee-actions {
        display: flex;
        justify-content: end;
        column-gap: 10px;
        margin-top: 12px;
    }

    .employee-actions .btn {
        font-size: 0.85rem;
    }

    .pagination {
        margin-top: 30px;
        justify-content: center;
    }

    @media (max-width: 576px) {
        .employee-card {
            padding: 16px;
        }
    }
</style>

<div class="employee-grid">
    @foreach ($employees as $e)
        <div class="employee-card">
            <div class="employee-header">
                <div class="employee-avatar">
                    {{ strtoupper(substr($e->first_name, 0, 1)) }}
                </div>
                <div>
                    <div class="employee-name">{{ $e->first_name }} {{ $e->last_name }}</div>
                    <div class="employee-company">{{ $e->company?->name ?? '—' }}</div>
                </div>
            </div>
            <div class="employee-info"><strong>Email:</strong> {{ $e->email ?? 'N/A' }}</div>
            <div class="employee-info"><strong>Phone:</strong> {{ $e->phone ?? 'N/A' }}</div>

            <div class="employee-actions">
                <a href="{{ route('employees.edit', $e) }}" class="btn btn-sm btn-primary"><i
                        class="fa-solid fa-pen-to-square"></i></a>
                <a href="{{ route('employees.destroy', $e) }}" class="btn btn-sm btn-danger employee-delete"><i
                        class="fa-solid fa-trash"></i></a>
            </div>
        </div>
    @endforeach
</div>

<div>
    {{ $employees->links() }}
</div>

<script>
    $(document).on('click', '.employee-delete', function(e) {
        e.preventDefault();
        if (confirm('Are you sure you want to delete this employee?')) {
            $.ajax({
                url: $(this).attr('href'),
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function() {
                    location.reload();
                },
                error: function() {
                    alert('❌ Delete failed');
                }
            });
        }
    });
</script>
