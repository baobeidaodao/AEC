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
            <h3 class="card-title">Create</h3>
            <a href="{{url('/admin/applicant')}}" class="btn btn-sm btn-outline-danger btn-icon ml-auto"><i class="fe fe-x"></i></a>
        </div>
        <div class="card-body">
            {!! Form::open(['method' => 'POST', 'route'=> 'applicant.store']) !!}
            <div class="form-group">
                <label class="form-label">Name</label>
                <input name="name" class="form-control" placeholder="Name" value="{{ old('name') }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Membership ID</label>
                <input name="membership_id" class="form-control" placeholder="Membership ID" value="{{ old('membership_id') }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Identity</label>
                <select name="identity_id" class="form-control custom-select" title="">
                    @foreach($identityList as $identity)
                        <option value="{{$identity['id'] or ''}}" @if(old('identity_id') == $identity['id']) selected @endif>{{$identity['name'] or ''}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Address 1</label>
                <input name="address_1" class="form-control" placeholder="Address 1" value="{{ old('address_1') }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Address 2</label>
                <input name="address_2" class="form-control" placeholder="Address 2" value="{{ old('address_2') }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Address 3</label>
                <input name="address_3" class="form-control" placeholder="Address 3" value="{{ old('address_3') }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Post Code</label>
                <input name="post_code" class="form-control" placeholder="Post Code" value="{{ old('post_code') }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Tel</label>
                <input name="tel" class="form-control" placeholder="Tel" value="{{ old('tel') }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Fax</label>
                <input name="fax" class="form-control" placeholder="Fax" value="{{ old('fax') }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input name="email" class="form-control" placeholder="Email" value="{{ old('email') }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Delivery Date</label>
                @include('public.datetime_picker', ['id' => 'deliveryDate', 'name' => 'delivery_date', 'placeholder' => 'delivery_date', 'value' => old('delivery_date'), 'format' => 'yyyy-mm-dd hh:ii:ss', ])
            </div>
            <div class="form-group">
                <div class="form-label">Neighbour</div>
                <div class="custom-controls-stacked">
                    <label class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" name="neighbour" value="0" checked="">
                        <span class="custom-control-label">No</span>
                    </label>
                    <label class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" name="neighbour" value="1">
                        <span class="custom-control-label">Yes</span>
                    </label>
                </div>
            </div>
            <div class="form-footer text-center">
                <button type="submit" class="btn btn-sm btn-outline-warning btn-icon"><i class="fe fe-send"></i>Save</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
