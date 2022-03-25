<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Booking;
use App\User;
use App\Salon;
use App\AdminSetting;
use App\WalletPayment;
use Bavix\Wallet\Models\Transaction;
use Redirect;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function revenue(Request $request)
    {
        if(isset($request->filter_date)){
            if($request->filter_date != null)
            {
                $pass = $request->filter_date;
                $dates = explode(' to ', $request->filter_date);
                $from = $dates[0];
                $to = $dates[1];
                $bookings = Booking::where('payment_status',1)
                ->whereBetween('date', [$from, $to])
                ->orderBy('date', 'ASC')
                ->get();
                $setting = AdminSetting::find(1,['currency_symbol']);
                return view('admin.report.revenue',compact('bookings','setting','pass'));
            }
            else{
                return redirect('/admin/report/revenue')->withErrors(['Select Date In Range']);
            }
        }
        else {
            $pass = '';
            $bookings = Booking::where('payment_status',1)
            ->orderBy('id', 'DESC')
            ->get();
            $setting = AdminSetting::find(1,['currency_symbol']);
        }
        return view('admin.report.revenue',compact('bookings','setting','pass'));
    }
    public function wallet_withdraw_report(Request $request)
    {
        $setting = AdminSetting::find(1,['currency_symbol']);
        if(isset($request->filter_date)){
            if($request->filter_date != null)
            {
                $pass = $request->filter_date;
                $dates = explode(' to ', $request->filter_date);
                $from = $dates[0];
                $to = $dates[1];
                $transactions = Transaction::with('wallet')->where('type','withdraw')->whereBetween('created_at', [$from.' 00:00', $to.' 23:59'])->get();
            }else{
                return redirect('/admin/report/wallet/withdraw')->withErrors(['Select Date In Range']);
            }
        }
        else {
            $pass = '';
            $transactions = Transaction::with('wallet')->where('type','withdraw')->orderBy('id','DESC')->get();
        }
        
        foreach ($transactions as $transaction) {
            $transaction->payment_details = WalletPayment::where('transaction_id',$transaction->id)->first();
            $transaction->date = Carbon::parse($transaction->created_at);
            $transaction->user = User::find($transaction->payable_id);
            $transaction->booking = Booking::find($transaction->meta[0]);
        }
        return view('admin.report.wallet_withdraw_report',compact('transactions','setting','pass'));
    }
    public function wallet_deposit_report(Request $request)
    {
        $setting = AdminSetting::find(1,['currency_symbol']);
        if(isset($request->filter_date)){
            if($request->filter_date != null)
            {
                $pass = $request->filter_date;
                $dates = explode(' to ', $request->filter_date);
                $from = $dates[0];
                $to = $dates[1];
                $transactions = Transaction::with('wallet')->where('type','deposit')->whereBetween('created_at', [$from.' 00:00', $to.' 23:59'])->get();
            }else{
                return redirect('/admin/report/wallet/deposit')->withErrors(['Select Date In Range']);
            }
        }
        else {
            $pass = '';
            $transactions = Transaction::with('wallet')->where('type','deposit')->orderBy('id','DESC')->get();
        }

        foreach ($transactions as $transaction) {
            $transaction->payment_details = WalletPayment::where('transaction_id',$transaction->id)->first();
            $transaction->date = Carbon::parse($transaction->created_at);
            $transaction->user = User::find($transaction->payable_id);
        }
        return view('admin.report.wallet_deposit_report',compact('transactions','setting','pass'));
    }
    public function user(Request $request)
    {
        if(isset($request->filter_date)){
            if($request->filter_date != null)
            {
                $pass = $request->filter_date;
                $dates = explode(' to ', $request->filter_date);
                $from = $dates[0];
                $to = $dates[1];

                $users = User::where('role',3)
                ->whereBetween('created_at', [$from, $to])
                ->orderBy('created_at','ASC')
                ->get();
                $booking = Booking::get();
                return view('admin.report.userReport',compact('users','booking','pass'));
            }
            else{
                return redirect('/admin/report/user')->withErrors(['Select Date In Range']);
            }
        }
        else {
            $pass = '';
            $users = User::where('role',3)
            ->orderBy('id','DESC')
            ->get();
            $booking = Booking::get();
        }

        return view('admin.report.userReport',compact('users','booking','pass'));
    }

    public function salonrevenue(Request $request)
    {
        if(isset($request->filter_date)){
            if($request->filter_date != null)
            {
                $pass = $request->filter_date;
                $dates = explode(' to ', $request->filter_date);
                $from = $dates[0];
                $to = $dates[1];
    
                $salons = Salon::orderBy('salon_id', 'DESC')->get();
                $booking = Booking::whereBetween('date', [$from, $to])
                ->orderBy('date', 'ASC')
                ->get();
                $setting = AdminSetting::find(1,['currency_symbol']);
                return view('admin.report.salonrevenue',compact('salons','booking','setting','pass'));
            }
            else{
                return redirect('/admin/report/salon/revenue')->withErrors(['Select Date In Range']);
            }
        } else {
            $pass = '';
            $salons = Salon::orderBy('salon_id', 'DESC')->get();
            $booking = Booking::get();
           
            $setting = AdminSetting::find(1,['currency_symbol']);
        }
        return view('admin.report.salonrevenue',compact('salons','booking','setting','pass'));
    }
}
