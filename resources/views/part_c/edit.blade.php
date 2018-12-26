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
    <div class="card" hidden>
        <div class="card-header">
            <h3 class="card-title">Part C</h3>
            <div class="btn-list ml-auto">
                <a href="{{url('/admin/application')}}" class="btn btn-sm btn-outline-danger btn-icon ml-auto"><i class="fe fe-x"></i></a>
            </div>
        </div>
        <div class="card-body">
            {!! Form::open(['method' => 'patch', 'route' => ['part_c.update', $partC['id']], ]) !!}
            <div class="form-group" hidden>
                <label class="form-label">ID</label>
                <input name="id" class="form-control" placeholder="ID" value="{{ $partC['id'] or '' }}" readonly/>
            </div>
            <div class="form-group">
                <label class="form-label">Application ID</label>
                <input name="application_id" class="form-control" placeholder="Application ID" value="{{ $partC['application']['id'] or '' }}" readonly/>
            </div>
            <div class="form-footer text-center">
                <button type="submit" class="btn btn-sm btn-outline-warning btn-icon"><i class="fe fe-send"></i>Save 保存</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    @include('part_c.teacher')
@endsection
