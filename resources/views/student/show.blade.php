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
            <h3 class="card-title">Student</h3>
            <a href="{{url('/admin/student')}}" class="btn btn-sm btn-outline-danger btn-icon ml-auto"><i class="fe fe-x"></i></a>
        </div>
        <div class="card-body">
            <form>
                <div class="form-group" hidden>
                    <label class="form-label">ID</label>
                    <input class="form-control" placeholder="ID" value="{{ $student['id'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Number</label>
                    <input class="form-control" placeholder="Number" value="{{ $student['number'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Given Name</label>
                    <input class="form-control" placeholder="Given Name" value="{{ $student['given_name'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Family Name</label>
                    <input class="form-control" placeholder="Family Name" value="{{ $student['family_name'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Birth Date</label>
                    <input class="form-control" placeholder="Birth Date" value="<?php echo date('d/m/Y', strtotime($student['birth_date']));?>" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Sex</label>
                    <div class="custom-controls-stacked">
                        <label class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" name="sex" value="1" @if($student['sex']==0) checked @endif readonly>
                            <span class="custom-control-label">M</span>
                        </label>
                        <label class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" name="sex" value="0" @if($student['sex']==1) checked @endif readonly>
                            <span class="custom-control-label">F</span>
                        </label>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
