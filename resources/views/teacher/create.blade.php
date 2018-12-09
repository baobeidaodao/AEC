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
            <h3 class="card-title">Create</h3>
            <a href="{{url('/admin/teacher')}}" class="btn btn-sm btn-outline-danger btn-icon ml-auto"><i class="fe fe-x"></i></a>
        </div>
        <div class="card-body">
            {!! Form::open(['method' => 'POST', 'route'=> 'teacher.store']) !!}
            <div class="form-group">
                <label class="form-label">Membership ID</label>
                <input name="membership_id" class="form-control" placeholder="Membership ID" value="{{ old('membership_id') }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Given Name</label>
                <input name="given_name" class="form-control" placeholder="Given Name" value="{{ old('given_name') }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Family Name</label>
                <input name="family_name" class="form-control" placeholder="Family Name" value="{{ old('family_name') }}"/>
            </div>
            <div class="form-footer text-center">
                <button type="submit" class="btn btn-sm btn-outline-warning btn-icon"><i class="fe fe-send"></i></button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
