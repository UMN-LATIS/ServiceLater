<div class="form-group {{ $errors->has('group_name') ? 'has-error' : ''}}">
    <label for="group_name" class="control-label">{{ 'Group Name' }}</label>
    <input class="form-control" name="group_name" type="text" id="group_name" value="{{ isset($assignmentgroup->group_name) ? $assignmentgroup->group_name : ''}}" >
    {!! $errors->first('group_name', '<p class="help-block">:message</p>') !!}
</div>



<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
