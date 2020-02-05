@extends('layouts.app')

@section('content')
<div class="form-group">
  <label for="">User</label>
  <input type="text"
    class="form-control" name="user" id="user" aria-describedby="helpId" placeholder="">

</div>


<div class="form-group">
  <label for="">Assignment Group</label>
  <select class="form-control" name="assignmentGroup" id="">
    <option>All</option>
    <option value="1">T2 CLA (LATIS)</option>
  </select>
</div>

<input name="search" id="search" class="btn btn-primary" type="button" value="search">
    {{$dataTable->table([], true)}}


@endsection

@push('scripts')

{{$dataTable->scripts()}}
<script>  
$("#search").on("click", function() {
    $("#incidents-table").DataTable().draw();
});
</script>
@endpush