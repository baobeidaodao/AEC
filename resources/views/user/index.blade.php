<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-11-21
 * Time: 16:36
 */
?>

@extends('tabler')

@section('container')
    <div class="row row-cards row-deck">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List</h3>
                    <a href="{{url('/admin/user/create')}}" class="btn btn-outline-info btn-sm btn-icon ml-auto"><i class="fe fe-user-plus"></i></a>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Operation</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($userList as $user)
                            <tr>
                                <td>
                                    <span class="text-muted">{{ $user['id'] or '' }}</span>
                                </td>
                                <td>
                                    <a href="{{url('/admin/user/' . $user['id'])}}" class="text-inherit">{{ $user['name'] or '' }}</a>
                                </td>
                                <td>
                                    {{ $user['email'] or '' }}
                                </td>
                                <td>
                                    {{ $user['phone'] or '' }}
                                </td>
                                <td>
                                    <div class="btn-list">
                                        <a href="{{url('/admin/user/' . $user['id'])}}" class="btn btn-outline-success btn-sm btn-icon"><i class="fe fe-eye"></i></a>
                                        <a href="{{url('/admin/user/' . $user['id'] . '/edit')}}" class="btn btn-outline-warning btn-sm btn-icon"><i class="fe fe-edit"></i></a>
                                        @if($user['name']!='admin')
                                            <a href="javascript:void(0)" onclick="$('#delete{{$user['id']}}').submit()" class="btn btn-outline-danger btn-sm btn-icon"><i class="fe fe-trash-2"></i></a>
                                            {!! Form::open(['id' => 'delete'.$user['id'], 'method' => 'delete', 'route' => ['user.destroy', $user['id']], ]) !!}{!! Form::close() !!}
                                        @endif
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
