@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-sm">
        <h1>{{ $incident->incident}}</h1>
    </div>
</div>
<div class="row">
    <div class="col-sm">
        <ul class="list-group">
            <li class="list-group-item"><b>Opened By:</b> {{ $incident->opened_by_name}} ({{ $incident->opened_by_internet_id}})</li>
            <li class="list-group-item"><b>Opened:</b> {{ $incident->opened_at}}</li>
            <li class="list-group-item"><b>Closed:</b> {{ $incident->closed_at}}</li>
            <li class="list-group-item"><b>Service Offering:</b> {{ $incident->service_offering_name}}</li>
            <li class="list-group-item"><b>Assignment Group:</b> {{ $incident->assignmentGroup->group_name }}</li>
    </div>
</div>
<div class="row mt-2">
    <div class="col-sm-2 text-right">
        <b>Close Notes:</b>
    </div>
    <div class="col-sm-10">
        <pre> {{ $incident->close_notes}}
        </pre>
    </div>
</div>
<div class="row">
        <div class="col-sm-2 text-right">
            <b>Work Notes and Comments:</b>
        </div>
        <div class="col-sm-10">
            <pre> {{ $incident->work_notes_and_comments}}
            </pre>
        </div>
    </div>


@endsection
