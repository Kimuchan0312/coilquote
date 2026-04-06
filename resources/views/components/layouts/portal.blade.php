<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'CoilQuote Portal' }}</title>
    @livewireStyles
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: system-ui, -apple-system, sans-serif; background: #f1f5f9; color: #1e293b; font-size: 14px; }
        a { color: #2563eb; text-decoration: none; }
        a:hover { text-decoration: underline; }

        /* Nav */
        .nav { background: #1e293b; padding: 0 24px; display: flex; align-items: center; justify-content: space-between; height: 52px; }
        .nav-brand { color: #fff; font-size: 16px; font-weight: 700; letter-spacing: -.3px; }
        .nav-right { display: flex; align-items: center; gap: 20px; color: #94a3b8; font-size: 13px; }
        .nav-right a { color: #94a3b8; }
        .nav-right a:hover { color: #fff; text-decoration: none; }

        /* Main */
        .container { max-width: 960px; margin: 0 auto; padding: 28px 20px; }

        /* Cards */
        .card { background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 24px; margin-bottom: 16px; }
        .card-title { font-size: 16px; font-weight: 600; margin-bottom: 16px; }

        /* Form */
        .form-group { margin-bottom: 14px; }
        label { display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px; }
        input[type=text], input[type=email], input[type=password], input[type=number], select, textarea {
            width: 100%; border: 1px solid #cbd5e1; border-radius: 6px; padding: 8px 12px;
            font-size: 13px; background: #fff; color: #1e293b;
        }
        input:focus, select:focus, textarea:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 3px #dbeafe; }
        textarea { resize: vertical; }
        .input-suffix { position: relative; }
        .input-suffix input { padding-right: 40px; }
        .input-suffix span { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 12px; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px; }
        .col-full { grid-column: 1 / -1; }

        /* Buttons */
        .btn { display: inline-block; padding: 9px 18px; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; border: none; }
        .btn-primary { background: #2563eb; color: #fff; }
        .btn-primary:hover { background: #1d4ed8; }
        .btn-success { background: #16a34a; color: #fff; }
        .btn-success:hover { background: #15803d; }
        .btn-outline { background: #fff; color: #374151; border: 1px solid #d1d5db; }
        .btn-outline:hover { background: #f9fafb; }
        .btn-full { width: 100%; text-align: center; }
        .btn:disabled { opacity: .6; cursor: not-allowed; }

        /* Badges */
        .badge { display: inline-block; padding: 2px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .03em; }
        .badge-new { background: #dbeafe; color: #1d4ed8; }
        .badge-reviewing { background: #fef3c7; color: #92400e; }
        .badge-quoted { background: #e0e7ff; color: #3730a3; }
        .badge-approved { background: #dcfce7; color: #166534; }
        .badge-cancelled { background: #fee2e2; color: #991b1b; }

        /* Table */
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 8px 12px; border-bottom: 2px solid #e2e8f0; font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: .05em; }
        td { padding: 11px 12px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f8fafc; }

        /* Alerts */
        .alert { padding: 10px 14px; border-radius: 6px; font-size: 13px; margin-bottom: 14px; }
        .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .alert-success { background: #dcfce7; color: #166534; border: 1px solid #86efac; }

        /* Spec grid */
        .spec-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 16px; }
        .spec-item { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 12px; }
        .spec-key { font-size: 11px; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; margin-bottom: 2px; }
        .spec-val { font-size: 14px; font-weight: 700; }

        /* Price table */
        .price-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f1f5f9; font-size: 13px; }
        .price-total { display: flex; justify-content: space-between; padding: 12px 0 0; font-size: 16px; font-weight: 700; }

        /* Page header */
        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
        .page-title { font-size: 20px; font-weight: 700; }

        /* Empty state */
        .empty { text-align: center; padding: 48px 24px; color: #94a3b8; }
        .empty p { margin-bottom: 16px; }

        /* Checkbox list */
        .checkbox-list { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 4px; }
        .checkbox-item { display: flex; align-items: center; gap: 6px; font-size: 13px; cursor: pointer; }
        .checkbox-item input { width: auto; }
    </style>
</head>
<body>
    <nav class="nav">
        <span class="nav-brand">CoilQuote</span>
        <div class="nav-right">
            @auth
                <span>{{ auth()->user()->company_name ?? auth()->user()->name }}</span>
                <form method="POST" action="/portal/logout" style="display:inline;">
                    @csrf
                    <button type="submit" style="background:none;border:none;color:#94a3b8;cursor:pointer;font-size:13px;">Logout</button>
                </form>
            @endauth
        </div>
    </nav>
    <div class="container">
        {{ $slot }}
    </div>
    @livewireScripts
</body>
</html>
