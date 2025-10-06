@extends('layouts.admin')

@section('admin-content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Departments</h4>
  <a href="{{ route('admin.departments.create') }}" class="btn btn-sm btn-brand">＋ New Department</a>
</div>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="get" class="row g-2 mb-3">
  <div class="col-auto">
    <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Search by Code/Name">
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
          <th>Name</th>
          <th>Location</th>
          <th>Status</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
      @forelse($departments as $d)
        <tr>
          <td class="fw-semibold">{{ $d->code }}</td>
          <td>{{ $d->name }}</td>
          <td>{{ $d->location ?: '—' }}</td>
          <td><span class="badge text-bg-light">{{ $d->status }}</span></td>
          <td class="text-end">
            <a href="{{ route('admin.departments.edit', $d) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
            <form method="post" action="{{ route('admin.departments.destroy', $d) }}" class="d-inline" onsubmit="return confirm('Archive this department?')">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-outline-danger">Archive</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="5" class="text-center text-muted">No departments found.</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  @if($departments->hasPages())
  <div class="card-footer bg-white">{{ $departments->links() }}</div>
  @endif
</div>
@endsection
