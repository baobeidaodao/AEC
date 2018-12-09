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
            <h3 class="card-title">Show</h3>
            <a href="{{url('/admin/school')}}" class="btn btn-sm btn-outline-danger btn-icon ml-auto"><i class="fe fe-x"></i></a>
        </div>
        <div class="card-body">
            <form>
                <div class="form-group">
                    <label class="form-label">ID</label>
                    <input class="form-control" placeholder="ID" value="{{ $school['id'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Name</label>
                    <input class="form-control" placeholder="Name" value="{{ $school['name'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Code</label>
                    <input class="form-control" placeholder="Code" value="{{ $school['code'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input class="form-control" placeholder="Email" value="{{ $school['email'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Tel</label>
                    <input class="form-control" placeholder="Tel" value="{{ $school['tel'] or '' }}" readonly/>
                </div>
            </form>
        </div>
    </div>
@endsection
