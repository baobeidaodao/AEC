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
                    <h3 class="card-title">Part D (Applicant Details)</h3>
                    <a href="{{url('/admin/application')}}" class="btn btn-outline-info btn-sm btn-icon ml-auto"><i class="fe fe-plus"></i></a>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Application Id</th>
                            <th>Applicant Name</th>
                            <th>Membership ID</th>
                            <th>Identity</th>
                            {{--<th>Address 1</th>--}}
                            {{--<th>Address 2</th>--}}
                            {{--<th>Address 3</th>--}}
                            <th>Post Code</th>
                            <th>Tel</th>
                            <th>Fax</th>
                            <th>Email</th>
                            <th>Delivery Date</th>
                            {{--<th>Neighbour</th>--}}
                            <th>Check</th>
                            <th>Operation</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($partDList as $partD)
                            <tr>
                                <td>
                                    <a href="{{url('/admin/part_d/' . $partD['id'])}}" class="text-inherit">{{ $partD['id'] or '' }}</a>
                                </td>
                                <td>
                                    {{ $partD['application_id'] or '' }}
                                </td>
                                <td>
                                    <a href="{{url('/admin/applicant/' . $partD['applicant']['id'])}}" class="text-inherit">{{ $partD['applicant']['name'] or '' }}</a>
                                </td>
                                <td>
                                    {{ $applicant['membership_id'] or '' }}
                                </td>
                                <td>
                                    {{ $applicant['identity']['name'] or '' }}
                                </td>
                                {{--<td>--}}
                                {{--{{ $applicant['address_1'] or '' }}--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                {{--{{ $applicant['address_2'] or '' }}--}}
                                {{--</td>--}}
                                {{--<td>--}}
                                {{--{{ $applicant['address_3'] or '' }}--}}
                                {{--</td>--}}
                                <td>
                                    {{ $applicant['post_code'] or '' }}
                                </td>
                                <td>
                                    {{ $applicant['tel'] or '' }}
                                </td>
                                <td>
                                    {{ $applicant['fax'] or '' }}
                                </td>
                                <td>
                                    {{ $applicant['email'] or '' }}
                                </td>
                                <td>
                                    {{ $applicant['delivery_date'] or '' }}
                                </td>
                                {{--<td>--}}
                                {{--@if($applicant['neighbour']==1)--}}
                                {{--Yes--}}
                                {{--@else--}}
                                {{--No--}}
                                {{--@endif--}}
                                {{--</td>--}}
                                <td>
                                    @if(isset($partD['check']) && $partD['check'] == 1)
                                        <a href="javascript:void(0)" class="btn btn-outline-success btn-sm btn-icon"><i class="fe fe-check-square"></i></a>
                                    @else
                                        <a href="javascript:void(0)" class="btn btn-outline-danger btn-sm btn-icon"><i class="fe fe-alert-triangle"></i></a>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-list">
                                        <a href="{{url('/admin/part_d/' . $partD['id'])}}" class="btn btn-outline-success btn-sm btn-icon"><i class="fe fe-eye"></i></a>
                                        <a href="{{url('/admin/part_d/' . $partD['id'] . '/edit')}}" class="btn btn-outline-warning btn-sm btn-icon"><i class="fe fe-edit"></i></a>
                                        <a href="javascript:void(0)" onclick="$('#delete{{$partD['id']}}').submit()" class="btn btn-outline-danger btn-sm btn-icon"><i class="fe fe-trash-2"></i></a>
                                        {!! Form::open(['id' => 'delete'.$partD['id'], 'method' => 'delete', 'route' => ['part_d.destroy', $partD['id']], ]) !!}{!! Form::close() !!}
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
