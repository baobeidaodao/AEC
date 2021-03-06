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
            <h3 class="card-title">AEC2</h3>
            <a href="{{url('/admin/application/')}}" class="btn btn-sm btn-outline-danger btn-icon ml-auto"><i class="fe fe-x"></i></a>
        </div>
        <div class="card-body">
            {!! Form::open(['method' => 'POST', 'route'=> 'exam.store']) !!}
            <div class="form-group">
                <label class="form-label">Application ID</label>
                <input name="application_id" class="form-control" placeholder="Application ID" value="{{ $application['id'] or '' }}" readonly/>
            </div>
            <div class="form-footer text-center">
                @permission('edit_application')
                <button type="submit" class="btn btn-sm btn-outline-warning btn-icon"><i class="fe fe-send"></i>Save 保存 & Next</button>
                @endpermission
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
