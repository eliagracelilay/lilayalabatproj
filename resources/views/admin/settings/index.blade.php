@extends('layouts.admin')

@section('admin-content')
@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<h4 class="mb-1">System Settings</h4>
<div class="text-muted mb-2">Configure system-wide settings and preferences</div>

<style>
  .tab-pill { display:inline-block; background:#b9b0ba7a; padding:.35rem .9rem; border-radius:999px; font-weight:600; color:#333; margin-right:.5rem; }
  .settings-panel { border-radius:24px; background: rgba(255,255,255,.75); backdrop-filter: blur(4px); box-shadow: 0 10px 22px rgba(0,0,0,.12); }
  .year-item { background:#f6f6f6; border-radius:14px; padding:.75rem 1rem; display:flex; align-items:center; justify-content:space-between; margin:.5rem 0; }
  .badge-soft { background:#e3f7e8; color:#2a8a46; border-radius:10px; padding:.1rem .5rem; font-size:.8rem; }
  .badge-soft.gray { background:#e9e9ef; color:#5f5f6a; }
  .tab-btn { display:inline-block; background:#b9b0ba7a; padding:.35rem .9rem; border-radius:999px; font-weight:600; color:#333; margin-right:.5rem; border:0; }
  .tab-btn.active { background:#a9a1ab; color:#fff; }
  .tab-pane { display:none; }
  .tab-pane.active { display:block; }
</style>

<div class="mb-2">
  <button class="tab-btn active" data-target="#academic-tab" type="button">Academic</button>
  <button class="tab-btn" data-target="#security-tab" type="button">Security</button>

  <div class="tab-content" id="myTabContent">
    <div class="tab-pane active" id="academic-tab">
      <div class="settings-panel p-3 mt-2">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <div class="fw-semibold">Academic Years</div>
          <div class="d-flex gap-2">
            <form method="post" action="{{ route('admin.academic-years.store') }}" class="d-flex gap-2">
              @csrf
              <input type="number" name="start_year" class="form-control" placeholder="Start" style="max-width:120px" required>
              <input type="number" name="end_year" class="form-control" placeholder="End" style="max-width:120px" required>
              <select name="status" class="form-select" style="max-width:140px">
                <option value="active">Active</option>
                <option value="completed">Completed</option>
              </select>
              <button class="btn btn-brand">+ Add Academic Year</button>
            </form>
          </div>
        </div>

        @forelse($years as $y)
          <div class="year-item">
            <div>
              <div class="fw-semibold">{{ $y->start_year }}-{{ $y->end_year }}
                <span class="badge-soft {{ $y->status!='active' ? 'gray' : '' }}">{{ ucfirst($y->status) }}</span>
              </div>
              <div class="text-muted small">15/08/{{ $y->start_year }} - 30/05/{{ $y->end_year }}</div>
            </div>
            <div class="d-flex gap-2">
              <form method="post" action="{{ route('admin.academic-years.update', $y) }}" class="d-flex gap-2">
                @csrf
                @method('PUT')
                <input type="number" name="start_year" class="form-control" value="{{ $y->start_year }}" style="max-width:100px">
                <input type="number" name="end_year" class="form-control" value="{{ $y->end_year }}" style="max-width:100px">
                <select name="status" class="form-select" style="max-width:130px">
                  @foreach(['active','completed','inactive'] as $st)
                    <option value="{{ $st }}" {{ $y->status === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                  @endforeach
                </select>
                <button class="btn btn-outline-secondary">Edit</button>
              </form>
              <form method="post" action="{{ route('admin.academic-years.destroy', $y) }}" onsubmit="return confirm('Archive this academic year?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-outline-danger">Archive</button>
              </form>
            </div>
          </div>
        @empty
          <div class="text-muted">No academic years yet.</div>
        @endforelse
      </div>

    </div>
    <div class="tab-pane" id="security-tab">
      <div class="settings-panel p-3 mt-2">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <div class="fw-semibold">Archived Academic Years</div>
        </div>

        @forelse($archivedYears as $y)
          <div class="year-item">
            <div>
              <div class="fw-semibold">{{ $y->start_year }}-{{ $y->end_year }}
                <span class="badge-soft gray">Archived</span>
              </div>
              <div class="text-muted small">15/08/{{ $y->start_year }} - 30/05/{{ $y->end_year }}</div>
            </div>
            <div class="d-flex gap-2">
              <form method="post" action="{{ route('admin.academic-years.restore', $y->id) }}" onsubmit="return confirm('Restore this academic year?')">
                @csrf
                <button class="btn btn-outline-success">Restore</button>
              </form>
            </div>
          </div>
        @empty
          <div class="text-muted">No archived academic years yet.</div>
        @endforelse
      </div>
      <div class="settings-panel p-3 mt-3">
        <div class="fw-semibold mb-2">Archived Students</div>
        @forelse($archivedStudents as $s)
          <div class="year-item">
            <div>
              <div class="fw-semibold">{{ $s->last_name }}, {{ $s->first_name }} <span class="text-muted">• {{ $s->student_no }}</span></div>
              <div class="text-muted small">{{ optional($s->department)->name ?: '—' }} | {{ optional($s->course)->title ?: '—' }}</div>
            </div>
            <div>
              <form method="post" action="{{ route('admin.students.restore', $s->id) }}" onsubmit="return confirm('Restore this student?')">
                @csrf
                <button class="btn btn-outline-success">Restore</button>
              </form>
            </div>
          </div>
        @empty
          <div class="text-muted">No archived students.</div>
        @endforelse
      </div>

      <div class="settings-panel p-3 mt-3">
        <div class="fw-semibold mb-2">Archived Faculties</div>
        @forelse($archivedFaculties as $f)
          <div class="year-item">
            <div>
              <div class="fw-semibold">{{ $f->last_name }}, {{ $f->first_name }} <span class="text-muted">• {{ $f->employee_no }}</span></div>
              <div class="text-muted small">{{ optional($f->department)->name ?: '—' }}</div>
            </div>
            <div>
              <form method="post" action="{{ route('admin.faculties.restore', $f->id) }}" onsubmit="return confirm('Restore this faculty?')">
                @csrf
                <button class="btn btn-outline-success">Restore</button>
              </form>
            </div>
          </div>
        @empty
          <div class="text-muted">No archived faculties.</div>
        @endforelse
      </div>

      <div class="settings-panel p-3 mt-3">
        <div class="fw-semibold mb-2">Archived Courses</div>
        @forelse($archivedCourses as $c)
          <div class="year-item">
            <div>
              <div class="fw-semibold">{{ $c->code }} — {{ $c->title }}</div>
              <div class="text-muted small">{{ optional($c->department)->name ?: '—' }}</div>
            </div>
            <div>
              <form method="post" action="{{ route('admin.courses.restore', $c->id) }}" onsubmit="return confirm('Restore this course?')">
                @csrf
                <button class="btn btn-outline-success">Restore</button>
              </form>
            </div>
          </div>
        @empty
          <div class="text-muted">No archived courses.</div>
        @endforelse
      </div>

      <div class="settings-panel p-3 mt-3">
        <div class="fw-semibold mb-2">Archived Departments</div>
        @forelse($archivedDepartments as $d)
          <div class="year-item">
            <div>
              <div class="fw-semibold">{{ $d->code }} — {{ $d->name }}</div>
              <div class="text-muted small">{{ $d->location ?: '—' }}</div>
            </div>
            <div>
              <form method="post" action="{{ route('admin.departments.restore', $d->id) }}" onsubmit="return confirm('Restore this department?')">
                @csrf
                <button class="btn btn-outline-success">Restore</button>
              </form>
            </div>
          </div>
        @empty
          <div class="text-muted">No archived departments.</div>
        @endforelse
      </div>
    </div>
  </div>
</div>
<script>
  (function(){
    const tabs = document.querySelectorAll('.tab-btn');
    const panes = document.querySelectorAll('.tab-pane');
    tabs.forEach(btn => {
      btn.addEventListener('click', () => {
        tabs.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        panes.forEach(p => p.classList.remove('active'));
        const target = document.querySelector(btn.getAttribute('data-target'));
        if (target) target.classList.add('active');
      });
    });

    // Open Security tab if the server flashed a tab preference
    const flashedTab = "{{ session('tab') }}";
    if (flashedTab === 'security') {
      const secBtn = document.querySelector('.tab-btn[data-target="#security-tab"]');
      if (secBtn) secBtn.click();
    }
  })();
  </script>
@endsection
