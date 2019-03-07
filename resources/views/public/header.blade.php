<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-11-21
 * Time: 15:52
 */
?>

<div class="header py-4">
    <div class="container">
        <div class="d-flex">
            <a class="header-brand" href="{{ url('/') }}">
                <img src="{{ url('/') . '/' }}logo.jpg" class="header-brand-img" alt="tabler logo">
            </a>
            <div class="d-flex order-lg-2 ml-auto">
                <div class="dropdown">
                    <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                        <span class="avatar"></span>
                        <span class="ml-2 d-none d-lg-block">
                            <span class="text-default">{{ Auth::user()->name }}</span>
                            <small class="text-muted d-block mt-1">Administrator</small>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="dropdown-icon fe fe-log-out"></i> Sign out
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
            <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                <span class="header-toggler-icon"></span>
            </a>
        </div>
    </div>
</div>
<div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3 ml-auto" hidden>
                <form class="input-icon my-3 my-lg-0">
                    <input type="search" class="form-control header-search" placeholder="Search&hellip;" tabindex="1">
                    <div class="input-icon-addon">
                        <i class="fe fe-search"></i>
                    </div>
                </form>
            </div>
            <div class="col-lg order-lg-first">
                <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                    @permission('navigation')
                    <li class="nav-item">
                        <a href="{{url('/index')}}" class="nav-link @if(!isset($active) || $active == 'index') active @endif"><i class="fe fe-home"></i>Index 首页</a>
                    </li>
                    @endpermission
                    {{--@permission('admin')--}}
                    <li class="nav-item">
                        <a href="{{url('/admin/user')}}" class="nav-link @if(isset($active) && $active == 'user') active @endif"><i class="fe fe-users"></i>User 用户</a>
                    </li>
                    {{--@endpermission--}}
                    @permission('navigation')
                    <li class="nav-item">
                        <a href="{{url('/admin/school')}}" class="nav-link @if(isset($active) && $active == 'school') active @endif"><i class="fe fe-book-open"></i>School 注册学校</a>
                    </li>
                    @endpermission
                    @permission('navigation')
                    <li class="nav-item" hidden>
                        <a href="{{url('/admin/studio')}}" class="nav-link @if(isset($active) && $active == 'studio') active @endif"><i class="fe fe-home"></i>Studio 考场地点</a>
                    </li>
                    @endpermission
                    @permission('navigation')
                    <li class="nav-item">
                        <a href="{{url('/admin/teacher')}}" class="nav-link @if(isset($active) && $active == 'teacher') active @endif"><i class="fe fe-users"></i>Teacher 注册教师</a>
                    </li>
                    @endpermission
                    @permission('navigation')
                    <li class="nav-item" hidden>
                        <a href="{{url('/admin/student')}}" class="nav-link @if(isset($active) && $active == 'student') active @endif"><i class="fe fe-users"></i>Student 学生</a>
                    </li>
                    @endpermission
                    @permission('navigation')
                    <li class="nav-item">
                        <a href="{{url('/admin/applicant')}}" class="nav-link @if(isset($active) && $active == 'applicant') active @endif"><i class="fe fe-users"></i>Applicant 申请人信息</a>
                    </li>
                    @endpermission
                    <li class="nav-item">
                        <a href="{{url('/admin/application')}}" class="nav-link @if(isset($active) && $active == 'application') active @endif"><i class="fe fe-grid"></i>Application 申请</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
