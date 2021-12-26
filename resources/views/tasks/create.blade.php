@extends('layouts.master')
@section('content')
<div class="card card-default">
    <div class="card-header">
        <h2 class="card-title text-center">Create Task</h2>
    </div>
    <form id="createTask" enctype="multipart/form-data" action="{{route('tasks.store')}}" method="post">
	  @csrf
      <div class="card-body">
        <div class="form-group">
          <label for="name">Project ID </label><br>
          <input type="text" class="form-control" id="name" name="name" placeholder="Example: PRJ_ABCDEF">
        </div>
        <span id="error-span"></span>
        <!-- radio -->
        <div class="form-group">
          <div class="form-check" id="types">
            @foreach($types as $type)
              <input class="form-check-input" type="radio" value="{{$type->id}}" name="type" id="{{$type->id}}">
              <label class="form-check-label" for="{{$type->id}}">{{$type->name}}</label>
            @endforeach
          </div>
        </div>
        <div class="form-group">
          <label for="file">File input</label>
          <input type="file" id="file" name="file" required>
          <p class="help-block">Allowed txt only</p>
        </div>
      </div>

      <!-- /.card-body -->
      <div class="card-footer">
        <button type="submit" class="btn btn-info btn-block" >Create</button>
      </div>
    </form>	
</div>
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(
  function(){
    $('input:radio:first-child').attr('checked',true);
  });

$('#createTask').submit(function(e){
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: "{{route('tasks.store')}}",
          data: new FormData(this),
          processData: false,
          contentType: false,
          success: function(data,status) {
            console.log("waleed");
            if ((data.errors)) {
              toastr.error( data.errors.name, 'Failed' , {timeOut: delay});
            } 
            else 
            {
              toastr.success('successfully', 'Done', {timeOut: delay});
              setTimeout(function () { window.location.href = "{{route("projects.index")}}"; }, delay); 
            }
        },
    });
});

</script>
@stop