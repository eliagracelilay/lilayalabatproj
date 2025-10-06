@csrf
<div class="row g-3">
  <div class="col-md-4">
    <label class="form-label">Employee No</label>
    <input type="text" name="employee_no" class="form-control" value="{{ old('employee_no', $faculty->employee_no ?? '') }}" required>
    @error('employee_no')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">First Name</label>
    <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $faculty->first_name ?? '') }}" required>
    @error('first_name')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">Last Name</label>
    <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $faculty->last_name ?? '') }}" required>
    @error('last_name')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-3">
    <label class="form-label">Suffix</label>
    <input type="text" name="suffix" class="form-control" value="{{ old('suffix', $faculty->suffix ?? '') }}">
  </div>
  <div class="col-md-3">
    <label class="form-label">Sex</label>
    <select name="sex" class="form-select">
      <option value="">—</option>
      @foreach(['Male','Female','Other'] as $sx)
        <option value="{{ $sx }}" {{ old('sex', $faculty->sex ?? '') == $sx ? 'selected' : '' }}>{{ $sx }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-6">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $faculty->email ?? '') }}">
    @error('email')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-6">
    <label class="form-label">Contact Number</label>
    <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number', $faculty->contact_number ?? '') }}">
    @error('contact_number')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="col-12">
    <label class="form-label">Address</label>
    <textarea name="address" class="form-control" rows="2">{{ old('address', $faculty->address ?? '') }}</textarea>
    @error('address')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">Title</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $faculty->title ?? '') }}">
  </div>
  <div class="col-md-4">
    <label class="form-label">Position</label>
    <input type="text" name="position" class="form-control" value="{{ old('position', $faculty->position ?? '') }}">
  </div>
  <div class="col-md-4">
    <label class="form-label">Department</label>
    <select name="department_id" class="form-select">
      <option value="">—</option>
      @foreach($departments as $id=>$name)
        <option value="{{ $id }}" {{ old('department_id', $faculty->department_id ?? '') == $id ? 'selected' : '' }}>{{ $name }}</option>
      @endforeach
    </select>
    @error('department_id')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
      @foreach(['active','inactive'] as $st)
        <option value="{{ $st }}" {{ old('status', $faculty->status ?? 'active') == $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
      @endforeach
    </select>
  </div>
</div>
<div class="mt-3 d-flex gap-2">
  <button class="btn btn-brand">Save</button>
  <a href="{{ route('admin.faculties.index') }}" class="btn btn-outline-secondary">Cancel</a>
</div>
