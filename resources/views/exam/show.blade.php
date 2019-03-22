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
            <h3 class="card-title"><a href="{{url('/admin/exam/' . $exam['id'])}}" class="btn @if($exam['check']==1) btn-outline-success @else btn-outline-danger @endif btn-sm btn-icon ml-auto">AEC2</a></h3>
            <div class="ml-auto">Total Hours : {{$exam['totalHours'] or ''}}</div>
            <div class="btn-list ml-auto">
                @if($full)
                    <a href="{{url('/admin/application/copy/' . $application['id'] )}}" class="btn btn-outline-info btn-sm btn-icon ml-auto"><i class="fe fe-plus"></i>本次申请已达上限，点击此处，再加一次申请</a>
                @else
                    <a href="{{url('/admin/section/create?exam_id=')}}{{$exam['id'] or ''}}" class="btn btn-outline-info btn-sm btn-icon ml-auto"><i class="fe fe-plus"></i>添加考试日 Section</a>
                @endif
                <a href="{{url('/admin/exam/' . $exam['id'])}}" class="btn btn-outline-success btn-sm btn-icon ml-auto" hidden><i class="fe fe-eye"></i></a>
                <a href="{{url('/admin/exam/' . $exam['id'] . '/edit')}}" class="btn btn-outline-warning btn-sm btn-icon ml-auto" hidden><i class="fe fe-edit"></i></a>
                <a href="{{url('/admin/application/')}}" class="btn btn-outline-danger btn-sm btn-icon ml-auto" hidden><i class="fe fe-x"></i></a>
            </div>
        </div>
    </div>
    @include('exam.table', ['exam' => $exam])
@endsection
