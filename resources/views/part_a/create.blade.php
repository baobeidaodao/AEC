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
    @include('application.nav')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Part A (Registered School Information)</h3>
            <a href="{{url('/admin/application')}}" class="btn btn-sm btn-outline-danger btn-icon ml-auto"><i class="fe fe-x"></i></a>
        </div>
        <div class="card-body">
            {!! Form::open(['method' => 'POST', 'route'=> 'part_a.store']) !!}
            <div class="form-group" hidden>
                <label class="form-label">Application ID</label>
                <input name="application_id" class="form-control" placeholder="Application ID" value="{{ $application['id'] or '' }}" readonly/>
            </div>
            <div class="form-group" hidden>
                <label class="form-label">School ID</label>
                <input name="school_id" class="form-control" placeholder="School ID" value="{{ old('school_id') }}" readonly/>
            </div>
            <div class="form-group">
                <label class="form-label">School ID</label>
                <input name="school_code" class="form-control" placeholder="School ID" value="{{ old('school_code') }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">School Name</label>
                <input name="school_name" class="form-control" placeholder="School Name" value="{{ old('school_name') }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input name="email" class="form-control" placeholder="Email" value="{{ old('email') }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Tel</label>
                <input name="tel" class="form-control" placeholder="Tel" value="{{ old('tel') }}"/>
            </div>
            <div class="form-footer text-center">
                <button type="submit" class="btn btn-sm btn-outline-warning btn-icon"><i class="fe fe-send"></i>Save 保存 & Next</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
