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
    <div class="row row-cards row-deck">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List</h3>
                    <a href="{{url('/admin/teacher/create')}}" class="btn btn-outline-info btn-sm btn-icon ml-auto"><i class="fe fe-plus"></i></a>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Membership ID</th>
                            <th>Given Name</th>
                            <th>Family Name</th>
                            <th>Operation</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($teacherList as $teacher)
                            <tr>
                                <td>
                                    <span class="text-muted">{{ $teacher['id'] or '' }}</span>
                                </td>
                                <td>
                                    <a href="{{url('/admin/teacher/' . $teacher['id'])}}" class="text-inherit">{{ $teacher['membership_id'] or '' }}</a>
                                </td>
                                <td>
                                    {{ $teacher['given_name'] or '' }}
                                </td>
                                <td>
                                    {{ $teacher['family_name'] or '' }}
                                </td>
                                <td>
                                    <div class="btn-list">
                                        <a href="{{url('/admin/teacher/' . $teacher['id'])}}" class="btn btn-outline-success btn-sm btn-icon"><i class="fe fe-eye"></i></a>
                                        <a href="{{url('/admin/teacher/' . $teacher['id'] . '/edit')}}" class="btn btn-outline-warning btn-sm btn-icon"><i class="fe fe-edit"></i></a>
                                        <a href="javascript:void(0)" onclick="$('#delete{{$teacher['id']}}').submit()" class="btn btn-outline-danger btn-sm btn-icon"><i class="fe fe-trash-2"></i></a>
                                        {!! Form::open(['id' => 'delete'.$teacher['id'], 'method' => 'delete', 'route' => ['teacher.destroy', $teacher['id']], ]) !!}{!! Form::close() !!}
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
