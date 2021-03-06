<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-11-28
 * Time: 16:22
 */
?>

@if(isset($exam['section_list']) && !empty($exam['section_list']) && is_array($exam['section_list']))
    @foreach($exam['section_list'] as $section)
        <div class="card">
            <div class="card-header">
                <div class="card-title"><a href="{{url('/admin/section/')}}/{{$section['id'] or ''}}" class="btn btn-outline-success btn-sm btn-icon ml-auto">考试日 Section {{$section['number'] or ''}}</a></div>
                <div class="btn-list ml-auto">
                    @if($full)
                        <a href="javascript:void(0);" class="btn btn-outline-dark btn-sm btn-icon ml-auto"><i class="fe fe-plus"></i>申请已达上限</a>
                    @else
                        <a href="{{url('/admin/group/create?section_id=')}}{{$section['id'] or ''}}" class="btn btn-outline-info btn-sm btn-icon ml-auto"><i class="fe fe-plus"></i>添加组 Group</a>
                    @endif
                    <a href="{{url('/admin/section/' . $section['id'])}}" class="btn btn-outline-success btn-sm btn-icon ml-auto" hidden><i class="fe fe-eye"></i></a>
                    <a href="{{url('/admin/section/' . $section['id'] . '/edit')}}" class="btn btn-outline-warning btn-sm btn-icon ml-auto"><i class="fe fe-edit"></i>修改考试日 Section {{$section['number'] or ''}}</a>
                    @permission('edit_application')
                    <a href="javascript:void(0)" onclick="$('#deleteSection{{$section['id']}}').submit()" class="btn btn-outline-danger btn-sm btn-icon ml-auto"><i class="fe fe-trash-2"></i>删除考试日 Section {{$section['number'] or ''}}</a>
                    @endpermission
                    {!! Form::open(['id' => 'deleteSection'.$section['id'], 'method' => 'delete', 'route' => ['section.destroy', $section['id']], ]) !!}{!! Form::close() !!}
                </div>
            </div>
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap">
                    <thead>
                    <tr>
                        <th>Office</th>
                        <th>Level Code</th>
                        <th>Exam Type</th>
                        <th>Number</th>
                        <th>Candidate ID</th>
                        <th>Given Name</th>
                        <th>Family Name</th>
                        <th>Date of Birth</th>
                        <th>M/F</th>
                        <th>Teacher</th>
                        <th>Operation</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($section['group_list']) && !empty($section['group_list']) && is_array($section['group_list']))
                        @foreach($section['group_list'] as $group)
                            <tr>
                                <td>
                                    <a href="{{url('/admin/group')}}/{{$group['id'] or ''}}" class="btn btn-outline-success btn-sm btn-icon">组 Group {{$group['number'] or ''}}</a>{{--{{date('Hi', strtotime($group['exam_time']))}}--}}
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    @if($full)
                                        <a href="javascript:void(0);" class="btn btn-outline-dark btn-sm btn-icon ml-auto"><i class="fe fe-plus"></i>申请已达上限</a>
                                    @else
                                        @if(count($group['item_list']) < \App\Models\Group::limit($group['id']) && \App\Models\Group::limit($group['id']) > 0)
                                            <a href="{{url('/admin/item/create?group_id=')}}{{$group['id'] or ''}}"
                                               class="btn btn-outline-info btn-sm btn-icon ml-auto"><i
                                                        class="fe fe-plus"></i>添加考生</a>
                                        @endif
                                    @endif
                                    <a href="{{url('/admin/group/' . $group['id'])}}" class="btn btn-outline-success btn-sm btn-icon ml-auto" hidden><i class="fe fe-eye"></i></a>
                                    <a href="{{url('/admin/group/' . $group['id'] . '/edit')}}" class="btn btn-outline-warning btn-sm btn-icon ml-auto"><i class="fe fe-edit"></i></a>
                                    @permission('edit_application')
                                    <a href="javascript:void(0)" onclick="$('#deleteGroup{{$group['id']}}').submit()" class="btn btn-outline-danger btn-sm btn-icon ml-auto"><i class="fe fe-trash-2"></i></a>
                                    @endpermission
                                    {!! Form::open(['id' => 'deleteGroup'.$group['id'], 'method' => 'delete', 'route' => ['group.destroy', $group['id']], ]) !!}{!! Form::close() !!}
                                </td>
                            </tr>
                            @if(isset($group['item_list']) && !empty($group['item_list']) && is_array($group['item_list']))
                                @foreach($group['item_list'] as $item)
                                    <tr>
                                        <td>@if($loop->iteration==1){{date('Hi', strtotime($group['exam_time']))}}@endif</td>
                                        <td>{{$group['level']['code'] or ''}}</td>
                                        <td>{{$group['exam_type']['code'] or ''}}</td>
                                        <td>{{$item['number'] or ''}}</td>
                                        <td>{{$item['student']['number'] or ''}}</td>
                                        <td>{{$item['student']['given_name'] or ''}}</td>
                                        <td>{{$item['student']['family_name'] or ''}}</td>
                                        <td>{{date('d/m/Y', strtotime($item['student']['birth_date']))}}</td>
                                        <td>@if($item['student']['sex'] == 1) M @else F @endif</td>
                                        <td>
                                            @foreach($item['item_part_c_teacher_list'] as $itemPartCTeacher)
                                                {{$itemPartCTeacher['part_c_teacher']['number'] or ''}} |
                                            @endforeach
                                        </td>
                                        <td>
                                            @if(isset($item['check']) && $item['check'] == 1)
                                                <a href="javascript:void(0)" class="btn btn-outline-success btn-sm btn-icon"><i class="fe fe-check-square"></i></a>
                                            @else
                                                <a href="javascript:void(0)" class="btn btn-outline-danger btn-sm btn-icon"><i class="fe fe-alert-triangle"></i></a>
                                            @endif
                                            <a href="{{url('/admin/item/' . $item['id'])}}" class="btn btn-outline-success btn-sm btn-icon ml-auto" hidden><i class="fe fe-eye"></i></a>
                                            <a href="{{url('/admin/item/' . $item['id'] . '/edit')}}" class="btn btn-outline-warning btn-sm btn-icon ml-auto"><i class="fe fe-edit"></i></a>
                                            @permission('edit_application')
                                            <a href="javascript:void(0)" onclick="$('#deleteItem{{$item['id']}}').submit()" class="btn btn-outline-danger btn-sm btn-icon ml-auto"><i class="fe fe-trash-2"></i></a>
                                            @endpermission
                                            {!! Form::open(['id' => 'deleteItem'.$item['id'], 'method' => 'delete', 'route' => ['item.destroy', $item['id']], ]) !!}{!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            @if(isset($group['rest_id']) && !empty($group['rest_id']) && $group['rest_id']!=0)
                                <tr>
                                    <td>@if($group['rest']['name']!='No'){{date('Hi', strtotime('-' . intval($group['rest']['minute']) . ' minute', strtotime($group['finish_time'])))}}@endif</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>@if($group['rest']['name']!='No'){{$group['rest']['name'] or ''}}@endif</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
@endif
