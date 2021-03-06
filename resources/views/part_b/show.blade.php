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
            <h3 class="card-title">Part B (Examination Location Information 考试中心基本信息)</h3>
            <a href="{{url('/admin/application')}}" class="btn btn-sm btn-outline-danger btn-icon ml-auto"><i class="fe fe-x"></i></a>
        </div>
        <div class="card-body">
            <form>
                <div class="form-group" hidden>
                    <label class="form-label">ID</label>
                    <input class="form-control" placeholder="ID" value="{{ $partB['id'] or '' }}" readonly/>
                </div>
                <div class="form-group" hidden>
                    <label class="form-label">Application ID</label>
                    <input class="form-control" placeholder="Application ID" value="{{ $partB['application']['id'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Country</label>
                    <input class="form-control" placeholder="Country" value="{{ $partB['country']['name'] or '' }}" readonly/>
                </div>
                <div class="form-group" hidden>
                    <label class="form-label">Studio ID</label>
                    <input class="form-control" placeholder="Studio ID" value="{{ $partB['studio_id'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Studio Name</label>
                    <input class="form-control" placeholder="Studio Name" value="{{ $partB['studio_name'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Address 1</label>
                    <input class="form-control" placeholder="Address 1" value="{{ $partB['address_1'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Address 2</label>
                    <input class="form-control" placeholder="Address 2" value="{{ $partB['address_2'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Address 3</label>
                    <input class="form-control" placeholder="Address 3" value="{{ $partB['address_3'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Post Code</label>
                    <input class="form-control" placeholder="Post Code" value="{{ $partB['post_code'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Tel</label>
                    <input class="form-control" placeholder="Tel" value="{{ $partB['tel'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Examination Day Contact Tel</label>
                    <input class="form-control" placeholder="Examination Day Contact Tel" value="{{ $partB['examination_day_contact_tel'] or '' }}" readonly/>
                </div>
                <div class="form-footer text-center">
                    <a href="{{url('/admin/part_b/' . $partB['id'] . '/edit')}}" class="btn btn-outline-warning btn-sm btn-icon"><i class="fe fe-edit"></i></a>
                </div>
            </form>
        </div>
    </div>
@endsection
