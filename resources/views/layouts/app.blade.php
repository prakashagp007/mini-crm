<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Mini-CRM</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/favicon.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Aclonica&family=Comfortaa:wght@300..700&family=Emblema+One&family=IM+Fell+Great+Primer+SC&family=Keania+One&family=Lemonada:wght@300..700&family=Lobster+Two:ital,wght@0,400;0,700;1,400;1,700&family=Merienda:wght@300..900&family=Overlock+SC&family=Redressed&family=Uncial+Antiqua&family=Wallpoet&family=Yatra+One&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <meta name="csrf-token" content="{{ csrf_token() }}">


</head>
<style>
    nav {
        background: linear-gradient(135deg, #7b4397, #dc2430);
        align-items: center;
    }

    .navbar-brand {
        font-family: Aclonica;
        color: white;
        font-size: 25px;
    }

    .nav-item a {
        font-family: Redressed;
        font-size: 20px;
    }

    .comp {
        color: white;
    }

    svg {
        width: 20px;
    }

    .pagination .page-link {
        border-radius: 8px;
        margin: 0 3px;
        color: #4f46e5;
    }

    .pagination .page-item.active .page-link {
        background-color: #4f46e5;
        border-color: #4f46e5;
        color: #fff;
    }

    .pagination .page-link:hover {
        background-color: #6366f1;
        color: #fff;
    }
</style>

<body>
    <nav class="navbar navbar-expand-lg  mb-3">
        <div class="container">
            <a class="navbar-brand" href="{{ route('companies.index') }}">Mini CRM</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item comp"><a class="nav-link text-light"
                                href="{{ route('companies.index') }}">Companies</a>
                        </li>
                        <li class="nav-item comp"><a class="nav-link text-light"
                                href="{{ route('employees.index') }}">Employees</a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="btn btn-light" type="submit">Logout</button>
                            </form>
                        </li>
                    @endauth
                    @guest
                        <li class="nav-item"><a class="btn btn-light" href="{{ route('login') }}">Login</a></li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @yield('content')
    </div>

    @stack('scripts')
</body>

</html>
