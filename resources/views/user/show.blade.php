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
            <a href="{{url('/admin/user')}}" class="btn btn-sm btn-outline-danger btn-icon ml-auto"><i class="fe fe-x"></i></a>
        </div>
        <div class="card-body">
            <form>
                <div class="form-group" hidden>
                    <label class="form-label">ID</label>
                    <input class="form-control" placeholder="ID" value="{{ $user['id'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Name</label>
                    <input class="form-control" placeholder="Name" value="{{ $user['name'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input class="form-control" placeholder="Email" value="{{ $user['email'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Phone</label>
                    <input class="form-control" placeholder="Phone" value="{{ $user['phone'] or '' }}" readonly/>
                </div>
            </form>
        </div>
    </div>
@endsection
