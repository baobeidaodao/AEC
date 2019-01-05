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
            <h3 class="card-title">Part D (Applicant Details)</h3>
            <a href="{{url('/admin/application')}}" class="btn btn-sm btn-outline-danger btn-icon ml-auto"><i
                        class="fe fe-x"></i></a>
        </div>
        <div class="card-body">
            {!! Form::open(['method' => 'patch', 'route' => ['part_d.update', $partD['id']], ]) !!}
            <div class="form-group" hidden>
                <label class="form-label">ID</label>
                <input name="id" class="form-control" placeholder="ID" value="{{ $partD['id'] or '' }}" readonly/>
            </div>
            <div class="form-group" hidden>
                <label class="form-label">Application ID</label>
                <input name="application_id" class="form-control" placeholder="Application ID"
                       value="{{ $partD['application']['id'] or '' }}" readonly/>
            </div>
            <div class="form-group" hidden>
                <label class="form-label">Applicant ID</label>
                <input name="applicant_id" class="form-control" placeholder="Applicant ID"
                       value="{{ $partD['applicant_id'] or '' }}" readonly/>
            </div>
            <div class="form-group">
                <label class="form-label">Applicant Name</label>
                <input name="applicant_name" class="form-control" placeholder="Applicant Name"
                       value="{{ $partD['applicant_name'] or '' }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Membership ID</label>
                <input name="membership_id" class="form-control" placeholder="Membership ID"
                       value="{{ $partD['membership_id'] or '' }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Identity</label>
                <select name="identity_id" class="form-control custom-select" title="">
                    @foreach($identityList as $identity)
                        <option value="{{$identity['id'] or ''}}"
                                @if($partD['identity_id'] == $identity['id']) selected @endif>{{$identity['name'] or ''}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Address 1</label>
                <input name="address_1" class="form-control" placeholder="Address 1"
                       value="{{ $partD['address_1'] or '' }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Address 2</label>
                <input name="address_2" class="form-control" placeholder="Address 2"
                       value="{{ $partD['address_2'] or '' }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Address 3</label>
                <input name="address_3" class="form-control" placeholder="Address 3"
                       value="{{ $partD['address_3'] or '' }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Post Code</label>
                <input name="post_code" class="form-control" placeholder="Post Code"
                       value="{{ $partD['post_code'] or '' }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Tel</label>
                <input name="tel" class="form-control" placeholder="Tel" value="{{ $partD['tel'] or '' }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Fax</label>
                <input name="fax" class="form-control" placeholder="Fax" value="{{ $partD['fax'] or '' }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input name="email" class="form-control" placeholder="Email" value="{{ $partD['email'] or '' }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Delivery Date</label>
                @include('public.datetime_picker', ['id' => 'deliveryDate', 'name' => 'delivery_date', 'placeholder' => 'Delivery Date', 'value' => date('Y-m-d', strtotime($partD['delivery_date'])), 'datetime' => isset($partD['delivery_date']) ? $partD['delivery_date'] : '', 'format' => 'yyyy-mm-dd', ])
            </div>
            <div class="form-group">
                <div class="form-label">Neighbour (I am happy for a neighbour to receive my delivery. Yes or No?)</div>
                <div class="custom-controls-stacked">
                    <label class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" name="neighbour" value="0"
                               @if($partD['neighbour']==0) checked @endif>
                        <span class="custom-control-label">No</span>
                    </label>
                    <label class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" name="neighbour" value="1"
                               @if($partD['neighbour']==1) checked @endif>
                        <span class="custom-control-label">Yes</span>
                    </label>
                </div>
            </div>
            <div class="form-footer text-center">
                <button type="submit" class="btn btn-sm btn-outline-warning btn-icon"><i class="fe fe-send"></i>Save 保存
                </button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
