<?php

namespace App\Http\Controllers;

use Session;
use Cookie;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    //Xử lý hiện giao điện quản lý quyền
    public function permission_management()
    {
        if(CheckController::check_session()) {
            return view('admin.permission_management');
//                ->with('arAccountManage', $this->account_manage())
//                ->with('arAccountCustomer', $this->account_customer());
        }else{
            return view('admin_login');
        }
    }
}