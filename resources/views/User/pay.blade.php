@extends('Layout.US.Index')
@section('content')
    
<div class="row justify-content-center">
    <div class="col-12">
        <div class="block block-rounded block-themed block-fx-pop">
            <div class="block-header bg-gd-sea">
                <h3 class="block-title">Nạp tiền Tự Động - Tự động cộng tiền sau 1-3 phút ! Ae nên nạp qua VietComBank nhé , momo hay lỗi !!! Nạp xong nên chát giúp mình</h3>
                <h3 class="block-title" >Ae nên dùng Quét Mã QR trong app ngân hàng để quét mã để nội dung chuyển tiền đúng nhất nhé ! Tránh sự cố</h3>
            </div>
            <div class="block-content">
                <div class="kt-section mb-5">
                    <div class="kt-section__desc">
                        <div class="row">
                            <div class="col-lg-6" style="padding: 10px;">
                                <div class="text-center">
                                    <img style="width:50%;height:100%;"  src="https://apiqr.web2m.com/api/generate/VCB/1016650160/LUU%20VAN%20AN?amount=300000&memo=naptien {{ Auth::user()->username }}&is_mask=0&bg=1" >
                                </div><br>
                                <div class="row mb-1">
                                    <div class="col-6 text-right">Tên tài khoản:</div>
                                    <div class="col-6 text-primary-dark">LUU VAN AN</div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-6 text-right">Số tài khoản:</div>
                                    <div class="col-6 text-primary-dark">1016650160</div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-6 text-right">Ngân hàng:</div>
                                    <div class="col-6 text-primary-dark">Vietcombank</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6 text-right">Nội dung chuyển khoản: (Phải đúng 100% khoảng trắng )</div>
                                    <div class="col-6 text-primary-dark font-weight-bold"><span class="text-danger">naptien {{ Auth::user()->username }}</span>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-lg-6" style="padding: 10px;">
                                <div class="text-center">
                                    <img src="/images/momo.png" width="65px">
                                </div><br>
                                <div class="row mb-1">
                                    <div class="col-6 text-right">Tên tài khoản:</div>
                                    <div class="col-6 text-primary-dark">Lưu Văn An</div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-6 text-right">Số điện thoại:</div>
                                    <div class="col-6 text-primary-dark">0397619750</div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-6 text-right">Ví điện tử:</div>
                                    <div class="col-6 text-primary-dark">Momo</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6 text-right">Nội dung chuyển khoản:</div>
                                    <div class="col-6 text-primary-dark font-weight-bold"><span class="text-danger">nap tien {{ Auth::user()->username}} </span>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                        
                    </div>

                    <div class="alert alert-danger is-loading">
                        - Vui lòng chuyển khoản đúng cú pháp. Trường hợp chuyển khoản sai cú pháp GỌI ADMIN hỗ trợ: <a target="_blank" rel="noopener noreferrer" href="ho-tro">LIÊN HỆ NGAY Call 039 7619 750 or Zalo</a>
                        <br>
                        - Nạp Min 30k ! Ae nào nạp ít hơn không cộng tiền thì mình không giải quyết !!!
                    </div>
                    <div class="alert alert-warning">
                        - Vui lòng chờ đợi hệ thống nhận tiền, có thể mất tới vài phút sau khi bạn chuyển tiền.
                        <br>
                        - Nếu bạn có việc bận, bạn có thể rời đi, sau khi online trở lại, bạn hãy kiểm tra số tiền của mình, nếu chưa được nạp, hãy đến phần nạp tiền, nhấn "Check trên server" một lần nữa.
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

