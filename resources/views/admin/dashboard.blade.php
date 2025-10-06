@extends('layouts.admin')

@section('admin-content')
<div class="py-2">
    <div class="row g-3 mb-3">
        <div class="col-12 col-md-4">
            <div class="mini-card p-3 h-100">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="text-muted small">System Health</div>
                    <div>📈</div>
                </div>
                <div class="display-6 fw-semibold">99.9%</div>
                <div class="text-success small">↑ +0.1% <span class="text-muted">Uptime this month</span></div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="mini-card p-3 h-100">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="text-muted small">Active Users</div>
                    <div>👥</div>
                </div>
                <div class="display-6 fw-semibold">{{ $students + $faculties }}</div>
                <div class="text-success small">↑ +0.1% <span class="text-muted">Students + Faculty</span></div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="mini-card p-3 h-100">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="text-muted small">Calendar</div>
                    <div>🗓️</div>
                </div>
                <div class="text-muted">No upcoming events</div>
            </div>
        </div>
    </div>

    <div class="overview-card p-3">
        <div class="h6 text-muted mb-2">Academic Overview</div>
        <style>
            .overview-row a.item { color: inherit; text-decoration: none; display:flex; align-items:center; justify-content:space-between; padding: .9rem 1rem; border-radius:10px; background:#f6f6f6; margin:.5rem 0; transition: background .15s ease, transform .05s ease; }
            .overview-row a.item:hover { background:#efefef; }
            .overview-row a.item:active { transform: scale(.998); }
        </style>
        <div class="overview-row">
            <a class="item" href="{{ route('admin.students.index') }}">
                <div class="d-flex align-items-center">
                    <div class="icon-pill me-2">🎓</div>
                    <div>Students</div>
                </div>
                <div class="fw-semibold">{{ $students }}</div>
            </a>
            <a class="item" href="{{ route('admin.faculties.index') }}">
                <div class="d-flex align-items-center">
                    <div class="icon-pill me-2">🧑‍🏫</div>
                    <div>Faculty</div>
                </div>
                <div class="fw-semibold">{{ $faculties }}</div>
            </a>
            <a class="item" href="{{ route('admin.courses.index') }}">
                <div class="d-flex align-items-center">
                    <div class="icon-pill me-2">📚</div>
                    <div>Courses</div>
                </div>
                <div class="fw-semibold">{{ $courses }}</div>
            </a>
            <a class="item" href="{{ route('admin.departments.index') }}">
                <div class="d-flex align-items-center">
                    <div class="icon-pill me-2">🏢</div>
                    <div>Departments</div>
                </div>
                <div class="fw-semibold">{{ $departments }}</div>
            </a>
        </div>
    </div>
</div>
@endsection
