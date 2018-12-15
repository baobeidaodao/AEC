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
            <a href="{{url('/admin/studio')}}" class="btn btn-sm btn-outline-danger btn-icon ml-auto"><i class="fe fe-x"></i></a>
        </div>
        <div class="card-body">
            {!! Form::open(['method' => 'POST', 'route'=> 'studio.store']) !!}
            <div class="form-group">
                <label class="form-label">School</label>
                <select name="school_id" class="form-control custom-select" title="">
                    @foreach($schoolList as $school)
                        <option value="{{$school['id'] or ''}}" @if(old('school_id') == $school['id']) selected @endif>{{$school['name'] or ''}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Name</label>
                <input name="name" class="form-control" placeholder="Name" value="{{ old('name') }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Country</label>
                <select name="country_id" class="form-control custom-select" title="">
                    @foreach($countryList as $country)
                        <option value="{{$country['id'] or ''}}" @if(old('country_id') == $country['id']) selected @elseif($country['id'] == \App\Models\Country::DEFAULT_COUNTRY_ID) selected @endif>{{$country['name'] or ''}}</option>
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
                <label class="form-label">Examination Day Contact Tel</label>
                <input name="examination_day_contact_tel" class="form-control" placeholder="Examination Day Contact Tel" value="{{ old('examination_day_contact_tel') }}"/>
            </div>
            <div class="form-footer text-center">
                <button type="submit" class="btn btn-sm btn-outline-warning btn-icon"><i class="fe fe-send"></i>Save</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
