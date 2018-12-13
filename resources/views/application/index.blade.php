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
    <div class="card">
        <div class="card-body">
            <a href="{{url('/admin/application/')}}" class="btn btn-sm @if(isset($nav) && $nav=='application') btn-info @else btn-outline-info @endif">Application</a>
        </div>
    </div>
    <div class="row row-cards row-deck">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List</h3>
                    <a href="{{url('/admin/application/create')}}" class="btn btn-outline-info btn-sm btn-icon ml-auto"><i class="fe fe-plus"></i></a>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>AEC</th>
                            <th>Create User</th>
                            <th>Create Time</th>
                            <th>Part</th>
                            <th>Check</th>
                            <th>Operation</th>
                            @permission('admin')
                            <th>Export</th>
                            @endpermission
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($applicationList as $application)
                            <tr>
                                <td>
                                    <a href="{{url('/admin/application/' . $application['id'])}}" class="text-inherit">{{ $application['id'] or '' }}</a>
                                </td>
                                <td>
                                    {{ $application['aec']['year'] or '' }}
                                </td>
                                <td>
                                    {{ $application['user']['name'] or '' }}
                                </td>
                                <td>
                                    {{ $application['created_at'] or '' }}
                                </td>
                                <td>
                                    <div class="btn-list text-center">
                                        @if(isset($application['part_a']) && !empty($application['part_a']) && isset($application['part_a']['id']) && !empty($application['part_a']['id']))
                                            <a href="{{url('/admin/part_a/' . $application['part_a']['id'] . '/edit')}}"
                                               class="btn @if(isset($application['part_a']['check']) && $application['part_a']['check'] == 1) btn-outline-success @else btn-outline-danger @endif btn-sm">A</a>
                                        @else
                                            <a href="{{url('/admin/part_a/create?application_id=' . $application['id'])}}" class="btn btn-outline-info btn-sm">A</a>
                                        @endif
                                        @if(isset($application['part_b']) && !empty($application['part_b']) && isset($application['part_b']['id']) && !empty($application['part_b']['id']))
                                            <a href="{{url('/admin/part_b/' . $application['part_b']['id'] . '/edit')}}"
                                               class="btn @if(isset($application['part_b']['check']) && $application['part_b']['check'] == 1) btn-outline-success @else btn-outline-danger @endif btn-sm">B</a>
                                        @else
                                            <a href="{{url('/admin/part_b/create?application_id=' . $application['id'])}}" class="btn btn-outline-info btn-sm">B</a>
                                        @endif
                                        @if(isset($application['part_c']) && !empty($application['part_c']) && isset($application['part_c']['id']) && !empty($application['part_c']['id']))
                                            <a href="{{url('/admin/part_c/' . $application['part_c']['id'] . '/edit')}}"
                                               class="btn @if(isset($application['part_c']['check']) && $application['part_c']['check'] == 1) btn-outline-success @else btn-outline-danger @endif btn-sm">C</a>
                                        @else
                                            <a href="{{url('/admin/part_c/create?application_id=' . $application['id'])}}" class="btn btn-outline-info btn-sm">C</a>
                                        @endif
                                        @if(isset($application['part_d']) && !empty($application['part_d']) && isset($application['part_d']['id']) && !empty($application['part_d']['id']))
                                            <a href="{{url('/admin/part_d/' . $application['part_d']['id'] . '/edit')}}"
                                               class="btn @if(isset($application['part_d']['check']) && $application['part_d']['check'] == 1) btn-outline-success @else btn-outline-danger @endif btn-sm">D</a>
                                        @else
                                            <a href="{{url('/admin/part_d/create?application_id=' . $application['id'])}}" class="btn btn-outline-info btn-sm">D</a>
                                        @endif
                                        @if(isset($application['part_e']) && !empty($application['part_e']) && isset($application['part_e']['id']) && !empty($application['part_e']['id']))
                                            <a href="{{url('/admin/part_e/' . $application['part_e']['id'] . '/edit')}}"
                                               class="btn @if(isset($application['part_e']['check']) && $application['part_e']['check'] == 1) btn-outline-success @else btn-outline-danger @endif btn-sm">E</a>
                                        @else
                                            <a href="{{url('/admin/part_e/create?application_id=' . $application['id'])}}" class="btn btn-outline-info btn-sm">E</a>
                                        @endif
                                        @if(isset($application['part_f']) && !empty($application['part_f']) && isset($application['part_f']['id']) && !empty($application['part_f']['id']))
                                            <a href="{{url('/admin/part_f/' . $application['part_f']['id'] . '/edit')}}"
                                               class="btn @if(isset($application['part_f']['check']) && $application['part_f']['check'] == 1) btn-outline-success @else btn-outline-danger @endif btn-sm">F</a>
                                        @else
                                            <a href="{{url('/admin/part_f/create?application_id=' . $application['id'])}}" class="btn btn-outline-info btn-sm">F</a>
                                        @endif
                                        @if(isset($application['exam']) && !empty($application['exam']) && isset($application['exam']['id']) && !empty($application['exam']['id']))
                                            <a href="{{url('/admin/exam/' . $application['exam']['id'])}}"
                                               class="btn @if(isset($application['exam']['check']) && $application['exam']['check'] == 1) btn-outline-success @else btn-outline-danger @endif btn-sm">AEC2</a>
                                        @else
                                            <a href="{{url('/admin/exam/create?application_id=' . $application['id'])}}" class="btn btn-outline-info btn-sm">AEC2</a>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if(isset($application['check']) && $application['check'] == 1)
                                        <a href="javascript:void(0)" class="btn btn-outline-success btn-sm btn-icon"><i class="fe fe-check-square"></i></a>
                                    @else
                                        <a href="javascript:void(0)" class="btn btn-outline-danger btn-sm btn-icon"><i class="fe fe-alert-triangle"></i></a>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-list text-center">
                                        <a href="{{url('/admin/application/' . $application['id'])}}" class="btn btn-outline-success btn-sm btn-icon"><i class="fe fe-eye"></i></a>
                                        <a href="{{url('/admin/application/' . $application['id'] . '/edit')}}" class="btn btn-outline-warning btn-sm btn-icon"><i class="fe fe-edit"></i></a>
                                        <a href="javascript:void(0)" onclick="$('#delete{{$application['id']}}').submit()" class="btn btn-outline-danger btn-sm btn-icon"><i class="fe fe-trash-2"></i></a>
                                        {!! Form::open(['id' => 'delete'.$application['id'], 'method' => 'delete', 'route' => ['application.destroy', $application['id']], ]) !!}{!! Form::close() !!}
                                    </div>
                                </td>
                                @permission('admin')
                                <td>
                                    @if(isset($application['check']) && $application['check'] == 1)
                                        <a href="{{url('/admin/export/' . $application['id'])}}" class="btn btn-outline-success btn-sm btn-icon"><i class="fe fe-download"></i></a>
                                    @else
                                        <a href="javascript:void(0)" class="btn btn-outline-dark btn-sm btn-icon"><i class="fe fe-download"></i></a>
                                    @endif
                                </td>
                                @endpermission
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
