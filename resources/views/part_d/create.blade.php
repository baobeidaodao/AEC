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
            <h3 class="card-title">Part D (Applicant Details 申请人详细信息)</h3>
            <a href="{{url('/admin/application')}}" class="btn btn-sm btn-outline-danger btn-icon ml-auto"><i class="fe fe-x"></i></a>
        </div>
        <div class="card-body">
            {!! Form::open(['method' => 'POST', 'route'=> 'part_d.store']) !!}
            <div class="form-group" hidden>
                <label class="form-label">Application ID</label>
                <input name="application_id" class="form-control" placeholder="Application ID" value="{{ $application['id'] or '' }}" readonly/>
            </div>
            <div class="form-group" hidden>
                <label class="form-label">Applicant ID</label>
                <input name="applicant_id" class="form-control" placeholder="Applicant ID" value="{{ old('applicant_id') }}" readonly/>
            </div>
            <div class="form-group">
                <label class="form-label">Applicant Name</label>
                <input name="applicant_name" class="form-control" placeholder="Applicant Name" value="{{ old('applicant_name') }}"/>
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
                <label class="form-label">Impossible Dates for Delivery (格式：YYYY-MM-DD  示例：2019-01-01)</label>
                @include('public.datetime_picker', ['id' => 'deliveryDate', 'name' => 'delivery_date', 'placeholder' => 'Delivery Date', 'value' => old('delivery_date'), 'format' => 'yyyy-mm-dd', ])
            </div>
            <div class="form-group">
                <div class="form-label">Neighbour (I am happy for a neighbour to receive my delivery. Yes or No?)</div>
                <div class="custom-controls-stacked">
                    <label class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" name="neighbour" value="0" @if(old('neighbour')===0||old('neighbour')==='0') checked @endif>
                        <span class="custom-control-label">No</span>
                    </label>
                    <label class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" name="neighbour" value="1" @if(old('neighbour')===1||old('neighbour')==='1') checked @endif>
                        <span class="custom-control-label">Yes</span>
                    </label>
                </div>
            </div>
            <div class="form-footer text-center">
                @permission('edit_application')
                <button type="submit" class="btn btn-sm btn-outline-warning btn-icon"><i class="fe fe-send"></i>Save 保存 & Next</button>
                @endpermission
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
