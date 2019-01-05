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
                    <h3 class="card-title">Part B (Examination Location Information)</h3>
                    <a href="{{url('/admin/application')}}" class="btn btn-outline-info btn-sm btn-icon ml-auto"><i class="fe fe-plus"></i></a>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Application Id</th>
                            <th>Country</th>
                            <th>Studio Name</th>
                            <th>Tel</th>
                            <th>Examination Day Contact Tel</th>
                            <th>Check</th>
                            <th>Operation</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($partBList as $partB)
                            <tr>
                                <td>
                                    <a href="{{url('/admin/part_b/' . $partB['id'])}}" class="text-inherit">{{ $partB['id'] or '' }}</a>
                                </td>
                                <td>
                                    {{ $partB['application_id'] or '' }}
                                </td>
                                <td>
                                    {{ $partB['country']['name'] or '' }}
                                </td>
                                <td>
                                    {{ $partB['studio_name'] or '' }}
                                </td>
                                <td>
                                    {{ $partB['tel'] or '' }}
                                </td>
                                <td>
                                    {{ $partB['examination_day_contact_tel'] or '' }}
                                </td>
                                <td>
                                    @if(isset($partB['check']) && $partB['check'] == 1)
                                        <a href="javascript:void(0)" class="btn btn-outline-success btn-sm btn-icon"><i class="fe fe-check-square"></i></a>
                                    @else
                                        <a href="javascript:void(0)" class="btn btn-outline-danger btn-sm btn-icon"><i class="fe fe-alert-triangle"></i></a>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-list">
                                        <a href="{{url('/admin/part_b/' . $partB['id'])}}" class="btn btn-outline-success btn-sm btn-icon"><i class="fe fe-eye"></i></a>
                                        <a href="{{url('/admin/part_b/' . $partB['id'] . '/edit')}}" class="btn btn-outline-warning btn-sm btn-icon"><i class="fe fe-edit"></i></a>
                                        <a href="javascript:void(0)" onclick="$('#delete{{$partB['id']}}').submit()" class="btn btn-outline-danger btn-sm btn-icon"><i class="fe fe-trash-2"></i></a>
                                        {!! Form::open(['id' => 'delete'.$partB['id'], 'method' => 'delete', 'route' => ['part_b.destroy', $partB['id']], ]) !!}{!! Form::close() !!}
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
