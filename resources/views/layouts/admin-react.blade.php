<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <!-- Bootstrap first (base), then compiled CSS to override -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}?v={{ file_exists(public_path('css/app.css')) ? filemtime(public_path('css/app.css')) : time() }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}?v={{ file_exists(public_path('css/admin.css')) ? filemtime(public_path('css/admin.css')) : time() }}" rel="stylesheet">
    <style>
      /* Page background like mockup */
      body{background:#f0f2f5}
      .page-actions{display:flex;gap:.6rem;justify-content:flex-end;align-items:center}
      .btn.btn-archive-green{background:#2f4938!important;color:#fff!important;border-color:#2f4938!important;border-width:0;border-radius:9999px;padding:.5rem 1.1rem;font-weight:700;box-shadow:inset 0 -2px 0 rgba(0,0,0,.15)}
      .btn.btn-add-black{background:#0a0a0a!important;color:#fff!important;border-color:#0a0a0a!important;border-width:0;border-radius:9999px;padding:.5rem 1.1rem;font-weight:700;box-shadow:inset 0 -2px 0 rgba(0,0,0,.25)}
      /* Fallback styles for add/edit forms */
      .btn.btn-back{background:#6f6a6a;color:#fff;border:0;border-radius:9999px;padding:.3rem .8rem;font-weight:600;font-size:.85rem}
      .form-actions{display:flex;gap:.75rem;justify-content:flex-end}
      .btn.btn-save{background:#6a73d8;color:#fff;border:0;border-radius:9999px;padding:.45rem 1.1rem;font-weight:600;font-size:.9rem}
      .btn.btn-cancel{background:#f1f1f1;color:#c0392b;border:1px solid rgba(224,127,122,.6);border-radius:9999px;padding:.45rem .95rem;font-weight:600;font-size:.9rem}
      /* Coral frame and inner card */
      .coral-form{position:relative;background:#e07a79;border-radius:22px;padding:1.6rem 1rem 1rem 1rem;box-shadow:0 8px 18px rgba(0,0,0,.18)}
      .coral-form .form-card{background:#ffffff;border-radius:12px;padding:.9rem;border:1px solid rgba(0,0,0,.05);margin-top:.15rem}
      /* Tighter spacing */
      .form-container .form-card .form-header{margin-bottom:.75rem;padding-bottom:.4rem}
      .form-container .form-group{margin-bottom:.6rem}
      .form-grid{gap:.75rem}
      .form-container .form-group .form-control,
      .form-container .form-group .form-select{padding:.45rem .75rem}
      .form-actions{margin-top:.75rem;padding-top:.6rem}
      /* Back pill inside coral frame */
      .back-over{position:absolute;top:8px;right:16px;z-index:2}
      /* Page title styles */
      .page-title-text{font-size:2.25rem;line-height:1.1;font-weight:700;color:#2b1717;margin:0}
      .page-subtitle-text{color:#9b9b9b;font-size:1.05rem;margin-top:.2rem}
      .page-title-icon{color:#000;margin-right:.35rem}
      .form-container .form-group .form-control,
      .form-container .form-group .form-select,
      .form-container textarea.form-control{background:#efefef;border:1px solid #e0e0e0;border-radius:12px}
      .form-container .form-group .form-control:focus,
      .form-container .form-group .form-select:focus,
      .form-container textarea.form-control:focus{background:#f6f6f6;border-color:#d0d0d0;box-shadow:none}
      /* Faculty index: remove coral ribbon and pink filter tint */
      .faculties-table .faculty-card{padding-top:0}
      .faculties-table .faculty-card::before{display:none}
      .faculty-filters .filter-input,
      .faculty-filters .filter-select{background:#fff;border:1px solid #e5e7eb}
    </style>
 </head>
<body>
    <div id="app">
        

        <main class="py-4">
            <div class="container-fluid">
                <!-- React Admin App will mount here -->
                <div id="admin-app"></div>
            </div>
        </main>
    </div>

    <!-- Pass data to JavaScript -->
    <script>
        window.adminUser = @json(auth()->user());
        window.adminStats = @json($stats ?? []);
        window.archivedProfiles = @json($archivedProfiles ?? []);
        window.archivedItems = @json($archivedItems ?? []);
        window.editData = {
            student: @json($student ?? null),
            faculty: @json($faculty ?? null),
            course: @json($course ?? null),
            department: @json($department ?? null),
            departments: @json($departments ?? []),
            courses: @json($courses ?? []),
            academicYears: @json($academicYears ?? [])
        };
    </script>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}?v={{ file_exists(public_path('js/app.js')) ? filemtime(public_path('js/app.js')) : time() }}"></script>
</body>
</html>
