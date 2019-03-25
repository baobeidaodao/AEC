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
                    <h3 class="card-title">Group</h3>
                    <div class="card-options">
                        <a href="{{url('/admin/group/create?section_id=')}}{{$section['id'] or ''}}" class="btn btn-outline-success btn-sm btn-icon"><i class="fe fe-plus"></i></a>
                        <a href="{{url('/admin/section')}}/{{$section['id'] or ''}}" class="btn btn-outline-warning btn-sm btn-icon  ml-2"><i class="fe fe-x"></i></a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Section Id</th>
                            <th>Exam Time</th>
                            <th>Check</th>
                            <th>Operation</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($groupList as $group)
                            <tr>
                                <td>
                                    <a href="{{url('/admin/group/' . $group['id'])}}" class="text-inherit">{{ $group['id'] or '' }}</a>
                                </td>
                                <td>
                                    {{ $group['section_id'] or '' }}
                                </td>
                                <td>
                                    {{ $group['exam_time'] or '' }}
                                </td>
                                <td>
                                    @if(isset($group['check']) && $group['check'] == 1)
                                        <a href="javascript:void(0)" class="btn btn-outline-success btn-sm btn-icon"><i class="fe fe-check-square"></i></a>
                                    @else
                                        <a href="javascript:void(0)" class="btn btn-outline-danger btn-sm btn-icon"><i class="fe fe-alert-triangle"></i></a>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-list">
                                        <a href="{{url('/admin/group/' . $group['id'])}}" class="btn btn-outline-success btn-sm btn-icon"><i class="fe fe-eye"></i></a>
                                        <a href="{{url('/admin/group/' . $group['id'] . '/edit')}}" class="btn btn-outline-warning btn-sm btn-icon"><i class="fe fe-edit"></i></a>
                                        @permission('edit_application')
                                        <a href="javascript:void(0)" onclick="$('#delete{{$group['id']}}').submit()" class="btn btn-outline-danger btn-sm btn-icon"><i class="fe fe-trash-2"></i></a>
                                        @endpermission
                                        {!! Form::open(['id' => 'delete'.$group['id'], 'method' => 'delete', 'route' => ['group.destroy', $group['id']], ]) !!}{!! Form::close() !!}
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
