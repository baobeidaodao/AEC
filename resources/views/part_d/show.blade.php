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
            <h3 class="card-title">Part D</h3>
            <a href="{{url('/admin/application')}}" class="btn btn-sm btn-outline-danger btn-icon ml-auto"><i class="fe fe-x"></i></a>
        </div>
        <div class="card-body">
            <form>
                <div class="form-group" hidden>
                    <label class="form-label">ID</label>
                    <input class="form-control" placeholder="ID" value="{{ $partD['id'] or '' }}" readonly/>
                </div>
                <div class="form-group" hidden>
                    <label class="form-label">Application ID</label>
                    <input class="form-control" placeholder="Application ID" value="{{ $partD['application']['id'] or '' }}" readonly/>
                </div>
                <div class="form-group" hidden>
                    <label class="form-label">Applicant ID</label>
                    <input class="form-control" placeholder="Applicant ID" value="{{ $partD['applicant_id'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Applicant Name</label>
                    <input class="form-control" placeholder="Name" value="{{ $partD['applicant_name'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Membership ID</label>
                    <input class="form-control" placeholder="Membership ID" value="{{ $partD['membership_id'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Identity</label>
                    <input class="form-control" placeholder="Identity" value="{{ $partD['identity']['name'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Address 1</label>
                    <input class="form-control" placeholder="Address 1" value="{{ $partD['address_1'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Address 2</label>
                    <input class="form-control" placeholder="Address 2" value="{{ $partD['address_2'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Address 3</label>
                    <input class="form-control" placeholder="Address 3" value="{{ $partD['address_3'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Post Code</label>
                    <input class="form-control" placeholder="Post Code" value="{{ $partD['post_code'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Tel</label>
                    <input class="form-control" placeholder="Tel" value="{{ $partD['tel'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Fax</label>
                    <input class="form-control" placeholder="Fax" value="{{ $partD['fax'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input class="form-control" placeholder="Email" value="{{ $partD['email'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Delivery Date</label>
                    <input class="form-control" placeholder="Delivery Date" value="{{ $partD['delivery_date'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <div class="form-label">Neighbour</div>
                    <div class="custom-controls-stacked">
                        <label class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" name="neighbour" value="0" @if($partD['neighbour']==0) checked @endif readonly>
                            <span class="custom-control-label">No</span>
                        </label>
                        <label class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" name="neighbour" value="1" @if($partD['neighbour']==1) checked @endif readonly>
                            <span class="custom-control-label">Yes</span>
                        </label>
                    </div>
                </div>
                <div class="form-footer text-center">
                    <a href="{{url('/admin/part_d/' . $partD['id'] . '/edit')}}" class="btn btn-outline-warning btn-sm btn-icon"><i class="fe fe-edit"></i></a>
                </div>
            </form>
        </div>
    </div>
@endsection
