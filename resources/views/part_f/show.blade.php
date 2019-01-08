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
            <h3 class="card-title">Part F (By checking this box you are confirming that you have read ,understood, and agree to the RAD's terms and conditions of entry for examinations. This form must be submitted by the Applicant identified in Part D. The Applicant must enter their name in the box above and check the box acknowledging the terms and conditions.通过勾选此框，您确认您已阅读、理解并同意RAD的考试报名条款和条件。此表必须由D部分中指定的申请人提交。申请人必须在上面的框中输入其姓名，并勾选确认条款和条件的框。)</h3>
            <a href="{{url('/admin/application')}}" class="btn btn-sm btn-outline-danger btn-icon ml-auto"><i class="fe fe-x"></i></a>
        </div>
        <div class="card-body">
            <form>
                <div class="form-group" hidden>
                    <label class="form-label">ID</label>
                    <input class="form-control" placeholder="ID" value="{{ $partF['id'] or '' }}" readonly/>
                </div>
                <div class="form-group" hidden>
                    <label class="form-label">Application ID</label>
                    <input class="form-control" placeholder="Application ID" value="{{ $partF['application']['id'] or '' }}" readonly/>
                </div>
                <div class="form-group hidden">
                    <label class="form-label">Applicant ID</label>
                    <input class="form-control" placeholder="Application ID" value="{{ $partF['applicant_id'] or '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Applicant Name</label>
                    <input class="form-control" placeholder="Application ID" value="{{ $partF['applicant_name'] or '' }}" readonly/>
                </div>
                <div class="form-footer text-center">
                    <a href="{{url('/admin/part_f/' . $partF['id'] . '/edit')}}" class="btn btn-outline-warning btn-sm btn-icon"><i class="fe fe-edit"></i></a>
                </div>
            </form>
        </div>
    </div>
@endsection
