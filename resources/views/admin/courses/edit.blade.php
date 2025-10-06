@extends('layouts.admin')

@section('admin-content')
<h4 class="mb-3">Edit Course</h4>
@if($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
  </div>
@endif
<form method="post" action="{{ route('admin.courses.update', $course) }}">
  @method('PUT')
  @include('admin.courses._form')
</form>
@endsection
