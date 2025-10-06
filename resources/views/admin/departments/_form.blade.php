@csrf
<div class="row g-3">
  <div class="col-md-3">
    <label class="form-label">Code</label>
    <input type="text" name="code" class="form-control" value="{{ old('code', $department->code ?? '') }}" required>
    @error('code')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-6">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $department->name ?? '') }}" required>
    @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-6">
    <label class="form-label">Location</label>
    <input type="text" name="location" class="form-control" value="{{ old('location', $department->location ?? '') }}">
  </div>
  <div class="col-md-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
      @foreach(['active','inactive'] as $st)
        <option value="{{ $st }}" @selected(old('status', $department->status ?? 'active')==$st)>{{ ucfirst($st) }}</option>
      @endforeach
    </select>
  </div>
</div>
<div class="mt-3 d-flex gap-2">
  <button class="btn btn-brand">Save</button>
  <a href="{{ route('admin.departments.index') }}" class="btn btn-outline-secondary">Cancel</a>
</div>
