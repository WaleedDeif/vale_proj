@extends('layouts.master')
@section('content')
<!--card-body -->
<div class="card">
  <div class="card-header">
    <h2 class="card-title text-center">Prjects</h2>
  </div>
  <div class="card-body">
    <table id="projectsTable" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th class="text-center">Name</th>
          <th class="text-center">Tasks</th>
          <th class="text-center">Running</th>
          <th class="text-center">Link</th>
        </tr>
      </thead>
      <tbody>
      @foreach($projects as $project)
      <tr>
          <td class="text-center"> {{$project->name}} </td>
          <td class="text-center"> tasks </td>
          @if(!$project->hasRunningTask)
          <td class="text-center"> No </td>
          @else
          <td class="text-center"> Yes </td>
          @endif
          <td class="text-center"><a class="btn btn-info btn-sm" href="{{route('projects.show',$project->id)}}"> {{$project->name}} </td>
      </tr>
      @endforeach
      </tbody>
    </table>
</div>
</div>
<!-- /.card-body -->

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#projectsTable').DataTable();
});

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

</script>
@endsection
