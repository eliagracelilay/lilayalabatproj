@extends('layouts.admin')

@section('admin-content')
@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<style>
  .report-pill { display:inline-block; background:#b9b0ba7a; padding:.4rem .9rem; border-radius:999px; font-weight:600; color:#333; }
  .report-panel { border-radius:24px; background: rgba(255,255,255,.75); backdrop-filter: blur(4px); box-shadow: 0 10px 22px rgba(0,0,0,.12); }
  .report-panel .form-select, .report-panel .form-control { border-radius:10px; }
  .report-generate { background:#7d7da3; color:#fff; border:0; border-radius:12px; padding:.6rem 1.2rem; }
  .report-generate:hover { background:#6e6e96; color:#fff; }
</style>

<div class="mb-2">
  <span class="report-pill">⚙️ Report Settings</span>
  <div class="report-panel p-4 mt-2">
    <form method="get" class="row g-3">
      <div class="col-md-4">
        <label class="form-label">Report Type</label>
        <select name="type" class="form-select">
          <option value="students" {{ $type === 'students' ? 'selected' : '' }}>Student Report</option>
          <option value="faculties" {{ $type === 'faculties' ? 'selected' : '' }}>Faculty Report</option>
          <option value="courses" {{ $type === 'courses' ? 'selected' : '' }}>Course Report</option>
          <option value="departments" {{ $type === 'departments' ? 'selected' : '' }}>Department Report</option>
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Filter by Department</label>
        <select name="department_id" class="form-select">
          <option value="">All</option>
          @foreach($departments as $d)
            <option value="{{ $d->id }}" {{ (string)$departmentId === (string)$d->id ? 'selected' : '' }}>{{ $d->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Filter by Course</label>
        <select name="course_id" class="form-select">
          <option value="">All</option>
          @foreach($courses as $c)
            <option value="{{ $c->id }}" {{ (string)$courseId === (string)$c->id ? 'selected' : '' }}>{{ $c->title }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-12 d-flex justify-content-end">
        <button class="report-generate">Generate Document</button>
      </div>
    </form>
  </div>
</div>

@if(isset($summary) && count($summary))
  <div class="mt-3">
    <div class="small text-muted">Applied Filters</div>
    <div class="d-flex gap-2 flex-wrap">
      @foreach($summary as $k=>$v)
        <span class="badge text-bg-light">{{ $k }}: {{ $v }}</span>
      @endforeach
    </div>
  </div>
@endif

<div class="card mt-3">
  <div class="table-responsive">
    <table class="table align-middle mb-0">
      <thead>
        @if($type==='students')
        <tr><th>Student No</th><th>Name</th><th>Department</th><th>Course</th><th>Status</th></tr>
        @elseif($type==='faculties')
        <tr><th>Employee No</th><th>Name</th><th>Department</th><th>Status</th></tr>
        @elseif($type==='courses')
        <tr><th>Code</th><th>Title</th><th>Department</th><th>Status</th></tr>
        @else
        <tr><th>Code</th><th>Name</th><th>Location</th><th>Status</th></tr>
        @endif
      </thead>
      <tbody>
        @forelse($results as $row)
          @if($type==='students')
          <tr>
            <td>{{ $row->student_no }}</td>
            <td>{{ $row->last_name }}, {{ $row->first_name }}</td>
            <td>{{ optional($row->department)->name ?: '—' }}</td>
            <td>{{ optional($row->course)->title ?: '—' }}</td>
            <td>{{ $row->status }}</td>
          </tr>
          @elseif($type==='faculties')
          <tr>
            <td>{{ $row->employee_no }}</td>
            <td>{{ $row->last_name }}, {{ $row->first_name }}</td>
            <td>{{ optional($row->department)->name ?: '—' }}</td>
            <td>{{ $row->status }}</td>
          </tr>
          @elseif($type==='courses')
          <tr>
            <td>{{ $row->code }}</td>
            <td>{{ $row->title }}</td>
            <td>{{ optional($row->department)->name ?: '—' }}</td>
            <td>{{ $row->status }}</td>
          </tr>
          @else
          <tr>
            <td>{{ $row->code }}</td>
            <td>{{ $row->name }}</td>
            <td>{{ $row->location }}</td>
            <td>{{ $row->status }}</td>
          </tr>
          @endif
        @empty
          <tr><td colspan="5" class="text-center text-muted">No results</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if(method_exists($results, 'hasPages') && $results->hasPages())
    <div class="card-footer bg-white">{{ $results->links() }}</div>
  @endif
</div>
@endsection
