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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <!-- Bootstrap 5 CDN (ensures styling even if Mix assets not built) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div id="app">
        <div class="brand-banner d-none d-md-block">
            <span class="brand-gradient">FENKABLE UNIVERSITY</span>
        </div>

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
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
