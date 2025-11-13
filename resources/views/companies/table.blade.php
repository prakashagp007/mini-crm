<style>
    body {
        background: #f9fafb;
    }

    .company-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        padding: 20px;
        margin-bottom: 20px;
        transition: 0.3s ease;
    }

    .company-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.12);
    }

    .company-logo {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        object-fit: cover;
        border: 1px solid #e5e7eb;
    }

    .company-info h5 {
        font-weight: 700;
        color: #111827;
    }

    .company-info p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }

    .action-buttons .btn {
        border-radius: 8px;
        font-size: 14px;
        padding: 6px 12px;
    }

    .btn-edit {
        background: linear-gradient(135deg, #00c9a7, #8b5cf6);
        color: #fff;
        border: none;
    }

    .btn-edit:hover {
        background: linear-gradient(135deg, #00b89c, #7c3aed);
    }

    .btn-delete {
        background: linear-gradient(135deg, #ff5e62, #f093fb);
        color: #fff;
        border: none;
    }

    .btn-delete:hover {
        background: linear-gradient(135deg, #ff3d3d, #ec4899);
    }

    .pagination {
        justify-content: center;
        margin-top: 25px;
    }

    @media (max-width: 768px) {
        .company-card {
            text-align: center;
        }

        .company-card .d-flex {
            flex-direction: column;
            align-items: center;
        }

        .company-card .action-buttons {
            margin-top: 10px;
        }
    }
</style>

<div class="container py-4">
    <div class="row">
        @foreach ($companies as $c)
            <div class="col-md-6 col-lg-4">
                <div class="company-card">
                    <div class="d-flex align-items-center">
                        @if ($c->logo)
                            <img src="{{ asset($c->logo) }}" class="company-logo me-3" alt="logo">
                        @else
                            <div
                                class="company-logo d-flex align-items-center justify-content-center bg-light text-muted">
                                <i class="bi bi-building" style="font-size: 28px;"></i>
                            </div>
                        @endif

                        <div class="company-info">
                            <h5>{{ $c->name }}</h5>
                            <p>{{ $c->email }}</p>
                            <p><a href="{{ $c->website }}" target="_blank">{{ $c->website }}</a></p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-3 action-buttons">
                        <a href="{{ route('companies.edit', $c) }}" class="btn btn-sm btn-edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <a href="{{ route('companies.destroy', $c) }}" class="btn btn-sm btn-delete company-delete">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div>{{ $companies->links() }}</div>
</div>
