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
            <h3 class="card-title">Section</h3>
            <a href="{{url('/admin/exam/' . $exam['id'])}}" class="btn btn-sm btn-outline-danger btn-icon ml-auto"><i
                        class="fe fe-x"></i></a>
        </div>
        <div class="card-body">
            {!! Form::open(['method' => 'POST', 'route'=> 'section.store']) !!}
            <div class="form-group" hidden>
                <label class="form-label">Exam ID</label>
                <input name="exam_id" class="form-control" placeholder="Exam ID" value="{{ $exam['id'] or '' }}"
                       readonly/>
            </div>
            <div class="form-group">
                <label class="form-label">Number (考试日)</label>
                <input name="number" class="form-control" placeholder="Number"
                       value="{{ count($exam['section_list']) + 1 }}" readonly/>
            </div>
            <div class="form-group">
                <label class="form-label">Exam Time (时间格式：HH:mm ，示例：09:30)</label>
                <input name="exam_time" class="form-control" placeholder="Exam Time" type="text"
                       value="{{old('exam_time')}}"/>
                {{--@include('public.datetime_picker', ['id' => 'examTime', 'name' => 'exam_time', 'placeholder' => 'exam_time', 'value' => old('exam_time'), 'format' => 'hh:ii', 'startView' => 0])--}}
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
