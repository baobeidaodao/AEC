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
        <div class="card-body">
            <a href="{{url('/admin/application/')}}" class="btn btn-sm @if(isset($nav) && $nav=='application') btn-info @else btn-outline-info @endif">Application</a>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Create</h3>
            <a href="{{url('/admin/application')}}" class="btn btn-sm btn-outline-danger btn-icon ml-auto"><i class="fe fe-x"></i></a>
        </div>
        <div class="card-body">
            {!! Form::open(['method' => 'POST', 'route'=> 'application.store']) !!}
            <div class="form-group">
                <label class="form-label">AEC</label>
                <select name="aec_id" class="form-control custom-select" title="">
                    @foreach($aecList as $aec)
                        <option value="{{$aec['id'] or ''}}" @if(old('aec_id') == $aec['id']) selected @endif>{{$aec['year'] or ''}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-footer text-center">
                @permission('edit_application')
                <button type="submit" class="btn btn-sm btn-outline-warning btn-icon"><i class="fe fe-send"></i>Save 保存</button>
                @endpermission
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
