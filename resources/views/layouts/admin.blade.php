@extends('layouts.app')

@section('content')
<style>
  .admin-shell { width: 100%; max-width: 1200px; margin: 0 auto; }
  .side-card { border:0; border-radius:20px; background:#fff; box-shadow: 0 10px 22px rgba(0,0,0,.10); }
  .side-heading { background: #efefef; border-radius: 18px; padding:.8rem 1rem; margin-bottom:1rem; font-weight:600; color:#555; text-align:center; }
  .side-link { display:flex; align-items:center; gap:.7rem; padding:.65rem .6rem; color:#222; text-decoration:none; border-radius:12px; transition: background .15s ease, box-shadow .15s ease; }
  .side-link:hover { background:#f7f7f7; }
  .side-link.active { background:#ececec; font-weight:600; box-shadow: inset 0 2px 0 rgba(0,0,0,.04); }
  .chip { padding:.15rem .5rem; border-radius:10px; background:#f1f1f1; font-size:.75rem; }
  .mini-card { border:0; border-radius:18px; background:#fff; box-shadow: 0 10px 22px rgba(0,0,0,.12); }
  .overview-card { border:0; border-radius:18px; background:#fff; box-shadow: 0 10px 22px rgba(0,0,0,.12); }
  .overview-row .item { display:flex; align-items:center; justify-content:space-between; padding: .9rem 1rem; border-radius:10px; background:#f6f6f6; margin:.5rem 0; }
  .icon-pill { width:40px; height:40px; display:grid; place-items:center; border-radius:10px; background:#eaf3ff; margin-right:.6rem; }
</style>

<div class="container-fluid py-3">
  <div class="row g-4 admin-shell">
    <aside class="col-12 col-lg-3">
      <div class="side-card p-3">
        <div class="side-heading">System Overview</div>
        <div class="vstack gap-1">
          <a class="side-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">🏠 <span>Dashboard</span></a>
          <a class="side-link {{ request()->routeIs('admin.students.*') ? 'active' : '' }}" href="{{ route('admin.students.index') }}">🎓 <span>Student Management</span></a>
          <a class="side-link {{ request()->routeIs('admin.faculties.*') ? 'active' : '' }}" href="{{ route('admin.faculties.index') }}">🧑‍🏫 <span>Faculty Management</span></a>
          <a class="side-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">📈 <span>Report</span></a>
          <a class="side-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">⚙️ <span>System Settings</span></a>
        </div>
        <hr>
        <a href="{{ route('admin.profile') }}" class="text-decoration-none text-dark d-block">
          <div class="h6 mb-1">Administrator</div>
          <div><span class="chip">Admin</span></div>
        </a>
        <div class="mt-3">
          <a class="text-danger text-decoration-none" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-admin').submit();">⏻ Sign Out</a>
          <form id="logout-form-admin" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </div>
      </div>
    </aside>

    <main class="col-12 col-lg-9">
      @yield('admin-content')
    </main>
  </div>
</div>
@endsection
