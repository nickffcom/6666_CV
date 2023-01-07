
@extends('Layout.AD.index')
@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="block block-rounded block-themed block-fx-pop">
            <div class="block-header bg-info">
                <h3 class="block-title"><i class="fa fa-money-bill-alt"></i> Thống kê ++++</h3>
            </div>
            <div class="block-content">
                <div class="table-responsive">
                    <table class="DataTable table table-hover table-vcenter">
                        <thead>
                            <tr>
                                <th class="d-sm-table-cell">Tổng thành viên: {{ $allUser }} </th>
                                <th class="d-sm-table-cell">Tổng Order: {{ $allOrder }} </th>
                                <th class="d-sm-table-cell">Doanh thu toàn bộ: 
                                <span class="badge badge-success"> {{ number_format($allProfit->TONG_TIEN) }} VNĐ</span>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
                <div class="table-responsive">
                    <table class="DataTable table table-hover table-vcenter">
                        <thead>
                            <tr>
                                <th class="d-sm-table-cell">Số Tiền Giao Dịch Order <span class="badge badge-success"> {{ number_format($allMoneyOrder) }} VNĐ </th>
                            </tr>
                        </thead>
                    </table>
                </div>
        </div>
    </div>

</div>

<div class="row justify-content-center">
    <div class="col-12">
        <div class="block block-rounded block-themed block-fx-pop">
            <div class="block-header bg-success">
                <h3 class="block-title"><i class="fa fa-money-bill-alt"></i> Thống kê doanh {{ now()->format('m-Y')}}</h3>
            </div>
            <div class="block-content">
                <div class="table-responsive">
                    <table class="DataTable table table-hover table-vcenter">
                        <thead>
                            <tr>
                                <th class="d-sm-table-cell">Doanh thu hôm nay ( {{  now()->format('d/m') }} )</th>
                                <th class="d-sm-table-cell">Doanh thu tháng này ( {{ now()->format('m/Y') }} )</th>
                                {{-- <th class="d-sm-table-cell">Doanh thu toàn bộ</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="d-sm-table-cell">
                                    <span class="badge badge-info"> {{ number_format($doanhthuNgayNayThangTruoc) }} \ {{ number_format($doanhThuHomNay) }} {{$checkNgay}} VNĐ</span> 
                                </td>
                                <td class="d-sm-table-cell">
                                    <span class="badge badge-danger">{{ number_format($doanhthuThangTruoc) }} \ {{ number_format($doanhThuHomNay) }} {{$checkThang}}  VNĐ</span> 
                                </td>
                                {{-- <td class="d-sm-table-cell">
                                    <span class="badge badge-success">+ {{ number_format($allProfit->TONG_TIEN) }} VNĐ</span> 
                                </td> --}}
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div style="display: table; margin:0 auto;">
                    <nav>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection