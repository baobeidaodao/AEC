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
            <a href="{{url('/admin/studio')}}" class="btn btn-sm btn-outline-danger btn-icon ml-auto"><i class="fe fe-x"></i></a>
        </div>
        <div class="card-body">
            <form>
                <div class="form-group" hidden>
                    <label class="form-label">ID</label>
                    <input class="form-control" placeholder="ID" value="{{ $studio['id'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Name</label>
                    <input class="form-control" placeholder="Name" value="{{ $studio['name'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Country</label>
                    <input class="form-control" placeholder="Country" value="{{ $studio['country']['name'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Address 1</label>
                    <input class="form-control" placeholder="Address 1" value="{{ $studio['address_1'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Address 2</label>
                    <input class="form-control" placeholder="Address 2" value="{{ $studio['address_2'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Address 3</label>
                    <input class="form-control" placeholder="Address 3" value="{{ $studio['address_3'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Post Code</label>
                    <input class="form-control" placeholder="Post Code" value="{{ $studio['post_code'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Tel</label>
                    <input class="form-control" placeholder="Tel" value="{{ $studio['tel'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Examination Day Contact Tel</label>
                    <input class="form-control" placeholder="Examination Day Contact Tel" value="{{ $studio['examination_day_contact_tel'] or '' }}" readonly/>
                </div>
            </form>
        </div>
    </div>
@endsection
