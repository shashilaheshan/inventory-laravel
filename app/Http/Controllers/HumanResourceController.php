<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HumanResource;
use App\Salary_list;
use App\User;

class HumanResourceController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('storestatus');
    $this->middleware('userrole'); //this will prevent staff from seeting this blade
  }
    public function index()
    {
        $hrLists =  HumanResource::all()->where('soft_delete', 1);
        return view('humanResource',compact('hrLists'));
    }

    public function insertHr()
    {
        $insertIntoHr = HumanResource::insert([
            'name' => $_POST['staffName'],
            'phone_no' => $_POST['phoneNo'],
            'designation' => $_POST['designation'],
            'salary' => $_POST['salary'],
            'join_date' => $_POST['join_date'],
            'created_at' => \Carbon\Carbon::now(CommonSetting::timezone())->toDateTimeString(),
        ]);
        return redirect('humanresource');
    }

    public function deleteStaff()
    {
        $id = $_POST['staffId'];
        $softStatus = $_POST['softStatus'];

        $updateSoftStatus = HumanResource::find($id)->update([
          'soft_delete' => $softStatus]);
          if($updateSoftStatus){
            return redirect('humanresource');
          }
          else {
            echo "Something Gone Wrong at delete staff!";
          }
    }

    public function editStaffInformation(){
    $id = $_POST['staffId'];
    $staffName = $_POST['staff_name'];
    $staffPhone = $_POST['phone_number'];
    $staffDesignation = $_POST['staff_designation'];
    $staffSalary = $_POST['staff_salary'];

    $updateVendor = HumanResource::find($id)->update([
      'name' => $staffName,
      'phone_no'=>$staffPhone,
      'designation'=>$staffDesignation,
      'salary'=>$staffSalary
      ]);
      if($updateVendor){
        return redirect('humanresource');
      }
      else {
        echo "Something Gone Wrong at updating Staff!";
      }
    }

    Public function userList()
    {
        $userLists = User::select('id','name','email','role')->where('id','<>',1)->where('password','<>','deleteduser')->get();
        return view('userlist',compact('userLists'));
    }

    Public function deleteUser($id='')
    {
        $delete = User::find($id)->update(['password' => 'deleteduser']);
        return redirect('userlist');
    }
}
