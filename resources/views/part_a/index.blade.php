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
                    <h3 class="card-title">Part A</h3>
                    <a href="{{url('/admin/application')}}" class="btn btn-outline-success btn-sm btn-icon ml-auto"><i class="fe fe-x"></i></a>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Application Id</th>
                            <th>School ID</th>
                            <th>School Name</th>
                            <th>School Code</th>
                            <th>Email</th>
                            <th>Tel</th>
                            <th>Check</th>
                            <th>Operation</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($partAList as $partA)
                            <tr>
                                <td>
                                    <a href="{{url('/admin/part_a/' . $partA['id'])}}" class="text-inherit">{{ $partA['id'] or '' }}</a>
                                </td>
                                <td>
                                    {{ $partA['application_id'] or '' }}
                                </td>
                                <td>
                                    {{ $partA['school_id'] or '' }}
                                </td>
                                <td>
                                    {{ $partA['school_name'] or '' }}
                                </td>
                                <td>
                                    {{ $partA['school_code'] or '' }}
                                </td>
                                <td>
                                    {{ $partA['email'] or '' }}
                                </td>
                                <td>
                                    {{ $partA['tel'] or '' }}
                                </td>
                                <td>
                                    @if(isset($partA['check']) && $partA['check'] == 1)
                                        <a href="javascript:void(0)" class="btn btn-outline-success btn-sm btn-icon"><i class="fe fe-check-square"></i></a>
                                    @else
                                        <a href="javascript:void(0)" class="btn btn-outline-danger btn-sm btn-icon"><i class="fe fe-alert-triangle"></i></a>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-list">
                                        <a href="{{url('/admin/part_a/' . $partA['id'])}}" class="btn btn-outline-success btn-sm btn-icon"><i class="fe fe-eye"></i></a>
                                        <a href="{{url('/admin/part_a/' . $partA['id'] . '/edit')}}" class="btn btn-outline-warning btn-sm btn-icon"><i class="fe fe-edit"></i></a>
                                        <a href="javascript:void(0)" onclick="$('#delete{{$partA['id']}}').submit()" class="btn btn-outline-danger btn-sm btn-icon"><i class="fe fe-trash-2"></i></a>
                                        {!! Form::open(['id' => 'delete'.$partA['id'], 'method' => 'delete', 'route' => ['part_a.destroy', $partA['id']], ]) !!}{!! Form::close() !!}
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
