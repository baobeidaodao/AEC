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
            <h3 class="card-title">Group</h3>
            <a href="{{url('/admin/exam/' . $exam['id'])}}" class="btn btn-sm btn-outline-danger btn-icon ml-auto"><i class="fe fe-x"></i></a>
        </div>
        <div class="card-body">
            {!! Form::open(['method' => 'patch', 'route' => ['group.update', $group['id']], ]) !!}
            <div class="form-group" hidden>
                <label class="form-label">ID</label>
                <input name="id" class="form-control" placeholder="ID" value="{{ $group['id'] or '' }}" readonly/>
            </div>
            <div class="form-group" hidden>
                <label class="form-label">Section ID</label>
                <input name="section_id" class="form-control" placeholder="Section ID" value="{{ $group['section']['id'] or '' }}" readonly/>
            </div>
            <div class="form-group">
                <label class="form-label">Number</label>
                <input name="number" class="form-control" placeholder="Number" value="{{ $group['number'] or '' }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Exam Time</label>
                @include('public.datetime_picker', ['id' => 'examTime', 'name' => 'exam_time', 'placeholder' => 'exam_time', 'value' => $group['exam_time'], 'format' => 'yyyy-mm-dd hh:ii:ss', 'startView' => 0, 'readonly' => true, ])
            </div>
            <div class="form-group">
                <label class="form-label">Finish Time</label>
                <input class="form-control" placeholder="Finish Time" value="{{ $group['finish_time'] or '' }}" readonly/>
            </div>
            <div class="form-group">
                <label class="form-label">Level Code</label>
                <select name="level_id" class="form-control custom-select" title="">
                    @foreach($levelList as $level)
                        <option value="{{$level['id'] or ''}}" @if($group['level_id'] == $level['id']) selected @endif>{{$level['code'] or ''}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Exam Type</label>
                <select name="exam_type_id" class="form-control custom-select" title="">
                    @foreach($examTypeList as $examType)
                        <option value="{{$examType['id'] or ''}}" @if($group['exam_type_id'] == $examType['id']) selected @endif>{{$examType['code'] or ''}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Rest</label>
                <select name="rest_id" class="form-control custom-select" title="">
                    @foreach($restList as $rest)
                        <option value="{{$rest['id'] or ''}}" @if($group['rest_id'] == $rest['id']) selected @endif>{{$rest['name'] or ''}}</option>
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
