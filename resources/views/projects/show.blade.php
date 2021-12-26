@extends('layouts.master')
@section('content')
<!--card-body -->
<div class="card">
  <div class="card-header">
    <h2 class="card-title text-center">Tasks</h2>
  </div>
  <div class="card-body">
    <table id="projectsTable" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th class="text-center"> Task ID</th>
          <th class="text-center"> Type </th>
          <th class="text-center"> Occurances </th>
          <th class="text-center"> Result </th>
          <th class="text-center"> created at </th>
          <th class="text-center"> ended at </th>
        </tr>
      </thead>
      <tbody>
      @foreach($project->tasks as $task)
        @if($task->status == 1)
        <tr style="background-color:#90EE90">
        @else
        <tr style="background-color:#ff0000">
        @endif
          <td class="text-center"> {{$task->id}} </td>
          <td class="text-center"> {{$task->type->name}} </td>
          <td class="text-center"> {{$task->count}}</td>
          @if($task->status == 0 )
            <td class="text-center"> Fail</td>
          @else
            <td class="text-center"> Pass</td>
          @endif
          <td class="text-center"> {{$task->created_at}} </td>
          <td class="text-center"> {{$task->updated_at}} </td>
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
