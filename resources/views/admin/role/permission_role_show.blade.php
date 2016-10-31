@extends('layouts.admin')

@section('title', '分配权限')

@section('nav', '角色列表')

@section('description', '对角色的操作')

@section('content')

    <h1 class="text-center">为<span style="color:red">{{ $role['display_name'] }}</span>分配权限</h1>
    <form action="{{ url('admin/role/permission_role_update') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $role['id'] }}">
        <input type="hidden" name="display_name" value="{{ $role['display_name'] }}">
        <table class="table table-striped table-bordered table-hover">
            @foreach($permission as $v)
                @if(empty($v['_data']))
                    <tr class="b-group">
                        <th width="10%">
                            <label>
                                {{ $v['display_name'] }}
                                <input type="checkbox" name="permission_ids[]" value="{{ $v['id'] }}" @if(in_array($v['id'],$has_permission_ids))	checked="checked" @endif onclick="checkAll(this)" >
                            </label>
                        </th>
                        <td></td>
                    </tr>
                @else
                    <tr class="b-group">
                        <th width="10%">
                            <label>
                                {{ $v['display_name'] }} <input type="checkbox" name="permission_ids[]" value="{{ $v['id'] }}" @if(in_array($v['id'],$has_permission_ids))	checked="checked" @endif onclick="checkAll(this)">
                            </label>
                        </th>
                        <td class="b-child">
                            @foreach($v['_data'] as $n)
                                <table class="table table-striped table-bordered table-hover">
                                    <tr class="b-group">
                                        <th width="10%">
                                            <label>
                                                {{ $n['display_name'] }} <input type="checkbox" name="permission_ids[]" value="{{ $n['id'] }}" @if(in_array($n['id'],$has_permission_ids)) checked="checked" @endif onclick="checkAll(this)">
                                            </label>
                                        </th>
                                        <td>
                                            @if(!empty($n['_data']))
                                                @foreach($n['_data'] as $c)
                                                    <label>
                                                        &emsp;{{ $c['display_name'] }} <input type="checkbox" name="permission_ids[]" value="{{ $c['id'] }}" @if(in_array($c['id'],$has_permission_ids))	checked="checked" @endif >
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