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
            <h3 class="card-title">Edit</h3>
            <a href="{{url('/admin/application')}}" class="btn btn-sm btn-outline-danger btn-icon ml-auto"><i class="fe fe-x"></i></a>
        </div>
        <div class="card-body">
            {!! Form::open(['method' => 'patch', 'route' => ['application.update', $application['id']], ]) !!}
            <div class="form-group" hidden>
                <label class="form-label">ID</label>
                <input name="id" class="form-control" placeholder="ID" value="{{ $application['id'] or '' }}" readonly/>
            </div>
            <div class="form-group">
                <label class="form-label">AEC</label>
                <select name="aec_id" class="form-control custom-select" title="">
                    @foreach($aecList as $aec)
                        <option value="{{$aec['id'] or ''}}" @if($application['aec_id'] == $aec['id']) selected @endif>{{$aec['year'] or ''}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-footer text-center">
                <button type="submit" class="btn btn-sm btn-outline-warning btn-icon"><i class="fe fe-send"></i>Save</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
