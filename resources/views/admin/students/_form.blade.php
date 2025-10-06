@csrf
<div class="row g-3">
  <div class="col-md-4">
    <label class="form-label">Student No</label>
    <input type="text" name="student_no" class="form-control" value="{{ old('student_no', $student->student_no ?? '') }}" required>
    @error('student_no')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">First Name</label>
    <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $student->first_name ?? '') }}" required>
    @error('first_name')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">Last Name</label>
    <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $student->last_name ?? '') }}" required>
    @error('last_name')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-3">
    <label class="form-label">Suffix</label>
    <input type="text" name="suffix" class="form-control" value="{{ old('suffix', $student->suffix ?? '') }}">
  </div>
  <div class="col-md-3">
    <label class="form-label">Sex</label>
    <select name="sex" class="form-select">
      <option value="">—</option>
      @foreach(['Male','Female','Other'] as $sx)
        <option value="{{ $sx }}" {{ old('sex', $student->sex ?? '') == $sx ? 'selected' : '' }}>{{ $sx }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-4">
    <label class="form-label">Birthdate</label>
    <input type="date" name="birthdate" class="form-control" value="{{ old('birthdate', isset($student->birthdate)?$student->birthdate->format('Y-m-d'):null) }}">
    @error('birthdate')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-6">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $student->email ?? '') }}">
    @error('email')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-6">
    <label class="form-label">Contact Number</label>
    <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number', $student->contact_number ?? '') }}">
    @error('contact_number')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="col-12">
    <label class="form-label">Address</label>
    <textarea name="address" class="form-control" rows="2">{{ old('address', $student->address ?? '') }}</textarea>
    @error('address')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">Department</label>
    <select name="department_id" class="form-select">
      <option value="">—</option>
      @foreach($departments as $id=>$name)
        <option value="{{ $id }}" {{ old('department_id', $student->department_id ?? '') == $id ? 'selected' : '' }}>{{ $name }}</option>
      @endforeach
    </select>
    @error('department_id')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">Course</label>
    <select name="course_id" class="form-select">
      <option value="">—</option>
      @foreach($courses as $id=>$name)
        <option value="{{ $id }}" {{ old('course_id', $student->course_id ?? '') == $id ? 'selected' : '' }}>{{ $name }}</option>
      @endforeach
    </select>
    @error('course_id')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">Academic Year</label>
    <select name="academic_year_id" class="form-select">
      <option value="">—</option>
      @foreach($academicYears as $id=>$label)
        <option value="{{ $id }}" {{ old('academic_year_id', $student->academic_year_id ?? '') == $id ? 'selected' : '' }}>{{ $label }}</option>
      @endforeach
    </select>
    @error('academic_year_id')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">Year Level</label>
    <input type="number" min="1" max="6" name="year_level" class="form-control" value="{{ old('year_level', $student->year_level ?? '') }}">
    @error('year_level')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-4">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
      @foreach(['active','inactive'] as $st)
        <option value="{{ $st }}" {{ old('status', $student->status ?? 'active') == $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
      @endforeach
    </select>
    @error('status')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
</div>
<div class="mt-3 d-flex gap-2">
  <button class="btn btn-brand">Save</button>
  <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary">Cancel</a>
</div>
