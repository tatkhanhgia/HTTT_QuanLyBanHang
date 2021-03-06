@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <a href="{{URL::to('admin/9/add')}}"><button type="submit" class="btn btn-warning" id="add_position">Thêm tài khoản mới</button></a>
</div>
{{--------------------------------------------------------------------------------------------------------------------}}
{{--Quản lý tài khoản--}}
<div class="table-agile-info" style="margin-top: 10px">
    <div class="panel panel-default">
        <div class="panel-heading">
            Quản lý tài khoản nhân viên
        </div>
        <div class="panel-body">
            <table id="table_account_manage" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Mã tài khoản</th>
                        <th>Quyền tài khoản</th>
                        <th>Tên tài khoản</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($arAccount as $arraycolumn)
                    <tr>
                        <td>{{$arraycolumn[0]}}</td>
                        <td><span class="text-ellipsis">{{$arraycolumn[1]}}</span></td>
                        <td><span class="text-ellipsis">{{$arraycolumn[2]}}</span></td>
                        <!-- Kiểm tra trạng thái tài khoản -->
                        @if($arraycolumn[4]==1)
                            <td><span class="text-ellipsis" style="color: green;">Đang hoạt động </span></td>
                        @elseif($arraycolumn[4]==0)
                            <td><span class="text-ellipsis" style="color: red;">Đang khóa</span></td>
                        @elseif($arraycolumn[4]==2)
                            <td><span class="text-ellipsis" style="color: red;">Tài khoản đang trống</span></td>
                        @endif
                        <td>
                            @if($arraycolumn[4]==1)
                                <form method="post" action="{{URL::to('admin/9/hidden')}}">
                                    {{ csrf_field() }}
                                    <button class="btn btn-danger btn-sm" style="font-size: 17px; margin-top: 5px;" title="Khóa tài khoản" name="id" value="{{$arraycolumn[0]}}" id="id" type="submit"><i class="fa fa-lock" ></i></button>
                                </form>
                            @elseif($arraycolumn[4]==0)
                                <form method="post" action="{{URL::to('admin/9/unhidden')}}">
                                    {{ csrf_field() }}
                                    <button class="btn btn-danger btn-sm" style="font-size: 14px; margin-top: 5px;" title="Mở tài khoản" name="id" value="{{$arraycolumn[0]}}" id="id" type="submit"><i class="fa fa-unlock" ></i></button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
