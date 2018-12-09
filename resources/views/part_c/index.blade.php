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
                    <h3 class="card-title">Part C</h3>
                    <a href="{{url('/admin/application')}}/{{$application['id'] or ''}}" class="btn btn-outline-info btn-sm btn-icon ml-auto"><i class="fe fe-plus"></i></a>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Application Id</th>
                            <th>Check</th>
                            <th>Operation</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($partCList as $partC)
                            <tr>
                                <td>
                                    <a href="{{url('/admin/part_c/' . $partC['id'])}}" class="text-inherit">{{ $partC['id'] or '' }}</a>
                                </td>
                                <td>
                                    {{ $partC['application_id'] or '' }}
                                </td>
                                <td>
                                    @if(isset($partC['check']) && $partC['check'] == 1)
                                        <a href="javascript:void(0)" class="btn btn-outline-success btn-sm btn-icon"><i class="fe fe-check-square"></i></a>
                                    @else
                                        <a href="javascript:void(0)" class="btn btn-outline-danger btn-sm btn-icon"><i class="fe fe-alert-triangle"></i></a>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-list text-center">
                                        <a href="{{url('/admin/part_c/' . $partC['id'])}}" class="btn btn-outline-success btn-sm btn-icon"><i class="fe fe-eye"></i></a>
                                        <a href="{{url('/admin/part_c/' . $partC['id'] . '/edit')}}" class="btn btn-outline-warning btn-sm btn-icon"><i class="fe fe-edit"></i></a>
                                        <a href="javascript:void(0)" onclick="$('#delete{{$partC['id']}}').submit()" class="btn btn-outline-danger btn-sm btn-icon"><i class="fe fe-trash-2"></i></a>
                                        {!! Form::open(['id' => 'delete'.$partC['id'], 'method' => 'delete', 'route' => ['part_c.destroy', $partC['id']], ]) !!}{!! Form::close() !!}
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
