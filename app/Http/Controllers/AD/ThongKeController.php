<?php

namespace App\Http\Controllers\AD;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\Models\Order_service;
use App\Models\User;
use App\Repository\DataRepo;
use App\Repository\HistoryRepo;
use App\Repository\ServiceRepo;
use Illuminate\Http\Request;

class ThongKeController extends Controller
{
    protected $serviceRepo;
    protected $dataRepo;
    protected $historyRepo;
    public function __construct(ServiceRepo $serviceRepo, DataRepo $dataRepo, HistoryRepo $historyRepo)
    {
        $this->serviceRepo = $serviceRepo;
        $this->dataRepo = $dataRepo;
        $this->historyRepo = $historyRepo;
    }

    public function ThongKeDoanhThu(Request $request){
        $allUser = User::count();
        $allOrder = Order_service::count();
        $thongke = $this->historyRepo->getThongKeDoanhThu(); // all tiền vào shop
        $allMoneyOrder = Order_service::sum('price_buy');

        $ngayhientai = now()->format('Ymd');
        $thanghientai = now()->format('Ym');
        $doanhThuHomNay =$this->historyRepo->getThongKeDoanhThuBy($ngayhientai);
        $doanhThuThangNay = $this->historyRepo->getThongKeDoanhThuBy($thanghientai);

        $doanhthuNgayNayThangTruoc =$this->historyRepo->getThongKeDoanhThuBy( now()->addMonth(-1)->format('Ymd'));
        $doanhthuThangTruoc =$this->historyRepo->getThongKeDoanhThuBy( now()->addMonth(-1)->format('Ymd'));

        $checkDoanhThuNgay = ($doanhthuNgayNayThangTruoc - $doanhThuHomNay) ;
        $checkDoanhThuThang = ($doanhthuThangTruoc - $doanhThuThangNay);
        $checkNgay =  $checkDoanhThuNgay >= 0 ?  "-" : '+';
        $checkThang = $checkDoanhThuThang>= 0 ?  "-" : '+';
        if($checkDoanhThuNgay !=0 || $checkDoanhThuThang !=0){
            $phanTramNgay = (($doanhthuNgayNayThangTruoc - $doanhThuHomNay) / $doanhthuNgayNayThangTruoc) *100;
            $phanTramThang =($doanhthuNgayNayThangTruoc - $doanhThuHomNay) / $doanhthuThangTruoc ;
            dd($phanTramNgay.$phanTramThang);
        }
        return view('Admin.statics',[
            'allUser'=>$allUser,
            'allOrder'=>$allOrder,
            'allProfit'=>$thongke,
            'allMoneyOrder'=>$allMoneyOrder,
            'doanhThuHomNay'=>$doanhThuHomNay,
            'doanhThuThangNay'=>$doanhThuThangNay,
            'doanhthuNgayNayThangTruoc'=>$doanhthuNgayNayThangTruoc,
            'doanhthuThangTruoc'=>$doanhthuThangTruoc,
            'checkNgay'=>$checkNgay,
            'checkThang'=>$checkThang,
        ]);
    }
}
