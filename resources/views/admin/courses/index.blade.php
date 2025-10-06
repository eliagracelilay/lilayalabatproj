@extends('layouts.admin')

@section('admin-content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Courses</h4>
  <a href="{{ route('admin.courses.create') }}" class="btn btn-sm btn-brand">＋ New Course</a>
</div>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="get" class="row g-2 mb-3">
  <div class="col-auto">
    <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Search by Code/Title">
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
          <th>Code</th>
          <th>Title</th>
          <th>Department</th>
          <th>Units</th>
          <th>Status</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
      @forelse($courses as $c)
        <tr>
          <td class="fw-semibold">{{ $c->code }}</td>
          <td>{{ $c->title }}</td>
          <td>{{ optional($c->department)->name ?: '—' }}</td>
          <td>{{ $c->units }}</td>
          <td><span class="badge text-bg-light">{{ $c->status }}</span></td>
          <td class="text-end">
            <a href="{{ route('admin.courses.edit', $c) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
            <form method="post" action="{{ route('admin.courses.destroy', $c) }}" class="d-inline" onsubmit="return confirm('Archive this course?')">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-outline-danger">Archive</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" class="text-center text-muted">No courses found.</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  @if($courses->hasPages())
  <div class="card-footer bg-white">{{ $courses->links() }}</div>
  @endif
</div>
@endsection
