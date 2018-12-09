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

            @if(isset($examList) && !empty($examList) && is_array($examList))
                @foreach($examList as $exam)
                    @include('exam.table', ['exam' => $exam])
                @endforeach
            @endif

        </div>
    </div>
@endsection
