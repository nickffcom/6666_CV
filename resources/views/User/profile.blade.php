@extends("Layout.US.Index")
@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="block block-rounded block-themed block-fx-pop">
            <div class="block-header bg-gd-sea">
                <h3 class="block-title">Cài đặt</h3>
            </div>
            <div class="block-content">
                <div class="row">
                    <div class="col-6">
                        <h2 class="content-heading">Thông tin tài khoản</h2>
                    </div>
                    <div class="col-6">
                        <img src="{{ $me->avatar ? $me->avatar : '/images/zalo-icon.png' }}" style="height:55px;width:55px;border-radius:50%;display:flex;justify-content:center;align-items: center;" alt="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                    <h2 class="content-heading">Loại tài Khoản:</h2>
                    </div>
                    <div class="col-6">
                        <h2 class="content-heading">{{ $me->type_social == null  ? 'Tài Khoản Thường': (($me->type_social == 1) ? 'Login with Facebook 🎁🎁🎁' : 'Login with Google 🍓🍓🍓' ) }}</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="offset-2 col-lg-8">
                        <div class="form-group row">
                            <label class="col-sm-4">Tài khoản</label>
                            <div class="col-sm-8">
                                <span>{{  $me->username }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4">Số dư</label>
                            <div class="col-sm-8">
                                <span>{{ number_format($me->money) }} VNĐ</span>
                            </div>
                        </div>
                    </div>
                </div>
                <h2 class="content-heading">Đổi mật khẩu</h2>
                <div class="row">
                    <div class="offset-2 col-lg-8">
                        <form class="mb-5" id="change_pwd" method="POST">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Mật khẩu hiện tại</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu hiện tại" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Mật khẩu mới</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Tạo mật khẩu" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Xác nhận mật khẩu</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" id="confirm_password" name="new_password_confirmation" placeholder="Xác nhận mật khẩu" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-8 ml-auto">
                                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $('form#change_pwd').bind('submit', function (e) {
        $.post('/change_password', $(this).serializeArray(), function (a) {
            if (a.status ==  true) {
                setTimeout(function () {
                    location.reload();
                }, 1500);
            }
            showNotify((a.status == true ? 'success' : 'error'), a.message);
        });
        e.preventDefault();
    });
</script>
@endsection