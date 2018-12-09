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
            <a href="{{url('/admin/applicant')}}" class="btn btn-sm btn-outline-danger btn-icon ml-auto"><i class="fe fe-x"></i></a>
        </div>
        <div class="card-body">
            <form>
                <div class="form-group">
                    <label class="form-label">ID</label>
                    <input class="form-control" placeholder="ID" value="{{ $applicant['id'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Name</label>
                    <input class="form-control" placeholder="Name" value="{{ $applicant['name'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Membership ID</label>
                    <input class="form-control" placeholder="Membership ID" value="{{ $applicant['membership_id'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Identity</label>
                    <input class="form-control" placeholder="Identity" value="{{ $applicant['identity']['name'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Address 1</label>
                    <input class="form-control" placeholder="Address 1" value="{{ $applicant['address_1'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Address 2</label>
                    <input class="form-control" placeholder="Address 2" value="{{ $applicant['address_2'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Address 3</label>
                    <input class="form-control" placeholder="Address 3" value="{{ $applicant['address_3'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Post Code</label>
                    <input class="form-control" placeholder="Post Code" value="{{ $applicant['post_code'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Tel</label>
                    <input class="form-control" placeholder="Tel" value="{{ $applicant['tel'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Fax</label>
                    <input class="form-control" placeholder="Fax" value="{{ $applicant['fax'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input class="form-control" placeholder="Email" value="{{ $applicant['email'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Delivery Date</label>
                    <input class="form-control" placeholder="Delivery Date" value="{{ $applicant['delivery_date'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <div class="form-label">Neighbour</div>
                    <div class="custom-controls-stacked">
                        <label class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" name="neighbour" value="0" @if($applicant['neighbour']==0) checked @endif readonly>
                            <span class="custom-control-label">No</span>
                        </label>
                        <label class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" name="neighbour" value="1" @if($applicant['neighbour']==1) checked @endif readonly>
                            <span class="custom-control-label">Yes</span>
                        </label>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
