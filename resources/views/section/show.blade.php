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
            <a href="{{url('/admin/exam/' . $exam['id'])}}" class="btn btn-sm btn-outline-danger btn-icon ml-auto"><i class="fe fe-x"></i></a>
        </div>
        <div class="card-body">
            <form>
                <div class="form-group" hidden>
                    <label class="form-label">ID</label>
                    <input class="form-control" placeholder="ID" value="{{ $section['id'] or '' }}" readonly/>
                </div>
                <div class="form-group" hidden>
                    <label class="form-label">Exam ID</label>
                    <input class="form-control" placeholder="Exam ID" value="{{ $section['exam']['id'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Exam Time</label>
                    <input class="form-control" placeholder="Exam Time" value="{{ $section['exam_time'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Finish Time</label>
                    <input class="form-control" placeholder="Finish Time" value="{{ $section['finish_time'] or '' }}" readonly/>
                </div>
                <div class="form-footer text-center">
                    <a href="{{url('/admin/section/' . $section['id'] . '/edit')}}" class="btn btn-outline-warning btn-sm btn-icon"><i class="fe fe-edit"></i></a>
                </div>
            </form>
        </div>
    </div>
@endsection
