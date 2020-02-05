@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-sm-12">
        INC: {{ $incident->incident}}
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        Opened By: {{ $incident->opened_by}}
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        Comments:
        <pre> {{ $incident->comments}}
        </pre>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        Work Notes:
        <pre> {{ $incident->work_notes}}
        </pre>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        Close Notes:
        <pre> {{ $incident->close_notes}}
        </pre>
    </div>
</div>

@endsection
