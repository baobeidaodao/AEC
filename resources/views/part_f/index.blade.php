<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-11-21
 * Time: 15:59
 */
?>

@extends('tabler')

@section('container')
    @include('application.nav')
    <div class="row row-cards row-deck">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Part F (By checking this box you are confirming that you have read ,understood, and agree to the RAD's terms and conditions of entry for examinations. This form must be submitted by the Applicant identified in Part D. The Applicant must enter their name in the box above and check the box acknowledging the terms and conditions.通过勾选此框，您确认您已阅读、理解并同意RAD的考试报名条款和条件。此表必须由D部分中指定的申请人提交。申请人必须在上面的框中输入其姓名，并勾选确认条款和条件的框。)</h3>
                    <a href="{{url('/admin/application')}}" class="btn btn-outline-info btn-sm btn-icon ml-auto"><i class="fe fe-plus"></i></a>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Application Id</th>
                            <th>Applicant Id</th>
                            <th>Applicant Name</th>
                            <th>Check</th>
                            <th>Operation</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($partFList as $partF)
                            <tr>
                                <td>
                                    <a href="{{url('/admin/part_f/' . $partF['id'])}}" class="text-inherit">{{ $partF['id'] or '' }}</a>
                                </td>
                                <td>
                                    {{ $partF['application_id'] or '' }}
                                </td>
                                <td>
                                    {{ $partF['applicant_id'] or '' }}
                                </td>
                                <td>
                                    {{ $partF['applicant_name'] or '' }}
                                </td>
                                <td>
                                    @if(isset($partF['check']) && $partF['check'] == 1)
                                        <a href="javascript:void(0)" class="btn btn-outline-success btn-sm btn-icon"><i class="fe fe-check-square"></i></a>
                                    @else
                                        <a href="javascript:void(0)" class="btn btn-outline-danger btn-sm btn-icon"><i class="fe fe-alert-triangle"></i></a>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-list">
                                        <a href="{{url('/admin/part_f/' . $partF['id'])}}" class="btn btn-outline-success btn-sm btn-icon"><i class="fe fe-eye"></i></a>
                                        <a href="{{url('/admin/part_f/' . $partF['id'] . '/edit')}}" class="btn btn-outline-warning btn-sm btn-icon"><i class="fe fe-edit"></i></a>
                                        @permission('edit_application')
                                        <a href="javascript:void(0)" onclick="$('#delete{{$partF['id']}}').submit()" class="btn btn-outline-danger btn-sm btn-icon"><i class="fe fe-trash-2"></i></a>
                                        @endpermission
                                        {!! Form::open(['id' => 'delete'.$partF['id'], 'method' => 'delete', 'route' => ['part_f.destroy', $partF['id']], ]) !!}{!! Form::close() !!}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
