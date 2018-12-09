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
                    <h3 class="card-title">Student</h3>
                    <a href="{{url('/admin/student/create')}}" class="btn btn-outline-info btn-sm btn-icon ml-auto"><i class="fe fe-plus"></i></a>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Number</th>
                            <th>Given Name</th>
                            <th>Family Name</th>
                            <th>Birth Date</th>
                            <th>Sex</th>
                            <th>Operation</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($studentList as $student)
                            <tr>
                                <td>
                                    <span class="text-muted">{{ $student['id'] or '' }}</span>
                                </td>
                                <td>
                                    <a href="{{url('/admin/student/' . $student['id'])}}" class="text-inherit">{{ $student['number'] or '' }}</a>
                                </td>
                                <td>
                                    {{ $student['given_name'] or '' }}
                                </td>
                                <td>
                                    {{ $student['family_name'] or '' }}
                                </td>
                                <td>
                                    <?php echo date('d/m/Y', strtotime($student['birth_date']));?>
                                </td>
                                <td>
                                    @if($student['sex'] == 1) M @elseif($student['sex'] == 0) F @endif
                                </td>
                                <td>
                                    <div class="btn-list text-center">
                                        <a href="{{url('/admin/student/' . $student['id'])}}" class="btn btn-outline-success btn-sm btn-icon"><i class="fe fe-eye"></i></a>
                                        <a href="{{url('/admin/student/' . $student['id'] . '/edit')}}" class="btn btn-outline-warning btn-sm btn-icon"><i class="fe fe-edit"></i></a>
                                        <a href="javascript:void(0)" onclick="$('#delete{{$student['id']}}').submit()" class="btn btn-outline-danger btn-sm btn-icon"><i class="fe fe-trash-2"></i></a>
                                        {!! Form::open(['id' => 'delete'.$student['id'], 'method' => 'delete', 'route' => ['student.destroy', $student['id']], ]) !!}{!! Form::close() !!}
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
