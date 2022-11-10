<header id="page-header">
    <div class="content-header">
        <div>
            <button type="button" class="btn btn-dual mr-1" data-toggle="layout" data-action="sidebar_toggle"><i class="fa fa-fw fa-bars"></i>
            </button>
        </div>
        <div>
            <div>
                <div class="dropdown d-inline-block">
                   
                    <button type="button" class="btn btn-hero-success d-none d-md-inline-block">Số dư: {{ number_format(Auth::user()->money) }} đ</button> <a href="/nap-tien" class="btn btn-hero-info">Nạp Tiền</a>
                    <button type="button" class="btn btn-dual" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-fw fa-user d-sm-none"></i>
                        <span class="d-none d-sm-inline-block">{{ Auth::user()->username or Auth::user()->email }}</span>
                        <i class="fa fa-fw fa-angle-down ml-1 d-none d-sm-inline-block"></i>
                    </button>
                  
                    <div class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="page-header-user-dropdown">
                        <div class="bg-primary-darker rounded-top font-w600 text-white text-center p-3">Thông tin tài khoản</div>
                        <div class="p-2">
                            <a class="dropdown-item" href="/tai-khoan"><i class="far fa-fw fa-user mr-1"></i> Tài khoản</a>
                            <a class="dropdown-item" href="/lich-su-thanh-toan"> <i class="far fa-fw fa-file-alt mr-1"></i> Lịch sử</a>
                            <div role="separator" class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/dang-xuat"> <i class="far fa-fw fa-arrow-alt-circle-left mr-1"></i> Đăng xuất</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="page-header-loader" class="overlay-header bg-primary-darker">
            <div class="content-header">
                <div class="w-100 text-center"> <i class="fa fa-fw fa-2x fa-sun fa-spin text-white"></i>
                </div>
            </div>
        </div>
    </div>    
</header>