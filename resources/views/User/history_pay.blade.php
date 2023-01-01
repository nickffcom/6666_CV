
@extends('Layout.US.Index')
@section('content')
    

<div class="row justify-content-center">
    <div class="col-12">
        <div class="block block-rounded block-themed block-fx-pop">
            <div class="block-header bg-info">
                <h3 class="block-title">Lịch sử nạp tiền</h3>
            </div>
            <div class="block-content">
                <div class="table-responsive">
                    <table class="table table-hover table-vcenter">
                        <thead>
                            <tr>
                                <th class="d-sm-table-cell" style="width: 15%;">Thời gian</th>
                                <th class="d-sm-table-cell text-center" style="width: 20%;">Nội dung</th>
                                <th class="d-sm-table-cell text-center" style="width: 20%;">Số tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                         
                            @foreach($historyPayment as $x)
                            <tr>
                                <td class="d-sm-table-cell" style="width: 30%;">{{   date('H:i:s - d/m/Y', strtotime($x['created_at'])) }}</td>
                                <td class="d-sm-table-cell text-center" style="width: 30%;">{{  (!empty($x['content']) ? $x['content'] : $x['id']) }}</td>
                                <td class="d-sm-table-cell text-center" style="width: 30%;">{{  number_format($x['total_money']) }} VNĐ</td>
                            </tr>
                            @endforeach
                          
                          
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