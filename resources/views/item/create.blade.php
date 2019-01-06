<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-11-21
 * Time: 19:28
 */
$oldPartCTeacherId = old('part_c_teacher_id');
?>

@extends('tabler')

@section('container')
    @include('application.nav')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Item</h3>
            <a href="{{url('/admin/exam/' . $exam['id'])}}" class="btn btn-sm btn-outline-danger btn-icon ml-auto"><i
                        class="fe fe-x"></i></a>
        </div>
        <div class="card-body">
            {!! Form::open(['method' => 'POST', 'route'=> 'item.store']) !!}
            <div class="form-group" hidden>
                <label class="form-label">Group ID</label>
                <input name="group_id" class="form-control" placeholder="Group ID" value="{{ $group['id'] or '' }}"
                       readonly/>
            </div>
            <div class="form-group">
                <label class="form-label">Number</label>
                <input name="number" class="form-control" placeholder="Number"
                       value="{{ count($group['item_list']) + 1 }}" readonly/>
            </div>
            <div class="form-group">
                <label class="form-label">Candidate ID No</label>
                <input name="student_number" class="form-control" placeholder="Candidate ID No"
                       value="{{ old('student_number') }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Given Name</label>
                <input name="given_name" class="form-control" placeholder="Given Name" value="{{ old('given_name') }}"/>
            </div>
            <div class="form-group">
                <label class="form-label">Family Name</label>
                <input name="family_name" class="form-control" placeholder="Family Name"
                       value="{{ old('family_name') }}"/>
            </div>
            <div class="form-group">
                <div class="form-label">Member</div>
                <div class="custom-controls-stacked">
                    <label class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" name="member" value="1"
                               @if(old('member')===1||old('member')==='1') checked @endif>
                        <span class="custom-control-label">Yes</span>
                    </label>
                    <label class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" name="member" value="0"
                               @if(old('member')===0||old('member')==='0') checked @endif>
                        <span class="custom-control-label">No</span>
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Birth Date</label>
                @include('public.datetime_picker', ['id' => 'birthDate', 'name' => 'birth_date', 'placeholder' => 'birth_date', 'value' => old('birth_date'), 'format'=>'dd/mm/yyyy', 'endDate'=> $birthDate, ])
            </div>
            <div class="form-group">
                <div class="form-label">Sex</div>
                <div class="custom-controls-stacked">
                    <label class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" name="sex" value="1"
                               @if(old('sex')===1||old('sex')==='1') checked @endif>
                        <span class="custom-control-label">M</span>
                    </label>
                    <label class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" name="sex" value="0"
                               @if(old('sex')===0||old('sex')==='0') checked @endif>
                        <span class="custom-control-label">F</span>
                    </label>
                </div>
            </div>
            <div class="form-group">
                <div class="form-label">Teacher</div>
                <div>
                    @foreach($partCTeacherList as $partCTeacher)
                        <label class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input" name="part_c_teacher_id[]"
                                   value="{{$partCTeacher['id'] or ''}}"
                                   @if(isset($oldPartCTeacherId) && is_array($oldPartCTeacherId) && !empty($oldPartCTeacherId) && in_array($partCTeacher['id'], $oldPartCTeacherId)) checked @endif>
                            <span class="custom-control-label">{{$partCTeacher['number'] or ''}}</span>
                        </label>
                    @endforeach
                </div>
            </div>
            <div class="form-footer text-center">
                <button type="submit" class="btn btn-sm btn-outline-warning btn-icon"><i class="fe fe-send"></i>Save 保存
                </button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
