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
                    <h3 class="card-title">Item</h3>
                    <div class="card-options">
                        <a href="{{url('/admin/item/create?group_id=')}}{{$group['id'] or ''}}" class="btn btn-outline-success btn-sm btn-icon"><i class="fe fe-plus"></i></a>
                        <a href="{{url('/admin/group')}}/{{$group['id'] or ''}}" class="btn btn-outline-warning btn-sm btn-icon  ml-2"><i class="fe fe-x"></i></a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            {{--<th>Group Id</th>--}}
                            <th>Group Number</th>
                            <th>Number</th>
                            {{--<th>Student ID</th>--}}
                            <th>Student Number</th>
                            {{--<th>Student Given Name</th>--}}
                            {{--<th>Student Family Name</th>--}}
                            {{--<th>Student Birth Date</th>--}}
                            {{--<th>Student Sex</th>--}}
                            <th>Check</th>
                            <th>Operation</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($itemList as $item)
                            <tr>
                                <td>
                                    <a href="{{url('/admin/item/' . $item['id'])}}" class="text-inherit">{{ $item['id'] or '' }}</a>
                                </td>
                                {{--<td>--}}
                                {{--{{ $item['group']['id'] or '' }}--}}
                                {{--</td>--}}
                                <td>
                                    <?php echo date('Hi', strtotime($item['group']['exam_time'])); ?>
                                </td>
                                <td>
                                    {{ $item['number'] or '' }}
                                </td>
                                {{--<td>--}}
                                {{--{{ $item['student']['id'] or '' }}--}}
                                {{--</td>--}}
                                <td>
                                    {{ $item['student']['number'] or '' }}
                                </td>
                                {{--<td>--}}
                                {{--{{ $item['student']['given_name'] or '' }}--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                {{--{{ $item['student']['family_name'] or '' }}--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                {{--{{ $item['student']['birth_date'] or '' }}--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                {{--{{ $item['student']['sex'] or '' }}--}}
                                {{--</td>--}}
                                <td>
                                    @if(isset($item['check']) && $item['check'] == 1)
                                        <a href="javascript:void(0)" class="btn btn-outline-success btn-sm btn-icon"><i class="fe fe-check-square"></i></a>
                                    @else
                                        <a href="javascript:void(0)" class="btn btn-outline-danger btn-sm btn-icon"><i class="fe fe-alert-triangle"></i></a>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-list text-center">
                                        <a href="{{url('/admin/item/' . $item['id'])}}" class="btn btn-outline-success btn-sm btn-icon"><i class="fe fe-eye"></i></a>
                                        <a href="{{url('/admin/item/' . $item['id'] . '/edit')}}" class="btn btn-outline-warning btn-sm btn-icon"><i class="fe fe-edit"></i></a>
                                        <a href="javascript:void(0)" onclick="$('#delete{{$item['id']}}').submit()" class="btn btn-outline-danger btn-sm btn-icon"><i class="fe fe-trash-2"></i></a>
                                        {!! Form::open(['id' => 'delete'.$item['id'], 'method' => 'delete', 'route' => ['item.destroy', $item['id']], ]) !!}{!! Form::close() !!}
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
