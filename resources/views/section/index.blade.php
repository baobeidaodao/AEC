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
                    <h3 class="card-title">Section</h3>
                    <div class="btn-list ml-auto">
                        <a href="{{url('/admin/section/create?exam_id=')}}{{$exam['id'] or ''}}" class="btn btn-outline-success btn-sm btn-icon ml-auto"><i class="fe fe-plus"></i></a>
                        <a href="{{url('/admin/exam')}}/{{$exam['id'] or ''}}" class="btn btn-outline-warning btn-sm btn-icon ml-auto"><i class="fe fe-x"></i></a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Exam Id</th>
                            <th>Check</th>
                            <th>Operation</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sectionList as $section)
                            <tr>
                                <td>
                                    <a href="{{url('/admin/section/' . $section['id'])}}" class="text-inherit">{{ $section['id'] or '' }}</a>
                                </td>
                                <td>
                                    {{ $section['exam_id'] or '' }}
                                </td>
                                <td>
                                    @if(isset($section['check']) && $section['check'] == 1)
                                        <a href="javascript:void(0)" class="btn btn-outline-success btn-sm btn-icon"><i class="fe fe-check-square"></i></a>
                                    @else
                                        <a href="javascript:void(0)" class="btn btn-outline-danger btn-sm btn-icon"><i class="fe fe-alert-triangle"></i></a>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-list">
                                        <a href="{{url('/admin/section/' . $section['id'])}}" class="btn btn-outline-success btn-sm btn-icon"><i class="fe fe-eye"></i></a>
                                        <a href="{{url('/admin/section/' . $section['id'] . '/edit')}}" class="btn btn-outline-warning btn-sm btn-icon"><i class="fe fe-edit"></i></a>
                                        <a href="javascript:void(0)" onclick="$('#delete{{$section['id']}}').submit()" class="btn btn-outline-danger btn-sm btn-icon"><i class="fe fe-trash-2"></i></a>
                                        {!! Form::open(['id' => 'delete'.$section['id'], 'method' => 'delete', 'route' => ['section.destroy', $section['id']], ]) !!}{!! Form::close() !!}
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
