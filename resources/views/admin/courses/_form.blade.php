@csrf
<div class="row g-3">
  <div class="col-md-3">
    <label class="form-label">Code</label>
    <input type="text" name="code" class="form-control" value="{{ old('code', $course->code ?? '') }}" required>
    @error('code')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-5">
    <label class="form-label">Title</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $course->title ?? '') }}" required>
    @error('title')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-2">
    <label class="form-label">Units</label>
    <input type="number" min="1" max="10" name="units" class="form-control" value="{{ old('units', $course->units ?? 3) }}">
    @error('units')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">Department</label>
    <select name="department_id" class="form-select" required>
      <option value="">— Select —</option>
      @foreach($departments as $id=>$name)
        <option value="{{ $id }}" {{ old('department_id', $course->department_id ?? '') == $id ? 'selected' : '' }}>{{ $name }}</option>
      @endforeach
    </select>
    @error('department_id')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
      @foreach(['active','inactive'] as $st)
        <option value="{{ $st }}" {{ old('status', $course->status ?? 'active') == $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
      @endforeach
    </select>
  </div>
</div>
<div class="mt-3 d-flex gap-2">
  <button class="btn btn-brand">Save</button>
  <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">Cancel</a>
</div>
