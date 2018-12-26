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
            <a href="{{url('/admin/school')}}" class="btn btn-sm btn-outline-danger btn-icon ml-auto"><i class="fe fe-x"></i></a>
        </div>
        <div class="card-body">
            {!! Form::open(['method' => 'patch', 'route' => ['school.update', $school['id']], ]) !!}
            <div class="form-group" hidden>
                <label class="form-label">ID</label>
                <input name="id" class="form-control" placeholder="ID" value="{{ $school['id'] or '' }}" readonly/>
            </div>
            <div class="form-group">
                <label class="form-label">Name</label>
                <input name="name" class="form-control" placeholder="Name" value="{{ $school['name'] or '' }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Code</label>
                <input name="code" class="form-control" placeholder="Code" value="{{ $school['code'] or '' }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input name="email" class="form-control" placeholder="Email" value="{{ $school['email'] or '' }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Tel</label>
                <input name="tel" class="form-control" placeholder="Tel" value="{{ $school['tel'] or '' }}"/>
            </div>
            <div class="form-footer text-center">
                <button type="submit" class="btn btn-sm btn-outline-warning btn-icon"><i class="fe fe-send"></i>Save 保存</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    @include('school.studio')
@endsection
