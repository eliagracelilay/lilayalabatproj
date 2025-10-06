@extends('layouts.admin')

@section('admin-content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Students</h4>
  <a href="{{ route('admin.students.create') }}" class="btn btn-sm btn-brand">＋ New Student</a>
</div>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="get" class="row g-2 mb-3">
  <div class="col-auto">
    <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Search by ID/Name">
  </div>
  <div class="col-auto">
    <button class="btn btn-outline-secondary">Search</button>
  </div>
</form>

<div class="card shadow-sm">
  <div class="table-responsive">
    <table class="table align-middle mb-0">
      <thead>
        <tr>
          <th>Student No</th>
          <th>Name</th>
          <th>Department</th>
          <th>Year</th>
          <th>Status</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
      @forelse($students as $s)
        <tr>
          <td class="fw-semibold">{{ $s->student_no }}</td>
          <td>{{ $s->last_name }}, {{ $s->first_name }}</td>
          <td>{{ optional($s->department)->name ?: '—' }}</td>
          <td>{{ $s->year_level ?: '—' }}</td>
          <td><span class="badge text-bg-light">{{ $s->status }}</span></td>
          <td class="text-end">
            <a href="{{ route('admin.students.edit', $s) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
            <form method="post" action="{{ route('admin.students.destroy', $s) }}" class="d-inline" onsubmit="return confirm('Archive this student?')">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-outline-danger">Archive</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" class="text-center text-muted">No students found.</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  @if($students->hasPages())
  <div class="card-footer bg-white">{{ $students->links() }}</div>
  @endif
</div>
@endsection
