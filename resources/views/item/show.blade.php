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
            <h3 class="card-title">Item</h3>
            <a href="{{url('/admin/item/?group_id=' . $group['id'])}}" class="btn btn-sm btn-outline-danger btn-icon ml-auto"><i class="fe fe-x"></i></a>
        </div>
        <div class="card-body">
            <form>
                <div class="form-group">
                    <label class="form-label">ID</label>
                    <input class="form-control" placeholder="ID" value="{{ $item['id'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Group ID</label>
                    <input class="form-control" placeholder="Group ID" value="{{ $item['group']['id'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Number</label>
                    <input class="form-control" placeholder="Number" value="{{ $item['number'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Candidate ID No</label>
                    <input class="form-control" placeholder="Candidate ID No" value="{{ $item['student']['number'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Given Name</label>
                    <input class="form-control" placeholder="Given Name" value="{{ $item['student']['given_name'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Family Name</label>
                    <input class="form-control" placeholder="Family Name" value="{{ $item['student']['family_name'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Birth Date</label>
                    <input class="form-control" placeholder="Birth Date" value="{{ $item['student']['birth_date'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <div class="form-label">Sex</div>
                    <div class="custom-controls-stacked">
                        <label class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" name="sex" value="1" readonly @if($item['student']['sex']==1) checked @endif>
                            <span class="custom-control-label">M</span>
                        </label>
                        <label class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" name="sex" value="0" readonly @if($item['student']['sex']==0) checked @endif>
                            <span class="custom-control-label">F</span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-label">Teacher</div>
                    <div>
                        <label class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input" name="teacher_number" value="1" checked="">
                            <span class="custom-control-label">1</span>
                        </label>
                        <label class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input" name="teacher_number" value="2">
                            <span class="custom-control-label">2</span>
                        </label>
                        <label class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input" name="teacher_number" value="3">
                            <span class="custom-control-label">3</span>
                        </label>
                        <label class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input" name="teacher_number" value="4">
                            <span class="custom-control-label">4</span>
                        </label>
                        <label class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input" name="teacher_number" value="5">
                            <span class="custom-control-label">5</span>
                        </label>
                        <label class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input" name="teacher_number" value="6">
                            <span class="custom-control-label">6</span>
                        </label>
                    </div>
                </div>
                <div class="form-footer text-center">
                    <a href="{{url('/admin/item/' . $item['id'] . '/edit')}}" class="btn btn-outline-warning btn-sm btn-icon"><i class="fe fe-edit"></i></a>
                </div>
            </form>
        </div>
    </div>
@endsection
