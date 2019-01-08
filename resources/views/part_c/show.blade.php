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
            <h3 class="card-title">Part C (Registered Teacher details 注册教师详细信息)</h3>
            <div class="btn-list ml-auto">
                <a href="{{url('/admin/application')}}" class="btn btn-sm btn-outline-danger btn-icon"><i class="fe fe-x"></i></a>
            </div>
        </div>
        <div class="card-body">
            <form>
                <div class="form-group" hidden>
                    <label class="form-label">ID</label>
                    <input class="form-control" placeholder="ID" value="{{ $partC['id'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Application ID</label>
                    <input class="form-control" placeholder="Application ID" value="{{ $partC['application']['id'] or '' }}" readonly/>
                </div>
                <div class="form-footer text-center">
                    <a href="{{url('/admin/part_c/' . $partC['id'] . '/edit')}}" class="btn btn-outline-warning btn-sm btn-icon"><i class="fe fe-edit"></i></a>
                </div>
            </form>
        </div>
    </div>
    @include('part_c.teacher')
@endsection
