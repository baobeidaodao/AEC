<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-11-21
 * Time: 19:28
 */
$oldRoleId = old('role');
?>

@extends('tabler')

@section('container')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Create</h3>
            <a href="{{url('/admin/user')}}" class="btn btn-sm btn-outline-danger btn-icon ml-auto"><i class="fe fe-x"></i></a>
        </div>
        <div class="card-body">
            {!! Form::open(['method' => 'POST', 'route'=> 'user.store']) !!}
            <div class="form-group">
                <label class="form-label">Name</label>
                <input name="name" class="form-control" placeholder="Name" value="{{ old('name') }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input name="email" class="form-control" placeholder="Email" value="{{ old('email') }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Phone</label>
                <input name="phone" class="form-control" placeholder="Phone" value="{{ old('phone') }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input name="password" class="form-control" placeholder="Password" value=""/>
            </div>
            @permission('admin')
            <div class="form-group">
                <div class="form-label">Roles</div>
                <div>
                    @foreach($roles as $role)
                        <label class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input" name="role[]"
                                   value="{{$role['id'] or ''}}"
                                   @if(isset($oldRoleId) && is_array($oldRoleId) && !empty($oldRoleId) && in_array($role['id'], $oldRoleId)) checked @endif>
                            <span class="custom-control-label">{{$role['name'] or ''}}</span>
                        </label>
                    @endforeach
                </div>
            </div>
            @endpermission
            <div class="form-footer text-center">
                <button type="submit" class="btn btn-sm btn-outline-warning btn-icon"><i class="fe fe-send"></i>Save 保存</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
