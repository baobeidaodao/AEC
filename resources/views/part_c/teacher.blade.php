<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-12-7
 * Time: 18:49
 */
?>

<div class="row row-cards row-deck">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Part C Teacher</h3>
                <a href="{{url('/admin/part_c_teacher/create?application_id=' . $application['id'])}}" class="btn btn-outline-info btn-sm btn-icon  ml-auto"><i class="fe fe-plus"></i></a>
            </div>
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Number</th>
                        <th>Membership ID</th>
                        <th>Given Name</th>
                        <th>Family Name</th>
                        <th>Operation</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($partC['part_c_teacher_list'] as $partCTeacher)
                        <tr>
                            <td>
                                <a href="{{url('/admin/part_c_teacher/' . $partCTeacher['id'])}}" class="text-inherit">{{ $partCTeacher['id'] or '' }}</a>
                            </td>
                            <td>
                                {{ $partCTeacher['number'] or '' }}
                            </td>
                            <td>
                                {{ $partCTeacher['membership_id'] or '' }}
                            </td>
                            <td>
                                {{ $partCTeacher['given_name'] or '' }}
                            </td>
                            <td>
                                {{ $partCTeacher['family_name'] or '' }}
                            </td>
                            <td>
                                @if(isset($partCTeacher['check']) && $partCTeacher['check'] == 1)
                                    <a href="javascript:void(0)" class="btn btn-outline-success btn-sm btn-icon"><i class="fe fe-check-square"></i></a>
                                @else
                                    <a href="javascript:void(0)" class="btn btn-outline-danger btn-sm btn-icon"><i class="fe fe-alert-triangle"></i></a>
                                @endif
                            </td>
                            <td>
                                <div class="btn-list text-center">
                                    <a href="{{url('/admin/part_c_teacher/' . $partCTeacher['id'])}}" class="btn btn-outline-success btn-sm btn-icon"><i class="fe fe-eye"></i></a>
                                    <a href="{{url('/admin/part_c_teacher/' . $partCTeacher['id'] . '/edit')}}" class="btn btn-outline-warning btn-sm btn-icon"><i class="fe fe-edit"></i></a>
                                    <a href="javascript:void(0)" onclick="$('#delete{{$partCTeacher['id']}}').submit()" class="btn btn-outline-danger btn-sm btn-icon"><i class="fe fe-trash-2"></i></a>
                                    {!! Form::open(['id' => 'delete'.$partCTeacher['id'], 'method' => 'delete', 'route' => ['part_c_teacher.destroy', $partCTeacher['id']], ]) !!}{!! Form::close() !!}
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
