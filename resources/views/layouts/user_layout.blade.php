<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management - To Do</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --app-bg: #f2f4f8;
            --panel-bg: #ffffff;
            --panel-border: #dbe2ea;
            --muted-text: #6c7a89;
            --brand: #1f3b67;
            --brand-soft: #e8eef7;
        }

        html,
        body {
            min-height: 100%;
        }

        body {
            background-color: var(--app-bg);
            color: #1f2937;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .page-title {
            color: var(--brand);
            font-weight: 700;
            letter-spacing: 0.2px;
        }

        .app-surface {
            background: var(--panel-bg);
            border: 1px solid var(--panel-border);
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(31, 59, 103, 0.06);
        }

        .form-label {
            font-weight: 600;
            color: #334155;
        }

        .form-control,
        .form-select {
            border-color: #ced6e0;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #96a9c6;
            box-shadow: 0 0 0 0.2rem rgba(31, 59, 103, 0.12);
        }

        .chip-item {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            border: 1px solid #d6dee8;
            background: #f8fafc;
            color: #334155;
            border-radius: 999px;
            padding: 0.2rem 0.65rem;
            font-size: 0.85rem;
        }

        .simple-list-item {
            border: 1px solid #dbe2ea;
            border-radius: 10px;
            background: #f8fafc;
            padding: 0.6rem 0.8rem;
        }

        .bg-brand-soft {
            background-color: var(--brand-soft);
        }

        .text-muted-soft {
            color: var(--muted-text);
        }
    </style>
</head>
<body>
    @include('shared.nav')
    <main class="py-4 flex-grow-1">
        <div class="container pb-4">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @include('shared.footer')
</body>
</html>
