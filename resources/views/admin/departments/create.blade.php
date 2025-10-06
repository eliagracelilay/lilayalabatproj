@extends('layouts.admin')

@section('admin-content')
<h4 class="mb-3">New Department</h4>
@if($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
  </div>
@endif
<form method="post" action="{{ route('admin.departments.store') }}">
  @include('admin.departments._form')
</form>
@endsection
