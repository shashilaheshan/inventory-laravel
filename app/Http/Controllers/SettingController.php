<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting as Setting;
use Image;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('storestatus');
        $this->middleware('userrole');

    }
    public function index()
    {
        $companyInformations = Setting::findorfail(1);
        return view('setting' , compact('companyInformations'));
    }
    public function editCompanyInformation(Request $request)
    {
        if($request->hasFile('logo')){
            $value = Setting::findorfail(1);
            $logo = $request->file('logo');

            $filename = 'company' . '.' . $logo->getClientOriginalExtension();
            Image::make($logo)->resize(200, 200)->save( base_path('resources/assets/uploads/logo/' . $filename ) );
            $value->logo = $filename;
            $value->save();

        }
        $companyInformationUpdateStatus = Setting::findorfail(1)
        ->update([
            'company_name' => $request->companyName,
            'phone_number' => $request->companyPhoneNumber,
            'address' => $request->companyAddress,
            'currency' =>$request->currencies,
            'time_zone' => $request->timezone,
            'default_vat' => $request->defaultVat,
            'delivery_charge' => $request->delivery_charge,
        ]);
        if($companyInformationUpdateStatus){
            return redirect('settings');
        }
        else {
            echo "Something Gone Wrong at updating company information";
        }
    }
}
