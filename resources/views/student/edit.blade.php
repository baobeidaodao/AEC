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
        <div class="card-header">
            <h3 class="card-title">Edit</h3>
            <a href="{{url('/admin/student')}}" class="btn btn-sm btn-outline-danger btn-icon ml-auto"><i class="fe fe-x"></i></a>
        </div>
        <div class="card-body">
            {!! Form::open(['method' => 'patch', 'route' => ['student.update', $student['id']], ]) !!}
            <div class="form-group" hidden>
                <label class="form-label">ID</label>
                <input name="id" class="form-control" placeholder="ID" value="{{ $student['id'] or '' }}" readonly/>
            </div>
            <div class="form-group">
                <label class="form-label">Number</label>
                <input name="number" class="form-control" placeholder="Number" value="{{ $student['number'] or '' }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Given Name</label>
                <input name="given_name" class="form-control" placeholder="Given Name" value="{{ $student['given_name'] or '' }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Family Name</label>
                <input name="family_name" class="form-control" placeholder="Family Name" value="{{ $student['family_name'] or '' }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Birth Date</label>
                @include('public.datetime_picker', ['id' => 'birthDate', 'name' => 'birth_date', 'placeholder' => 'birth_date', 'value' => date('d/m/Y', strtotime($student['birth_date'])), 'format' => 'dd/mm/yyyy', ])
            </div>
            <div class="form-group">
                <div class="form-label">Sex</div>
                <div class="custom-controls-stacked">
                    <label class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" name="sex" value="1" @if($student['sex'] == 1) checked @endif>
                        <span class="custom-control-label">M</span>
                    </label>
                    <label class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" name="sex" value="0" @if($student['sex'] == 0) checked @endif>
                        <span class="custom-control-label">F</span>
                    </label>
                </div>
            </div>
            <div class="form-footer text-center">
                <button type="submit" class="btn btn-sm btn-outline-warning btn-icon"><i class="fe fe-send"></i></button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
