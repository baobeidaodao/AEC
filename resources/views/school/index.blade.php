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
                    <a href="{{url('/admin/school/create')}}" class="btn btn-outline-info btn-sm btn-icon ml-auto"><i class="fe fe-plus"></i></a>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Email</th>
                            <th>Tel</th>
                            <th>Operation</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($schoolList as $school)
                            <tr>
                                <td>
                                    <span class="text-muted">{{ $school['id'] or '' }}</span>
                                </td>
                                <td>
                                    <a href="{{url('/admin/school/' . $school['id'])}}" class="text-inherit">{{ $school['name'] or '' }}</a>
                                </td>
                                <td>
                                    {{ $school['code'] or '' }}
                                </td>
                                <td>
                                    {{ $school['email'] or '' }}
                                </td>
                                <td>
                                    {{ $school['tel'] or '' }}
                                </td>
                                <td>
                                    <div class="btn-list text-center">
                                        <a href="{{url('/admin/school/' . $school['id'])}}" class="btn btn-outline-success btn-sm btn-icon"><i class="fe fe-eye"></i></a>
                                        <a href="{{url('/admin/school/' . $school['id'] . '/edit')}}" class="btn btn-outline-warning btn-sm btn-icon"><i class="fe fe-edit"></i></a>
                                        <a href="javascript:void(0)" onclick="$('#delete{{$school['id']}}').submit()" class="btn btn-outline-danger btn-sm btn-icon"><i class="fe fe-trash-2"></i></a>
                                        {!! Form::open(['id' => 'delete'.$school['id'], 'method' => 'delete', 'route' => ['school.destroy', $school['id']], ]) !!}{!! Form::close() !!}
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
