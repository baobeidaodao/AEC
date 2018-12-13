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
            <a href="{{url('/admin/teacher')}}" class="btn btn-sm btn-outline-danger btn-icon ml-auto"><i class="fe fe-x"></i></a>
        </div>
        <div class="card-body">
            <form>
                <div class="form-group" hidden>
                    <label class="form-label">ID</label>
                    <input class="form-control" placeholder="ID" value="{{ $teacher['id'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Membership ID</label>
                    <input class="form-control" placeholder="Membership ID" value="{{ $teacher['membership_id'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Given Name</label>
                    <input class="form-control" placeholder="Given Name" value="{{ $teacher['given_name'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Family Name</label>
                    <input class="form-control" placeholder="Family Name" value="{{ $teacher['family_name'] or '' }}" readonly/>
                </div>
            </form>
        </div>
    </div>
@endsection
