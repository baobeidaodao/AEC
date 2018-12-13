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
            <h3 class="card-title">Part A</h3>
            <a href="{{url('/admin/application')}}/{{$application['id'] or ''}}" class="btn btn-sm btn-outline-danger btn-icon ml-auto"><i class="fe fe-x"></i></a>
        </div>
        <div class="card-body">
            <form>
                <div class="form-group" hidden>
                    <label class="form-label">ID</label>
                    <input class="form-control" placeholder="ID" value="{{ $partA['id'] or '' }}" readonly/>
                </div>
                <div class="form-group" hidden>
                    <label class="form-label">Application ID</label>
                    <input class="form-control" placeholder="AEC" value="{{ $partA['application']['id'] or '' }}" readonly/>
                </div>
                <div class="form-group" hidden>
                    <label class="form-label">School ID</label>
                    <input class="form-control" placeholder="School ID" value="{{ $partA['school_id'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">School Name</label>
                    <input class="form-control" placeholder="School Name" value="{{ $partA['school_name'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">School Code</label>
                    <input class="form-control" placeholder="School Code" value="{{ $partA['school_code'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input class="form-control" placeholder="Email" value="{{ $partA['email'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Tel</label>
                    <input class="form-control" placeholder="Tel" value="{{ $partA['tel'] or '' }}" readonly/>
                </div>
                <div class="form-footer text-center">
                    <a href="{{url('/admin/part_a/' . $partA['id'] . '/edit')}}" class="btn btn-outline-warning btn-sm btn-icon"><i class="fe fe-edit"></i></a>
                </div>
            </form>
        </div>
    </div>
@endsection
