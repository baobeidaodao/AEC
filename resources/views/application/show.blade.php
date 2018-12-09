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
            <h3 class="card-title">Show</h3>
            <a href="{{url('/admin/application')}}" class="btn btn-sm btn-outline-danger btn-icon ml-auto"><i class="fe fe-x"></i></a>
        </div>
        <div class="card-body">
            <form>
                <div class="form-group">
                    <label class="form-label">ID</label>
                    <input class="form-control" placeholder="ID" value="{{ $application['id'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">AEC</label>
                    <input class="form-control" placeholder="AEC" value="{{ $application['aec']['year'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Create User</label>
                    <input class="form-control" placeholder="Create User" value="{{ $application['user']['name'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Create Time</label>
                    <input class="form-control" placeholder="Create Time" value="{{ $application['created_at'] or '' }}" readonly/>
                </div>
            </form>
        </div>
    </div>
@endsection
