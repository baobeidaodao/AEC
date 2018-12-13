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
            <h3 class="card-title">Part F</h3>
            <a href="{{url('/admin/application')}}/{{$application['id'] or ''}}" class="btn btn-sm btn-outline-danger btn-icon ml-auto"><i class="fe fe-x"></i></a>
        </div>
        <div class="card-body">
            <form>
                <div class="form-group" hidden>
                    <label class="form-label">ID</label>
                    <input class="form-control" placeholder="ID" value="{{ $partF['id'] or '' }}" readonly/>
                </div>
                <div class="form-group" hidden>
                    <label class="form-label">Application ID</label>
                    <input class="form-control" placeholder="Application ID" value="{{ $partF['application']['id'] or '' }}" readonly/>
                </div>
                <div class="form-group hidden">
                    <label class="form-label">Applicant ID</label>
                    <input class="form-control" placeholder="Application ID" value="{{ $partF['applicant_id'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Applicant Name</label>
                    <input class="form-control" placeholder="Application ID" value="{{ $partF['applicant_name'] or '' }}" readonly/>
                </div>
                <div class="form-footer text-center">
                    <a href="{{url('/admin/part_f/' . $partF['id'] . '/edit')}}" class="btn btn-outline-warning btn-sm btn-icon"><i class="fe fe-edit"></i></a>
                </div>
            </form>
        </div>
    </div>
@endsection
