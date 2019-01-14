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
            <form>
                <div class="form-group" hidden>
                    <label class="form-label">ID</label>
                    <input class="form-control" placeholder="ID" value="{{ $group['id'] or '' }}" readonly/>
                </div>
                <div class="form-group" hidden>
                    <label class="form-label">Section ID</label>
                    <input class="form-control" placeholder="Section ID" value="{{ $group['section']['id'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Exam Time</label>
                    <input class="form-control" placeholder="Exam Time" value="{{ $group['exam_time'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Finish Time</label>
                    <input class="form-control" placeholder="Finish Time" value="{{ $group['finish_time'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Level Code</label>
                    <input class="form-control" placeholder="Level Code" value="{{ $group['level']['code'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Exam Type</label>
                    <input class="form-control" placeholder="Exam Type" value="{{ $group['exam_type']['code'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Rest</label>
                    <input class="form-control" placeholder="" value="{{ $group['rest']['name'] or '' }}" readonly/>
                </div>
                <div class="form-footer text-center">
                    <a href="{{url('/admin/group/' . $group['id'] . '/edit')}}" class="btn btn-outline-warning btn-sm btn-icon"><i class="fe fe-edit"></i></a>
                </div>
            </form>
        </div>
    </div>
@endsection
