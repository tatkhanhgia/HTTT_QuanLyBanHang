@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <a href="{{URL::to('pages/7/add')}}"><button type="submit" class="btn btn-warning" id="add_position"><i class="fas fa-plus-circle"></i>Tạo hóa đơn</button></a>
</div>
{{--------------------------------------------------------------------------------------------------------------------}}
{{--Quản lý hóa đơn bán--}}
<div class="table-agile-info" style="margin-top: 10px">
    <div class="panel panel-default">
        <div class="panel-heading">
            Hóa đơn bán hàng
        </div>
        <div class="panel-body">
            <table id="table_account_manage" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Mã hóa đơn</th>
                        <th>Mã nhân viên</th>
                        <th>Tổng tiền</th>                        
                        <th>Ngày</th>                        
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($arrayMate as $arraycolumn)
                    <tr>
                        <td>{{$arraycolumn[0]}}</td>
                        <td><span class="text-ellipsis">{{$arraycolumn[1]}}</span></td>
                        <td><span class="text-ellipsis">{{$arraycolumn[2]}}</span></td>  
                        <td><span class="text-ellipsis">{{$arraycolumn[3]}}</span></td>  
                        <!-- <td><span class="text-ellipsis">{{$arraycolumn[4]}}</span></td>                                                                    -->
                        @if($arraycolumn[4]==1)
                            <td><span class="text-ellipsis" style="color: green;">Còn hàng</span></td>
                        @elseif($arraycolumn[4]==0)
                            <td><span class="text-ellipsis" style="color: red;">Hết hàng</span></td>                       
                        @endif                        
                        <td>
                            @if($arraycolumn[4]==1)
                                <form method="post" action="{{URL::to('pages/7/hidden')}}">
                                    {{ csrf_field() }}
                                    <button class="btn btn-danger btn-sm" style="font-size: 17px; margin-top: 5px; width: 40px;height: 40px" title="Khóa hàng" name="id" value="{{$arraycolumn[0]}}" id="id" type="submit"><i class="fas fa-box" ></i></button>
                                </form>
                                <form method="post" action="{{URL::to('pages/7/detail')}}">
                                    {{ csrf_field() }}
                                    <button class="btn btn-info btn-sm" style="font-size: 17px; margin-top: 5px; width: 40px;height: 40px" title="Thay đổi thông tin" name="receipt_detail_id" value="{{$arraycolumn[0]}}" id="receipt_detail_id" type="submit"><i class="fas fa-cog" ></i></button>
                             </form>
                            @elseif($arraycolumn[4]==0)
                                <form method="post" action="{{URL::to('pages/7/unhidden')}}">
                                    {{ csrf_field() }}
                                    <button class="btn btn-danger btn-sm" style="font-size: 14px; margin-top: 5px; width: 40px;height: 40px" title="Mở hàng" name="id" value="{{$arraycolumn[0]}}" id="id" type="submit"><i class="fas fa-box-open" ></i></button>
                                </form>
                                <form method="post" action="{{URL::to('pages/7/detail')}}">
                                    {{ csrf_field() }}
                                    <button class="btn btn-info btn-sm" style="font-size: 17px; margin-top: 5px; width: 40px;height: 40px" title="Thay đổi thông tin" name="receipt_detail_id" value="{{$arraycolumn[0]}}" id="receipt_detail_id" type="submit"><i class="fas fa-cog" ></i></button>
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
