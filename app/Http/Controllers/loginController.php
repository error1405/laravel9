<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class loginController extends Controller
{
    //

    function admin_index()
    {
       
            return view('admin/index');

    }
    
    function user_index()
    {

            $data = DB::table('lms_issue_book')->join('lms_book','lms_book.book_isbn_number','=','lms_issue_book.book_id')->where('lms_issue_book.user_id',session('user_id'))->orderBy('lms_issue_book.issue_book_id','desc')->get();
            $data = json_decode($data,true);

            return view('user/issue_book_details',["result_show"=>$data]);
    
    }

    function admin_login_function(Request $req)
    {

        $formdata = array();
        $message = "";

        if (empty($req->admin_email)) {
            $message .= 'Email Address is required.';
        } else {
            if (!filter_var($req->admin_email, FILTER_VALIDATE_EMAIL)) {
                $message .= 'Invalid Email Address.';
            } else {
                $formdata['admin_email'] = trim($req->admin_email);
            }
        }

        if (empty($req->admin_password)) {
            $message .= 'Password is required.';
        } else {
            $formdata['admin_password'] = $req->admin_password;
        }

        if ($message == '') {
            $result = DB::table('lms_admin')->where('admin_email', '=', $formdata['admin_email'])->get();

            if (count($result) > 0) {
                foreach ($result as $row) {
                    if ($row->admin_password == $formdata['admin_password']) {
                        session()->put("admin_id", $row->admin_email);
                        return redirect('admin/');
                    } else {
                        $message = 'Wrong Password.';
                    }
                }
            } else {
                $message = 'Wrong Email Address.';
            }
        }

        return view('/admin_login', ["Message" => $message]);

    }

    function user_login_function(Request $req){
        $formdata = array();
        $message = "";

        if (empty($req->user_email_address)) {
            $message .= '<li>Email Address is required.</li>';
        } else {
            if (!filter_var($req->user_email_address, FILTER_VALIDATE_EMAIL)) {
                $message .= '<li>Invalid Email Address.</li>';
            } else {
                $formdata['user_email_address'] = trim($req->user_email_address);
            }
        }

        if (empty($req->user_password)) {
            $message .= '<li>Password is required.</li>';
        } else {
            $formdata['user_password'] = $req->user_password;
        }

        if ($message == '') {
            $result = DB::table('lms_user')->where('user_email_address', '=', $formdata['user_email_address'])->get();

            if (count($result) > 0) {
                foreach ($result as $row) {
                    if ($row->user_password == $formdata['user_password']) {
                        session()->put("user_id", $row->user_unique_id);
                        session()->put("user_nm", $row->user_name);
                        return redirect('user/');
                    } else {
                        $message = '<li>Wrong Password.</li>';
                    }
                }
            } else {
                $message = '<li>Wrong Email Address.</li>';
            }
        }

        return view('/user_login', ["Message" => $message]);

    }

    function user_signup_function(Request $req)
    {
        $formdata = array();
        $message='';
        $success='';

        if (empty($req->user_email_address)) {
            $message .= '<li>Email Address is required</li>';
        } else {
            if (!filter_var($req->user_email_address, FILTER_VALIDATE_EMAIL)) {
                $message .= '<li>Invalid Email Address</li>';
            } else {
                $formdata['user_email_address'] = trim($req->user_email_address);
            }
        }

        if (empty($req->user_password)) {
            $message .= '<li>Password is required</li>';
        } else {
            $formdata['user_password'] = trim($req->user_password);
        }

        if (empty($req->user_name)) {
            $message .= '<li>User Name is required</li>';
        } else {
            $formdata['user_name'] = trim($req->user_name);
        }

        if (empty($req->user_address)) {
            $message .= '<li>User Address Detail is required</li>';
        } else {
            $formdata['user_address'] = trim($req->user_address);
        }

        if (empty($req->user_contact_no)) {
            $message .= '<li>User Contact Number Detail is required</li>';
        } else {
            $formdata['user_contact_no'] = trim($req->user_contact_no);
        }

        if($req->hasFile('user_profile')){
            $img_name = $req->user_profile->getClientOriginalName();
            $tmp_name = $req->user_profile;
            $fileinfo = @getimagesize($tmp_name);

            // echo $img_name,"<br/>",$tmp_name,"<br/>";

            $width = $fileinfo[0];
            $height = $fileinfo[1];

            $image_size = $req->user_profile->getSize();
            // echo $req->user_profile->getSize();

            $img_explode = explode(".", $img_name);

            $img_only_name = $img_explode[0];
            $img_only_ext = strtolower($req->user_profile->getClientOriginalExtension());
            // echo "<br/>",$img_only_ext ;
            // $img_only_ext = strtolower(end($img_explode));

            $extensions = ["jpeg", "png", "jpg"];

            if (in_array($img_only_ext, $extensions)) {
                if ($image_size <= 2000000) {
                    if ($width == $height) {

                        $new_img_name = md5($img_only_name) . '-' . rand(100000, 999999) . '-' . time() . '.' . $img_only_ext;
                        // if (move_uploaded_file($tmp_name, "upload/" . $new_img_name)) {
                        //     $formdata['user_profile'] = $new_img_name;
                        // }
                        // echo "<br/>",$new_img_name,"<br/>",public_path('upload'),$new_img_name,"<br/>";
                        if($req->user_profile->move(public_path('upload'),$new_img_name))
                        {                         
                            $formdata['user_profile'] = $new_img_name;
                        }

                    } else {
                        $message .= '<li>Image dimension should be same.</li>';
                    }
                } else {
                    $message .= '<li>Image size exceeds 2MB</li>';
                }
            } else {
                $message .= '<li>Invalid Image File</li>';
            }
        } else {
            $message .= '<li>Please Select Profile Image</li>';
        }


        if ($message == '') {

            $verify_email = DB::table('lms_user')->where('user_email_address',"=",$formdata['user_email_address'])->count();

            if($verify_email>0)
            {
                $message = '<li>Email Already Register</li>';
            }
            else
            {
                $user_unique_id = 'U' . rand(10000000, 99999999);
                $formdata['user_unique_id']=$user_unique_id;
                $formdata['user_status']='Enable';
                $formdata['user_created_on']=date('Y-m-d H:i:s');

                DB::table('lms_user')->insert($formdata);

                $success = 'Registered as ' . $formdata['user_email_address'] . '...!!!';
                
            }

        }
        return view('/user_registration',["message"=>$message,"success"=>$success]);
    }

    function log_out_function()
    {
        session()->flush();
        return redirect('/');
    }
}
