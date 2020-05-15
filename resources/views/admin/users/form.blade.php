<div class="form group">
    {{ isset($user)?$user->name:"" }}
</div>
<div class="form-group">
  <label for="">Name</label>
  <input type="text"
    class="form-control" name="name" id="" aria-describedby="helpId" value="{{ isset($user)?$user->name:null }}">
</div>
<div class="form-group">
  <label for="">Email</label>
  <input type="text"
    class="form-control" name="email" id="" aria-describedby="helpId" value="{{ isset($user)?$user->email:null }}">
</div>

<div class="form-group">
  <label for="">Password</label>
  <input type="text"
    class="form-control" name="password" id="" aria-describedby="helpId" value="shibboleth">
</div>

<div class="form-group {{ $errors->has('admin') ? 'has-error' : ''}}">
    <label for="admin" class="control-label">{{ 'Admin' }}</label>
    <div class="radio">
    <label><input name="admin" type="radio" value="1" {{ (isset($user) && 1 == $user->admin) ? 'checked' : '' }}> Yes</label>
</div>
<div class="radio">
    <label><input name="admin" type="radio" value="0" @if (isset($user)) {{ (0 == $user->admin) ? 'checked' : '' }} @else {{ 'checked' }} @endif> No</label>
</div>
    {!! $errors->first('admin', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
  <label for="">Assignment Groups</label>
  <select class="form-control" name="assignment_groups[]" id="" multiple>
    @foreach (\App\AssignmentGroup::all() as $assignmentGroup )
    <option value={{ $assignmentGroup->id }} {{ (isset($user) && $user->assignmentGroups->contains($assignmentGroup->id))?"SELECTED":null }}>{{ $assignmentGroup->group_name }}</option>
  
    @endforeach
    </select>
</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
