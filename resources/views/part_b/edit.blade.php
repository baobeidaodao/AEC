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
            <h3 class="card-title">Part B</h3>
            <a href="{{url('/admin/application')}}" class="btn btn-sm btn-outline-danger btn-icon ml-auto"><i class="fe fe-x"></i></a>
        </div>
        <div class="card-body">
            {!! Form::open(['method' => 'patch', 'route' => ['part_b.update', $partB['id']], ]) !!}
            <div class="form-group" hidden>
                <label class="form-label">ID</label>
                <input name="id" class="form-control" placeholder="ID" value="{{ $partB['id'] or '' }}" readonly/>
            </div>
            <div class="form-group" hidden>
                <label class="form-label">Application ID</label>
                <input name="application_id" class="form-control" placeholder="Application ID" value="{{ $partB['application']['id'] or '' }}" readonly/>
            </div>
            <div class="form-group" hidden>
                <label class="form-label">School ID</label>
                <input name="school_id" class="form-control" placeholder="School ID" value="{{ $partB['studio']['school_id'] or '' }}" readonly/>
            </div>
            <div class="form-group" hidden>
                <label class="form-label">Studio ID</label>
                <input name="studio_id" class="form-control" placeholder="Studio ID" value="{{ $partB['studio_id'] or '' }}" readonly/>
            </div>
            <div class="form-group">
                <label class="form-label">Studio Name</label>
                <input name="studio_name" class="form-control" placeholder="Studio Name" value="{{ $partB['studio_name'] or '' }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Country</label>
                <select name="country_id" class="form-control custom-select" title="">
                    @foreach($countryList as $country)
                        <option value="{{$country['id'] or ''}}" @if($partB['country_id'] == $country['id']) selected @elseif($country['id'] == \App\Models\Country::DEFAULT_COUNTRY_ID) selected @endif>{{$country['name'] or ''}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Address 1</label>
                <input name="address_1" class="form-control" placeholder="Address 1" value="{{ $partB['address_1'] or '' }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Address 2</label>
                <input name="address_2" class="form-control" placeholder="Address 2" value="{{ $partB['address_2'] or '' }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Address 3</label>
                <input name="address_3" class="form-control" placeholder="Address 3" value="{{ $partB['address_3'] or '' }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Post Code</label>
                <input name="post_code" class="form-control" placeholder="Post Code" value="{{ $partB['post_code'] or '' }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Tel</label>
                <input name="tel" class="form-control" placeholder="Tel" value="{{ $partB['tel'] or '' }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Examination Day Contact Tel</label>
                <input name="examination_day_contact_tel" class="form-control" placeholder="Examination Day Contact Tel" value="{{ $partB['examination_day_contact_tel'] or '' }}"/>
            </div>
            <div class="form-footer text-center">
                <button type="submit" class="btn btn-sm btn-outline-warning btn-icon"><i class="fe fe-send"></i>Save</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
