<?php
/**
 * Created by PhpStorm.
 * User: DaoDao
 * Date: 2018-11-22
 * Time: 09:52
 */
?>

<input id="{{ $id or '' }}" name="{{ $name or '' }}" placeholder="{{ $placeholder or '' }}" class="form-control"
       type="text" value="{{ $datetime or $value }}" autocomplete="off" disableautocomplete>
<script>
    $(function () {
        $('#{{ $id or '' }}').datetimepicker({
            format: "{{ $format or 'yyyy-mm-dd hh:ii:ss' }}",
            weekStart: 1,
            todayBtn: 1,
            autoclose: 1,
            todayHighlight: 1,
            startView: '{{$startView or 2}}',
            minView: 2,
            forceParse: 0,
            keyboardNavigation: true,
            bootcssVer: 3,
        });
    });
</script>
