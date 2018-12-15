<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-12-13
 * Time: 19:31
 */
?>

<div class="row row-cards row-deck">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">List</h3>
                <a href="{{url('/admin/studio/create')}}" class="btn btn-outline-info btn-sm btn-icon ml-auto"><i class="fe fe-plus"></i></a>
            </div>
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Country</th>
                        <th>Address 1</th>
                        <th>Address 2</th>
                        <th>Address 3</th>
                        <th>Post Code</th>
                        <th>Tel</th>
                        <th>Examination Day Contact Tel</th>
                        <th>Operation</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($studioList as $studio)
                        <tr>
                            <td>
                                <span class="text-muted">{{ $studio['id'] or '' }}</span>
                            </td>
                            <td>
                                <a href="{{url('/admin/studio/' . $studio['id'])}}" class="text-inherit">{{ $studio['name'] or '' }}</a>
                            </td>
                            <td>
                                {{ $studio['country']['name'] or '' }}
                            </td>
                            <td>
                                {{ $studio['address_1'] or '' }}
                            </td>
                            <td>
                                {{ $studio['address_2'] or '' }}
                            </td>
                            <td>
                                {{ $studio['address_3'] or '' }}
                            </td>
                            <td>
                                {{ $studio['post_code'] or '' }}
                            </td>
                            <td>
                                {{ $studio['tel'] or '' }}
                            </td>
                            <td>
                                {{ $studio['examination_day_contact_tel'] or '' }}
                            </td>
                            <td>
                                <div class="btn-list">
                                    <a href="{{url('/admin/studio/' . $studio['id'])}}" class="btn btn-outline-success btn-sm btn-icon"><i class="fe fe-eye"></i></a>
                                    <a href="{{url('/admin/studio/' . $studio['id'] . '/edit')}}" class="btn btn-outline-warning btn-sm btn-icon"><i class="fe fe-edit"></i></a>
                                    <a href="javascript:void(0)" onclick="$('#delete{{$studio['id']}}').submit()" class="btn btn-outline-danger btn-sm btn-icon"><i class="fe fe-trash-2"></i></a>
                                    {!! Form::open(['id' => 'delete'.$studio['id'], 'method' => 'delete', 'route' => ['studio.destroy', $studio['id']], ]) !!}{!! Form::close() !!}
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
