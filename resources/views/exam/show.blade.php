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
            <h3 class="card-title"><a href="{{url('/admin/exam/' . $exam['id'])}}" class="btn btn-outline-success btn-sm btn-icon ml-auto">Exam</a></h3>
            <div class="btn-list ml-auto">
                <a href="{{url('/admin/section/create?exam_id=')}}{{$exam['id'] or ''}}" class="btn btn-outline-info btn-sm btn-icon ml-auto"><i class="fe fe-plus"></i></a>
                <a href="{{url('/admin/exam/' . $exam['id'])}}" class="btn btn-outline-success btn-sm btn-icon ml-auto"><i class="fe fe-eye"></i></a>
                <a href="{{url('/admin/exam/' . $exam['id'] . '/edit')}}" class="btn btn-outline-warning btn-sm btn-icon ml-auto"><i class="fe fe-edit"></i></a>
                <a href="{{url('/admin/application/')}}" class="btn btn-outline-danger btn-sm btn-icon ml-auto"><i class="fe fe-x"></i></a>
            </div>
        </div>
    </div>
    @include('exam.table', ['exam' => $exam])
@endsection
