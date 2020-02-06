@extends('layouts.app')

@section('content')
<form>
<div class="row">
  <div class="col">
    
    <div class="form-group">
      <label for="">Assignment Group</label>

    </select>
      <select class="form-control" name="assignmentGroup" id="">
        <option>All</option>
        @foreach (Auth::user()->assignmentGroups as $assignmentGroup )
        <option value="{{ $assignmentGroup->id }}">{{ $assignmentGroup->group_name }}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="col">
    <div class="form-group">
      <label for="">User</label>
      <input type="text"
      class="form-control" name="user" id="user" aria-describedby="helpId" placeholder="">
      
    </div>
  </div>
  <div class="col">
    <div class="form-group">
      <label for="">Incident</label>
      <input type="text"
      class="form-control" name="incident" id="incident" aria-describedby="helpId" placeholder="">
      
    </div>
  </div>
</div>
<div class="row">
  <div class="col">
    <div class="form-group">
      <label for="">Text Seach</label>
      <input type="text"
      class="form-control" name="searchField" id="searchField" aria-describedby="helpId" placeholder="">
      <div class="form-check">
        <label class="form-check-label">
          <input type="checkbox" class="form-check-input" name="fullText" id="fullText" value="On" checked>
          Full Text Search
        </label>
      </div>
    </div>
  </div>
</div>



<input name="search" id="search" class="btn btn-primary" type="submit" value="search">
</form>
{{$dataTable->table([], true)}}


@endsection

@push('scripts')

{{$dataTable->scripts()}}

<script>  

jQuery.fn.dataTableExt.oApi.fnSortNeutral = function ( oSettings )
{
    /* Remove any current sorting */
    oSettings.aaSorting = [];
 
    /* Sort display arrays so we get them in numerical order */
    oSettings.aiDisplay.sort( function (x,y) {
        return x-y;
    } );
    oSettings.aiDisplayMaster.sort( function (x,y) {
        return x-y;
    } );
 
    /* Redraw */
    oSettings.oApi._fnReDraw( oSettings );
};

  $("form").on("submit", function(e) {

    e.preventDefault();
    if($("#searchField").val().length > 0) {
      $("#incidents-table").dataTable().fnSortNeutral();
    }
    $("#incidents-table").DataTable().draw();
  });
</script>
@endpush