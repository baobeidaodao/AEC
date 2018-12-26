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
            <h3 class="card-title">Part C Teacher</h3>
            <a href="{{url('/admin/part_c/' . $partC['id'] . '/edit')}}" class="btn btn-sm btn-outline-danger btn-icon ml-auto"><i class="fe fe-x"></i></a>
        </div>
        <div class="card-body">
            {!! Form::open(['method' => 'POST', 'route'=> 'part_c_teacher.store']) !!}
            <div class="form-group" hidden>
                <label class="form-label">Application ID</label>
                <input name="application_id" class="form-control" placeholder="Application ID" value="{{ $application['id'] or '' }}" readonly/>
            </div>
            <div class="form-group" hidden>
                <label class="form-label">Part C ID</label>
                <input name="part_c_id" class="form-control" placeholder="Part C ID" value="{{ $partC['id'] or '' }}" readonly/>
            </div>
            <div class="form-group">
                <label class="form-label">Number</label>
                <input name="number" class="form-control" placeholder="Number" value="{{ count($partC['part_c_teacher_list']) +1 }}" readonly/>
            </div>
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
                <button type="submit" class="btn btn-sm btn-outline-warning btn-icon"><i class="fe fe-send"></i>Save 保存</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
