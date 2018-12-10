<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-11-28
 * Time: 07:34
 */
?>

<div class="card">
    <div class="card-body">
        @if(isset($application) && !empty($application) && isset($application['id']) && !empty($application['id']))
            <a href="{{url('/admin/application/')}}" class="btn btn-sm @if(isset($nav) && $nav=='application') btn-success @else btn-outline-success @endif">Application</a>
            <a class="btn btn-sm"><i class="fe fe-chevrons-right"></i></a>
            @if(isset($application['part_a']) && !empty($application['part_a']) && isset($application['part_a']['id']) && !empty($application['part_a']['id']))
                <a href="{{url('/admin/part_a/' . $application['part_a']['id'] . '/edit')}}"
                   class="btn btn-sm @if(isset($application['part_a']['check']) && $application['part_a']['check'] == 1) @if(isset($nav) && $nav=='part_a') btn-success @else btn-outline-success @endif @else @if(isset($nav) && $nav=='part_a') btn-danger @else btn-outline-danger @endif @endif ">Part
                    A</a>
            @else
                <a href="{{url('/admin/part_a/create?application_id=' . $application['id'])}}" class="btn btn-sm @if(isset($nav) && $nav=='part_a') btn-info @else btn-outline-info @endif ">Part A</a>
            @endif
            <a class="btn btn-sm"><i class="fe fe-chevrons-right"></i></a>
            @if(isset($application['part_b']) && !empty($application['part_b']) && isset($application['part_b']['id']) && !empty($application['part_b']['id']))
                <a href="{{url('/admin/part_b/' . $application['part_b']['id'] . '/edit')}}"
                   class="btn btn-sm @if(isset($application['part_b']['check']) && $application['part_b']['check'] == 1) @if(isset($nav) && $nav=='part_b') btn-success @else btn-outline-success @endif @else @if(isset($nav) && $nav=='part_b') btn-danger @else btn-outline-danger @endif @endif">Part
                    B</a>
            @else
                <a href="{{url('/admin/part_b/create?application_id=' . $application['id'])}}" class="btn btn-sm @if(isset($nav) && $nav=='part_b') btn-info @else btn-outline-info @endif ">Part B</a>
            @endif
            <a class="btn btn-sm"><i class="fe fe-chevrons-right"></i></a>
            @if(isset($application['part_c']) && !empty($application['part_c']) && isset($application['part_c']['id']) && !empty($application['part_c']['id']))
                <a href="{{url('/admin/part_c/' . $application['part_c']['id'] . '/edit')}}"
                   class="btn btn-sm @if(isset($application['part_c']['check']) && $application['part_c']['check'] == 1) @if(isset($nav) && $nav=='part_c') btn-success @else btn-outline-success @endif @else @if(isset($nav) && $nav=='part_c') btn-danger @else btn-outline-danger @endif @endif">Part
                    C</a>
            @else
                <a href="{{url('/admin/part_c/create?application_id=' . $application['id'])}}" class="btn btn-sm @if(isset($nav) && $nav=='part_c') btn-info @else btn-outline-info @endif ">Part C</a>
            @endif
            <a class="btn btn-sm"><i class="fe fe-chevrons-right"></i></a>
            @if(isset($application['part_d']) && !empty($application['part_d']) && isset($application['part_d']['id']) && !empty($application['part_d']['id']))
                <a href="{{url('/admin/part_d/' . $application['part_d']['id'] . '/edit')}}"
                   class="btn btn-sm @if(isset($application['part_d']['check']) && $application['part_d']['check'] == 1) @if(isset($nav) && $nav=='part_d') btn-success @else btn-outline-success @endif @else @if(isset($nav) && $nav=='part_d') btn-danger @else btn-outline-danger @endif @endif">Part
                    D</a>
            @else
                <a href="{{url('/admin/part_d/create?application_id=' . $application['id'])}}" class="btn btn-sm @if(isset($nav) && $nav=='part_d') btn-info @else btn-outline-info @endif ">Part D</a>
            @endif
            <a class="btn btn-sm"><i class="fe fe-chevrons-right"></i></a>
            @if(isset($application['part_e']) && !empty($application['part_e']) && isset($application['part_e']['id']) && !empty($application['part_e']['id']))
                <a href="{{url('/admin/part_e/' . $application['part_e']['id'] . '/edit')}}"
                   class="btn btn-sm @if(isset($application['part_e']['check']) && $application['part_e']['check'] == 1) @if(isset($nav) && $nav=='part_e') btn-success @else btn-outline-success @endif @else @if(isset($nav) && $nav=='part_e') btn-danger @else btn-outline-danger @endif @endif">Part
                    E</a>
            @else
                <a href="{{url('/admin/part_e/create?application_id=' . $application['id'])}}" class="btn btn-sm @if(isset($nav) && $nav=='part_e') btn-info @else btn-outline-info @endif ">Part E</a>
            @endif
            <a class="btn btn-sm"><i class="fe fe-chevrons-right"></i></a>
            @if(isset($application['part_f']) && !empty($application['part_f']) && isset($application['part_f']['id']) && !empty($application['part_f']['id']))
                <a href="{{url('/admin/part_f/' . $application['part_f']['id'] . '/edit')}}"
                   class="btn btn-sm @if(isset($application['part_f']['check']) && $application['part_f']['check'] == 1) @if(isset($nav) && $nav=='part_f') btn-success @else btn-outline-success @endif @else @if(isset($nav) && $nav=='part_f') btn-danger @else btn-outline-danger @endif @endif">Part
                    F</a>
            @else
                <a href="{{url('/admin/part_f/create?application_id=' . $application['id'])}}" class="btn btn-sm @if(isset($nav) && $nav=='part_f') btn-info @else btn-outline-info @endif ">Part F</a>
            @endif
        @endif

        @if(isset($application) && !empty($application) && isset($application['id']) && !empty($application['id']))
            <a class="btn btn-sm"><i class="fe fe-chevrons-right"></i></a>
            @if(isset($application['exam']) && !empty($application['exam']) && isset($application['exam']['id']) && !empty($application['exam']['id']))
                <a href="{{url('/admin/exam/' . $application['exam']['id'])}}" class="btn btn-sm @if(isset($nav) && $nav=='exam') btn-success @else btn-outline-success @endif">Exam</a>
            @elseif(isset($exam) && !empty($exam) && isset($exam['id']) && !empty($exam['id'])))
            <a href="{{url('/admin/exam/' . $exam['id'])}}" class="btn btn-sm @if(isset($nav) && $nav=='exam') btn-success @else btn-outline-success @endif">Exam</a>
            @else
                <a href="{{url('/admin/exam/create?application_id=' . $application['id'])}}" class="btn btn-sm @if(isset($nav) && $nav=='exam') btn-info @else btn-outline-info @endif">Exam</a>
            @endif
        @endif

        @if(isset($exam) && !empty($exam) && isset($exam['id']) && !empty($exam['id']))
            <a class="btn btn-sm"><i class="fe fe-chevrons-right"></i></a>
            <a href="{{url('/admin/section/?exam_id=' . $exam['id'])}}" class="btn btn-sm @if(isset($nav) && $nav=='section') btn-warning @else btn-outline-warning @endif ">Section</a>
        @endif

        @if(isset($section) && !empty($section) && isset($section['id']) && !empty($section['id']))
            <a class="btn btn-sm"><i class="fe fe-chevrons-right"></i></a>
            <a href="{{url('/admin/group/?section_id=' . $section['id'])}}" class="btn btn-sm @if(isset($nav) && $nav=='group') btn-warning @else btn-outline-danger @endif">Group</a>
        @endif

        @if(isset($group) && !empty($group) && isset($group['id']) && !empty($group['id']))
            <a class="btn btn-sm"><i class="fe fe-chevrons-right"></i></a>
            <a href="{{url('/admin/item/?group_id=' . $group['id'])}}" class="btn btn-sm @if(isset($nav) && $nav=='item') btn-warning @else btn-outline-success @endif">Item</a>
        @endif
    </div>
</div>
