<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Cookie;
use Auth;
use App\Models\loginmodel;
use App\Models\StaffModel;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    //Xử lý kiểm tra thông tin đăng nhập là chính xác hay không
    public function  check_login(Request $request){
        //Kiểm tra click submit
        if(isset($request->sbLogin)){
            //Lấy giá trị request
            $admin_user = $request->admin_user;
            $admin_password = $request->admin_password;
            $admin_save_passwword = $request->cb_savepassword;
            //Kiểm tra dữ liệu rỗng sẽ trả về trang login
            if(empty($admin_user)||empty($admin_password)){
                Session::put('message',"Mật khẩu hoặc tài khoản không đươc rỗng.");
                return Redirect::to('/admin_login');
            }
            $result=loginmodel::login($admin_user);
            if(!$result){
                Session::put('message',"Tài khoản không tồn tại.");
                return view('admin_login');
            }else{
                foreach($result as $row){
                    //Lấy dữ liệu tài khoản từ database
                    $id=$row->id;
                    $position=$row->position_id;
                    $password=$row->password;
                    $status=$row->status;
                }
                //Kiểm tra mật khẩu có đúng không
                if(password_verify($admin_password,$password)){
                    //Kiểm tra tài khoản có bị khóa không
                    if($status==1){
                        //Kiểm tra người dùng có chọn lưu mật khẩu không
                        if($admin_save_passwword==1){
                            Cookie::queue('admin_id_cookie', $id,10);//Tạo cookie
                            Cookie::queue('admin_position_cookie', $position,10);
                            return Redirect::to('/dashboard');
                        }else{
                            Session::put('admin_id', $id);//Tạo session
                            Session::put('admin_position', $position);
                            return Redirect::to('/dashboard');
                        }
                    }else{
                        Session::put('message',"Tài khoản đang bị khóa.");
                        return view('admin_login');
                    }
                }else{
                    Session::put('message',"Sai mật khẩu.");
                    return view('admin_login');
                }
            }
        }
    }

    //Xử lý phân quyền trang admin
    public function decentralization(){
        if(CheckController::check_cookie()){
            $this->login_cookie();
        }

        if(CheckController::check_session()){
            $admin_position = Session::get('admin_position');
            $id=Session::get('admin_id');
            //Tạo session quyền và thông tin cá nhân
            $this->permission($admin_position);
            $this->staff($id);
            return view('admin.dashboard');
        }else{
            return view('admin_login');
        }
    }

    //Xử lý đăng xuát khỏi trang admin
    public function logout(){
        //Kiểm tra session có thì xóa đi
        if(CheckController::check_session()) {
            Session::forget('admin_id');//Xóa session
            Session::forget('admin_position');
            Session::forget('arPermission');
            Session::forget('arStaff');
        }
        //Kiểm tra cookie có thì xóa đi
        if(CheckController::check_cookie()){
            Cookie::queue('admin_id_cookie', null,10);//Xóa cookie
            Cookie::queue('admin_position_cookie', null,10);
        }
        return view('admin_login');
    }

    //Đăng nhập tài khoản với cookie đang có
    public function login_cookie(){
        //Lấy cookie
        $admin_id_cookie = Cookie::get('admin_id_cookie');
        $admin_position_cookie = Cookie::get('admin_position_cookie');
        Session::put('admin_id', $admin_id_cookie);//Tạo session
        Session::put('admin_position', $admin_position_cookie);
    }

    //Tìm kiếm phân quyền
    public function permission($permission){
        $resultPermission = LoginModel::decentralization($permission);
        //Lấy thông tin quyền
        $arPermission= array();
        foreach ($resultPermission as $row){
            $arPermission[] = array($row->id,$row->title_name,$row->status);
        }
        Session::put('arPermission', $arPermission);//Tạo session
    }

    //Tìm kiếm thông tin
    public function staff($staff){
        //Lấy thông tin cá nhân
        $resultStaff = StaffModel::staff_information ($staff);
        foreach ($resultStaff as $row){
            $arStaff = array($row->id,$row->surname,$row->firstname,$row->dateofbirth,$row->phonenumber,$row->email,$row->status);
        }
        Session::put('arStaff', $arStaff);//Tạo session
    }
}
