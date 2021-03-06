<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Coupon;
use App\Salon;
use App\AdminSetting;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::orderBy('coupon_id', 'DESC')->paginate(8);
        $symbol = AdminSetting::find(1)->currency_symbol;     
        return view('admin.pages.coupon', compact('coupons','symbol'));
    }

    public function create()
    {
        return view('admin.coupon.create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'desc' => 'bail|required',
            'type' => 'bail|required',
            'discount' => 'bail|required|numeric',
            'min_discount_amount' => 'bail|required|numeric',
            'max_use' => 'bail|required|numeric',
            'start_date' => 'bail|required',
            'end_date' => 'bail|required|after:start_date',
            'min_point' => 'required_if:for_point,on'
        ]);
        $setting = AdminSetting::find(1);
        $coupon = new Coupon();
        $coupon->code = $request->code;
        $coupon->desc = $request->desc;
        $coupon->type = $request->type;
        $coupon->discount = $request->discount;
        $coupon->max_use = $request->max_use;
        $coupon->start_date = $request->start_date;
        $coupon->end_date = $request->end_date;
        $coupon->min_discount_amount = $request->min_discount_amount;
        if(config('point.active') == 1){
            if($request->for_point == "on"){
                $coupon->for_point = 1;
                $coupon->min_point = $request->min_point;
            }
        }
        $coupon->save();
        return redirect('admin/coupon');
    }

    public function show($id)
    {
        $data['coupon'] = Coupon::find($id);
        $data['symbol'] = AdminSetting::find(1)->currency_symbol;     
        return response()->json(['success' => true,'data' => $data, 'msg' => 'Coupon show'], 200);
    }

    public function edit($id)
    {
        $coupon = Coupon::find($id);
        $setting = AdminSetting::find(1);
        $coupon->is_point_package = config('point.active');
        return response()->json(['success' => true,'data' => $coupon], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'desc' => 'bail|required',
            'type' => 'bail|required',
            'discount' => 'bail|required|numeric',
            'min_discount_amount' => 'bail|required|numeric',
            'max_use' => 'bail|required|numeric',
            'start_date' => 'bail|required',
            'end_date' => 'bail|required|after:start_date',
        ]);
        $setting = AdminSetting::find(1);
        $coupon = Coupon::find($id);

        $coupon->desc = $request->desc;
        $coupon->type = $request->type;
        $coupon->discount = $request->discount;
        $coupon->max_use = $request->max_use;
        $coupon->start_date = $request->start_date;
        $coupon->end_date = $request->end_date;
        $coupon->min_discount_amount = $request->min_discount_amount;
        if(config('point.active') == 1){
            if($request->for_point == "on"){
                $coupon->for_point = 1;
                $coupon->min_point = $request->min_point;
            }
        }
        $coupon->save();
        return response()->json(['success' => true,'data' => $coupon, 'msg' => 'Coupon edit'], 200);
    }

    public function destroy($id)
    {
        $coupon = Coupon::find($id);
        $coupon->delete();
        return redirect('admin/coupon');
    }
    public function hideCoupon(Request $request)
    {
        $coupon = Coupon::find($request->couponId);
        if ($coupon->status == 0) 
        {   
            $coupon->status = 1;
            $coupon->save();
        }
        
        else if($coupon->status == 1)
        {
            $coupon->status = 0;
            $coupon->save();
        }
    }
}
