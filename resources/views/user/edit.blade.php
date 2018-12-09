<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-11-21
 * Time: 19:28
 */
?>

@extends('tabler')

@section('container')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit</h3>
            <a href="{{url('/admin/user')}}" class="btn btn-sm btn-outline-danger btn-icon ml-auto"><i class="fe fe-x"></i></a>
        </div>
        <div class="card-body">
            {!! Form::open(['method' => 'patch', 'route' => ['user.update', $user['id']], ]) !!}
            <div class="form-group">
                <label class="form-label">ID</label>
                <input name="id" class="form-control" placeholder="ID" value="{{ $user['id'] or '' }}" readonly/>
            </div>
            <div class="form-group">
                <label class="form-label">Name</label>
                <input name="name" class="form-control" placeholder="Name" value="{{ $user['name'] or '' }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input name="email" class="form-control" placeholder="Email" value="{{ $user['email'] or '' }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Phone</label>
                <input name="phone" class="form-control" placeholder="Phone" value="{{ $user['phone'] or '' }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input name="password" class="form-control" placeholder="Password" value=""/>
            </div>
            <div class="form-footer text-center">
                <button type="submit" class="btn btn-sm btn-outline-warning btn-icon"><i class="fe fe-send"></i></button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
