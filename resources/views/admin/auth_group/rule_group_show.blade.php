@extends('admin.public.master')

@section('title', '分配权限')

@section('nav', '用户组列表 > 分配权限 ')

@section('body')

    <h1 class="text-center">为<span style="color:red">{{ $group_data['title'] }}</span>分配权限</h1>
    <form action="{{ url('admin/auth_group/rule_group_update') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $group_data['id'] }}">
        <input type="hidden" name="title" value="{{ $group_data['title'] }}">
        <table class="table table-striped table-bordered table-hover table-condensed
	">
            @foreach($rule_data as $v)
                @if(empty($v['_data']))
                    <tr class="b-group">
                        <th width="10%">
                            <label>
                                {{ $v['title'] }}
                                <input type="checkbox" name="rules[]" value="{{ $v['id'] }}" @if(in_array($v['id'],$group_data['rules']))	checked="checked" @endif onclick="checkAll(this)" >
                            </label>
                        </th>
                        <td></td>
                    </tr>
                @else
                    <tr class="b-group">
                        <th width="10%">
                            <label>
                                {{ $v['title'] }} <input type="checkbox" name="rules[]" value="{{ $v['id'] }}" @if(in_array($v['id'],$group_data['rules']))	checked="checked" @endif onclick="checkAll(this)">
                            </label>
                        </th>
                        <td class="b-child">
                            @foreach($v['_data'] as $n)
                                <table class="table table-striped table-bordered table-hover table-condensed">
                                    <tr class="b-group">
                                        <th width="10%">
                                            <label>
                                                {{ $n['title'] }} <input type="checkbox" name="rules[]" value="{{ $n['id'] }}" @if(in_array($n['id'],$group_data['rules'])) checked="checked" @endif onclick="checkAll(this)">
                                            </label>
                                        </th>
                                        <td>
                                            @if(!empty($n['_data']))
                                                @foreach($n['_data'] as $c)
                                                    <label>
                                                        &emsp;{{ $c['title'] }} <input type="checkbox" name="rules[]" value="{{ $c['id'] }}" @if(in_array($c['id'],$group_data['rules']))	checked="checked" @endif >
                                                    </label>
                                                @endforeach
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            @endforeach
                        </td>
                    </tr>
                @endif
            @endforeach
            <tr>
                <th></th>
                <td>
                    <input class="btn btn-success" type="submit" value="提交">
                </td>
            </tr>
        </table>
    </form>

@endsection


@section('js')

    <script>
        function checkAll(obj){
            $(obj).parents('.b-group').eq(0).find("input[type='checkbox']").prop('checked', $(obj).prop('checked'));
        }
    </script>

@endsection