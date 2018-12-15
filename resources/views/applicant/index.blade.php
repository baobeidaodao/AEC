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
                    <a href="{{url('/admin/applicant/create')}}" class="btn btn-outline-info btn-sm btn-icon ml-auto"><i class="fe fe-plus"></i></a>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
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
                            <th>Operation</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($applicantList as $applicant)
                            <tr>
                                <td>
                                    <span class="text-muted">{{ $applicant['id'] or '' }}</span>
                                </td>
                                <td>
                                    <a href="{{url('/admin/applicant/' . $applicant['id'])}}" class="text-inherit">{{ $applicant['name'] or '' }}</a>
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
                                    <div class="btn-list">
                                        <a href="{{url('/admin/applicant/' . $applicant['id'])}}" class="btn btn-outline-success btn-sm btn-icon"><i class="fe fe-eye"></i></a>
                                        <a href="{{url('/admin/applicant/' . $applicant['id'] . '/edit')}}" class="btn btn-outline-warning btn-sm btn-icon"><i class="fe fe-edit"></i></a>
                                        <a href="javascript:void(0)" onclick="$('#delete{{$applicant['id']}}').submit()" class="btn btn-outline-danger btn-sm btn-icon"><i class="fe fe-trash-2"></i></a>
                                        {!! Form::open(['id' => 'delete'.$applicant['id'], 'method' => 'delete', 'route' => ['applicant.destroy', $applicant['id']], ]) !!}{!! Form::close() !!}
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
