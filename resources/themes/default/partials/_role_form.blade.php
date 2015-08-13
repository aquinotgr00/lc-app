<?php
    $readonly = ($role->isEditable())? '' : 'readonly';
?>

<div class="form-group">
    {!! Form::label('name', trans('admin/roles/general.columns.name') ) !!}
    {!! Form::text('name', null, ['class' => 'form-control', $readonly]) !!}
</div>

<div class="form-group">
    {!! Form::label('display_name', trans('admin/roles/general.columns.display_name') ) !!}
    {!! Form::text('display_name', null, ['class' => 'form-control', $readonly]) !!}
</div>

<div class="form-group">
    {!! Form::label('description', trans('admin/roles/general.columns.description') ) !!}
    {!! Form::text('description', null, ['class' => 'form-control', $readonly]) !!}
</div>

<div class="form-group">
    {!! Form::label('options', trans('admin/roles/general.columns.options')) !!}
    <div class="checkbox" id="options" name="options">
        <label>
            {!! '<input type="hidden" name="resync_on_login" value="0">' !!}
            {!! Form::checkbox('resync_on_login', '1', $role->resync_on_login) !!} {{ trans('admin/roles/general.columns.resync_on_login') }}
        </label>
    </div>
</div>

<div class="form-group">
    {{ trans('admin/roles/general.columns.permissions') }}
    @foreach($perms as $perm)
        <?php
            $disabled = ($perm->canBeAssigned()) ? '' : 'disabled';
        ?>

        <div class="checkbox">
            <label>
                {!! Form::checkbox('perms[]', $perm->id, $role->hasPerm($perm), ( \App\Models\Permission::isForced($perm) || (!$perm->canBeAssigned()) )? ['disabled'] : null ) !!} {{ $perm->display_name }}
            </label>
        </div>
    @endforeach
</div>