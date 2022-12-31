@extends('Layout.US.Index')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="block block-rounded block-bordered">
                <div class="block-header block-header-defaul">
                    <h4 class="block-title">Thông Báo</h4>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-toggle="block-option"
                            data-action="content_toggle"><i class="si si-arrow-up"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    @foreach ($notify as $noty)
                        <div class="font-w600 animated fadeIn bg-body-light border-3x px-3 py-2 mb-2 shadow-sm mw-100 border-left border-success rounded-right">
                            {{ text_style($noty->content) }}
                        </div>
                    @endforeach


                </div>
            </div>
        </div>
    </div>
    <div class="row main-filter">
            <div class="col col-xl-3 text-primary bg-success" style="width:25px;height:35px;"> 
                <a style="display:block;text-align:center;height: 100%;display: flex;justify-content: center;align-items: center;" href="">
                Via Xmdt
                </a> 
            </div>
            <div class="col col-xl-3 text-primary bg-success" style="width:25px;height:35px;"> 
                 <a style="display:block;text-align:center;height: 100%;display: flex;justify-content: center;align-items: center;" href="">
                Via Limit
                </a>
            </div>
            <div class="col col-xl-3 text-primary bg-success" style="width:25px;height:35px;"> 
                 <a style="display:block;text-align:center;height: 100%;display: flex;justify-content: center;align-items: center;" href="">
                Via Ngoại
                </a>
            </div>
             <div class="col col-xl-3 text-primary bg-success" style="width:25px;height:35px;"> 
                 <a style="display:block;text-align:center;height: 100%;display: flex;justify-content: center;align-items: center;" href="">
                Via 902
                </a>
            </div>         
    </div>
    {{-- Main HomePage  --}}
    @isset($services)
        @foreach ($services as $key => $service)
            <div class="row justify-content-center" id="mua-{{ $key }}">
                <div class="col-12">
                    <div class="block block-rounded block-themed block-fx-pop">
                        <div class="block-header bg-gd-sea">
                            <h3 class="block-title">Danh sách {{ strtoupper($key) }} : {{ count($services[$key]) }} loại</h3>
                            <div class="block-options">
                                <a class="btn btn-block-option" href="order?type=bm"> <i class="si si-settings"></i> {{ strtoupper($key) }} của tôi</a>
                            </div>
                        </div>
                        <div class="block-content">

                            @if (empty($services[$key]))
                                <div class="text-center" style="font-size:20px;color:red;font-weight: bold;">KHU VỰC NÀY CHƯA CÓ
                                    HÀNG !</div>
                            @else
                            @endif


                            <div class="row">
                                @foreach ($service as $item)
                                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 mb-2">
                                        <div class="custom-control custom-block custom-control-primary">
                                            <input type="checkbox" class="custom-control-input service-checked"
                                                id="{{ $key }}_id_{{ $item->id }}" name="type" value={{ $item->id }} data-type={{ $key }} type_secret={{ $item->type_Api }}>
                                            <label class="custom-control-label p-2" for="{{ $key }}_id_{{ $item->id }}">
                                                <span class="d-flex align-items-center">
                                                    <div class="item item-circle bg-black-5 text-primary-light"
                                                        style="min-width: 60px;"><strong>{{ $item->amount }}</strong></div>
                                                    <span class="hcss ml-2">
                                                        <span id="nameAcc" data-name="{{ $item->name }}"" class="font-w700">{{ $item->name }} 
                                                            @if($item->type_Api == 2 )
                                                            ✅
                                                            @elseif($item->type_Api == 3)
                                                            🍅
                                                            @endif
                                                        </span>
                                                        <i style="right:0px;bottom:70px;"
                                                            class="fa fa-question-circle text-muted" data-toggle="tooltip"
                                                            data-placement="top" title="{{ $item->description }}"></i>
                                                        <span class="d-block font-size-sm text-muted"><strong
                                                                class="text-danger"> » {{ number_format($item->price) }}
                                                                VNĐ</strong></span>
                                                    </span>
                                                </span>
                                            </label>
                                            <span class="custom-block-indicator" style="right:22rem!important;top:-0.35rem;left: -0.2rem;">
                                                <i class="fa fa-check"></i>
                                            </span>
                                           
                                            <div style="position: absolute;
                                            right: 0rem;
                                            bottom:0rem;"
                                            >
                                                <button class="buyAds69 btn-success" id-buy-nek={{ $item->id }} style="border:none;border-radius:10px" >Mua</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach


                            </div>
                            <div style="border-bottom: 1px solid #e6ebf4;margin:1.1rem 0 1.75rem 0;"></div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <button class="d-inline-block btn btn-hero-sm btn-hero-info buy_service">Mua
                                        {{ strtoupper($key) }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endisset

    <div class="row">
        <div class="col-xl-6 col-xs-12">
            <div class="block block-rounded block-themed block-fx-pop">
                <div class="block-header bg-gd-sea">
                    <h3 class="block-title">Lịch Sử Nạp Tiền</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-toggle="block-option"
                            data-action="content_toggle"><i class="si si-arrow-up"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">

                        @foreach ($payments as $payment)
                            <div
                                class="font-w600 animated fadeIn bg-body-light border-3x px-3 py-2 mb-2 shadow-sm mw-100 border-left border-success rounded-right">
                                <b>
                                    <font color="green">
                                        <img src="/images/new.gif" height="18"> {{ 'id***' . substr($payment['user_id'], 0, 2); }}
                                    </font> đã nạp số tiền + <font color="red">
                                        <em>{{ number_format($payment->total_money) }} VNĐ</em>
                                    </font>
                                </b>
                                <span style="float: right;">
                                    <span class="badge badge-info" data-toggle="tooltip" data-placement="top"
                                        title="{{ date('H:i:s - d/m/Y', $payment->time) }}">
                                        <em>{{ time_ads($payment->created_at) }}</em>
                                    </span>
                                </span>
                            </div>
                        @endforeach
                    {{-- @endisset --}}


                </div>
            </div>
        </div>
        <div class="col-xl-6 col-xs-12">
            <div class="block block-rounded block-themed block-fx-pop">
                <div class="block-header bg-gd-sea">
                    <h3 class="block-title">Lịch Sử Chung</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-toggle="block-option"
                            data-action="content_toggle"><i class="si si-arrow-up"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">

                    @foreach ($transactions as $transaction)
                        <div
                            class="font-w600 animated fadeIn bg-body-light border-3x px-3 py-2 mb-2 shadow-sm mw-100 border-left border-success rounded-right">
                            <b>
                                <font color="green">
                                    <i class="fa fa-bell"></i> {{ 'id***' . substr($transaction->uid, 0, 2) }}
                                </font>: <font color="red">{{ $transaction->content }}- tổng
                                    {{ number_format($transaction->total_money) }} VNĐ
                                </font>
                            </b>
                            {{-- float: right; --}}
                            <span style=""> 
                                <span class="badge badge-info" data-toggle="tooltip" data-placement="top"
                                    title="{{ $transaction->created_at }}">
                                    <em>{{ time_ads($transaction->created_at) }}</em>
                                </span>
                            </span>
                        </div>
                    @endforeach

                    <!-- /loop -->

                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')


    <script>
        $('input.service-checked').bind('click', function() {
            $that = $(this);
            if ($that.is(':checked')) {
                $('input.service-checked').prop('checked', 0);
                $that.prop('checked', 1);
            } else {
                $that.prop('checked', 0);
            }
        });
        
        $('.buyAds69').bind('click', function() {
            $divTo = $(this).parent().parent();
            $('input.service-checked').prop('checked', 0);
            $($divTo).children('input').prop('checked', 1);

            $id = $('[name="type"]:checked').val();
            $idBuy = $(this).attr('id-buy-nek');
            $dataType = $('[name="type"]:checked').attr("data-type");
            $typeScret = $('[name="type"]:checked').attr("type_secret");
            if (!$id || !$idBuy) {
                return showNotify('error', 'Vui lòng chọn một loại ' + $(this).text().split(" ")[1]);
            }
            $infoSanpham = $($divTo).children("label").children('span').children('span').children('#nameAcc').attr('data-name');
            $descriptionSanpham = $($divTo).children("label").children('span').children('span').children('i').attr('data-original-title');
            $quantity = prompt('Nhập số lượng muốn mua : \n'+$infoSanpham+"\n Miêu tả: "+$descriptionSanpham, 5);
            if ($quantity < 1 || isNaN($quantity)) {
                return showNotify('error', 'Vui lòng nhập số lượng hợp lệ');
            }
            const $notice = showNotify({
                type: 'info',
                text: 'Đang thực hiện giao dịch..',
                hide: false,
                clickToClose: false
            });
            $.post(api('buy'), {
                id: $idBuy,
                quantity: $quantity,
                type:$dataType,
                type_secret:$typeScret
            }, function(a) {
                if (a.status > 0) {
                    setTimeout(function() {
                        window.location = a.move_location;
                    }, 1500);
                }
                showNotify((a.status > 0 ? 'success' : 'error'), a.message);
            });
            setTimeout(function() {
                $notice.remove();
            }, 1000);
        });
    </script>
    <script type="text/javascript">
        swal({
            title: "Hơn 120 loại nguyên liệu ae ghẹo lựa đê",
            html: true,
            text: "Chú ý phải đọc kĩ thông tin khi mua ở dấu ??? . Nếu Không có  thì khả năng cao đó là via clone spam ( ko live ads ) !",
            showConfirmButton: true

        }, function() {
            

        });
    </script>
@endsection
