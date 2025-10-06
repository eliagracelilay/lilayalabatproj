@extends('layouts.admin')

@section('admin-content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Faculty</h4>
  <a href="{{ route('admin.faculties.create') }}" class="btn btn-sm btn-brand">＋ New Faculty</a>
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
          <th>Employee No</th>
          <th>Name</th>
          <th>Department</th>
          <th>Position</th>
          <th>Status</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
      @forelse($faculties as $f)
        <tr>
          <td class="fw-semibold">{{ $f->employee_no }}</td>
          <td>{{ $f->last_name }}, {{ $f->first_name }}</td>
          <td>{{ optional($f->department)->name ?: '—' }}</td>
          <td>{{ $f->position ?: '—' }}</td>
          <td><span class="badge text-bg-light">{{ $f->status }}</span></td>
          <td class="text-end">
            <a href="{{ route('admin.faculties.edit', $f) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
            <form method="post" action="{{ route('admin.faculties.destroy', $f) }}" class="d-inline" onsubmit="return confirm('Archive this faculty?')">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-outline-danger">Archive</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" class="text-center text-muted">No faculty found.</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  @if($faculties->hasPages())
  <div class="card-footer bg-white">{{ $faculties->links() }}</div>
  @endif
</div>
@endsection
