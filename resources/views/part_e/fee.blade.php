<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-12-9
 * Time: 17:05
 */
?>

<div class="row row-cards row-deck">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Fees：count: {{ $fees or 0 }} （此处数据为自动计算得出，申报人无需填写）</h3>
            </div>
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap">
                    <thead>
                    <tr>
                        <th></th>
                        @foreach($examTypeList as $examType)
                            <th>{{$examType['code'] or ''}}</th>
                            <th>Fee</th>
                            <th>Total</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($levelList as $level)
                        <tr>
                            <th>{{$level['code'] or ''}}</th>
                            @foreach($examTypeList as $examType)
                                <th>
                                    <?php $attribute = strtolower($examType['code']) . '_' . strtolower($level['code']) ?>
                                    {{$partE[$attribute] or ''}}
                                </th>
                                <th>
                                    @if(isset(\App\Models\PartE::FEE[$attribute]))
                                        {{\App\Models\PartE::FEE[$attribute]}}
                                    @endif
                                </th>
                                <th>
                                    @if(isset(\App\Models\PartE::FEE[$attribute]) && isset($partE[$attribute]))
                                        {{intval(\App\Models\PartE::FEE[$attribute]) * intval($partE[$attribute])}}
                                    @endif
                                </th>
                            @endforeach
                        </tr>
                        @if(in_array(strtolower($level), \App\Models\PartE::MEMBER_LEVEL))
                            <tr>
                                <th>{{$level['code'] . '_M'}}</th>
                                @foreach($examTypeList as $examType)
                                    <th>
                                        <?php $attribute = strtolower($examType['code']) . '_' . strtolower($level['code']) . '_m'; ?>
                                        {{$partE[$attribute] or ''}}
                                    </th>
                                    <th>
                                        @if(isset(\App\Models\PartE::FEE[$attribute]))
                                            {{\App\Models\PartE::FEE[$attribute]}}
                                        @endif
                                    </th>
                                    <th>
                                        @if(isset(\App\Models\PartE::FEE[$attribute]) && isset($partE[$attribute]))
                                            {{intval(\App\Models\PartE::FEE[$attribute]) * intval($partE[$attribute])}}
                                        @endif
                                    </th>
                                @endforeach
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
