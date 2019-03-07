<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2019-03-07
 * Time: 09:46
 */
$show = isset($show) ? $show : 3;
$page = (isset($page) && $page > 0) ? $page : 1;
$count = $count > 0 ? $count : 1;
?>

<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        {{-- first --}}
        <li class="page-item">
            <a class="page-link" href="{{ $url . 1 }}" data-page="1"><<</a>
        </li>
        {{-- prev --}}
        @if( $page == 1)
            <li class="page-item">
                <a class="page-link" href="{{ $url . $page }}" data-page="{{ $page or 0 }}"><</a>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $url . ($page - 1) }}" data-page="{{ ($page - 1) }}"><</a>
            </li>
        @endif
        {{-- min--}}
        @if($page - $show -1 > 0)
            <li class="page-item">
                <a class="page-link" href="{{ $url . 1}}" data-page="{{ 1 }}">1</a>
            </li>
        @endif
        {{-- earlier --}}
        @if($page - $show  -1 > 1 )
            <li class="page-item">
                <a class="page-link">...</a>
            </li>
        @endif
        {{-- before--}}
        @for ($i = $show; $i > 0; $i--)
            @if($page -$i > 0)
                <li class="page-item">
                    <a class="page-link" href="{{ $url . ($page - $i) }}" data-page="{{ ($page - $i) }}">{{ ($page - $i) }}</a>
                </li>
            @endif
        @endfor
        {{-- current --}}
        <li class="page-item active">
            <a class="page-link" href="{{ $url . $page }}" class="ahover" data-page="{{ $page }}">{{ $page }}</a>
        </li>
        {{-- after --}}
        @for ($i = 1; $i <= $show && $page + $i <= $count; $i++)
            <li class="page-item">
                <a class="page-link" href="{{$url . ($page + $i) }}" data-page="{{ ($page + $i) }}">{{ ($page + $i) }}</a>
            </li>
        @endfor
        {{-- later --}}
        @if($count - ($page + $show) > 1)
            <li class="page-item">
                <a class="page-link">...</a>
            </li>
        @endif
        {{-- max --}}
        @if($count - ($page + $show) > 0)
            <li class="page-item">
                <a class="page-link" href="{{ $url . $count }}" data-page="{{ $count }}">{{ $count }}</a>
            </li>
        @endif
        {{-- next --}}
        @if($page == $count)
            <li class="page-item">
                <a class="page-link" href="{{$url . $page }}" data-page="{{ $page }}">></a>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $url . ($page + 1)}}" data-page="{{ ($page + 1) }}">></a>
            </li>
        @endif
        {{-- last --}}
        <li class="page-item">
            <a class="page-link" href="{{ $url . $count }}" data-page="{{ $count }}">>></a>
        </li>
    </ul>
</nav>