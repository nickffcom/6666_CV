@extends('Layout.US.Out')
@section('content')
<div id="page-container">
    <main id="main-container">
        <div class="bg-image">
            <div class="row no-gutters justify-content-center bg-primary-dark-op">
                <div class="hero-static col-sm-8 col-md-6 col-xl-4 d-flex align-items-center p-2 px-sm-0">
                    <div class="block block-transparent block-rounded w-100 mb-0 overflow-hidden">
                        <div class="block-content block-content-full px-lg-5 px-xl-6 py-4 py-md-5 py-lg-6 bg-white"> 
                        <span style="color:#D84646; margin-left:55px; "> Hệ Thống Via Việt -Clone -Bm Uy Tín </span>
                        <br>
                        <span style="color:#D84646 ; margin-left:26px" > Vui Lòng Đăng Nhập or Đăng Kí Để Tiếp Tục</span>
                            <div class="mb-2 text-center">
                                <span style="font-size: 30px;font-weight: bold;letter-spacing: 1px;color:black;"><?= $logo_text; ?></span>
                                <p class="text-uppercase font-w700 font-size-sm text-muted">Đăng Nhập</p>
                            </div>
                            <form class="js-validation-signin" id="form_login" name="" method="POST">
                                @csrf
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Tài khoản" required="">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-user-circle"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required="">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-asterisk"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-hero-primary"><i class="fa fa-fw fa-sign-in-alt mr-1"></i> Đăng Nhập</button>
                                </div>
                            </form>
                        </div>
                        <div class="block-content bg-body">
                            <div class="d-flex justify-content-center text-center push">
                                <div class="font-w600 font-size-sm py-1 text-center">Chưa có tài khoản? <a href="/register">Đăng ký</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection

@section('script')
<script>
    $( document ).ready(function() {
        $('#form_login').bind('submit', function (e) {
            e.preventDefault();
            showNotify({
                type: 'info',
                text: 'Đang đăng nhập...',
                hide: false,
                clickToClose: false
            });
            $.post('/login', $(this).serializeArray(), function (a) {
                if (a.status == true) {
                    setTimeout(function () {
                        location.href='/';
                    }, 100);
                }
                showNotify((a.status ==true ? 'success' : 'error'), a.message);
            });
           
        });
    });
</script>
@endsection