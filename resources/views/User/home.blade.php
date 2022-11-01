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
                            {{ text_style($noty) }}
                        </div>
                    @endforeach


                </div>
            </div>
        </div>
    </div>

    {{-- Main HomePage  --}}
    @isset($services)
        @foreach ($services as $key => $service)
            <div class="row justify-content-center" id="mua-{{ $key }}">
                <div class="col-12">
                    <div class="block block-rounded block-themed block-fx-pop">
                        <div class="block-header bg-gd-sea">
                            <h3 class="block-title">Danh sách {{ strtoupper($key) }}</h3>
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
                                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 mb-1">
                                        <div class="custom-control custom-block custom-control-primary">
                                            <input type="checkbox" class="custom-control-input service-checked"
                                                id="{{ $key }}_id_{{ $item->id }}" name="type"  @if(isset($item->country)) data-type={{ $key }} @endif value="{{ $item->id }}">
                                            <label class="custom-control-label p-2" for="{{ $key }}_id_{{ $item->id }}">
                                                <span class="d-flex align-items-center">
                                                    <div class="item item-circle bg-black-5 text-primary-light"
                                                        style="min-width: 60px;"><strong>{{ $item->amount }}</strong></div>
                                                    <span class="hcss ml-2">
                                                        <span class="font-w700">{{ $item->name }} ✅</span>

                                                        <i style="position:absolute;right:5px;bottom:10px;"
                                                            class="fa fa-question-circle text-muted" data-toggle="tooltip"
                                                            data-placement="top" title="{{ $item->description }}"></i>
                                                        <span class="d-block font-size-sm text-muted"><strong
                                                                class="text-danger"> » {{ number_format($item->price) }}
                                                                VNĐ</strong></span>
                                                    </span>
                                                </span>
                                            </label>
                                            <span class="custom-block-indicator">
                                                <i class="fa fa-check"></i>
                                            </span>
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

        $('.buy_service').bind('click', function() {
            $id = $('[name="type"]:checked').val();
            $dataType = $('[name="type"]:checked').attr("data-type");
            if (!$id) {
                return showNotify('error', 'Vui lòng chọn một loại ' + $(this).text().split(" ")[1]);
            }
            $quantity = prompt('Nhập số lượng muốn mua : ', 5);
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
                id: $id,
                quantity: $quantity,
                type:$dataType
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
            title: "Ae yên tâm mua nhé...",
            html: true,
            text: " Bảo hành 1-1  sai pass, login đầu , hàng chưa đụng gì đến Ads và ko bảo hành hạn chế ,,,khách hàng nạp trên 100k sẽ được Admin backup free (số lượng <10)<br>",
            showConfirmButton: true

        }, function() {


        });
    </script>
@endsection
