<nav id="sidebar" aria-label="Main Navigation">
    <div class="bg-header-dark">
        <div class="content-header bg-white-10">
            <a class="link-fx font-w600 font-size-lg text-white" href="/">
                <span style="font-size: 30px;font-weight: bold;letter-spacing: 3px;color:white;">
                    {{ LOGO_TEXT }}
                </span>
            </a>
            <div>
                <a class="d-lg-none text-white ml-2" data-toggle="layout" data-action="sidebar_close" href="javascript:void(0)"> <i class="fa fa-times-circle"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="content-side content-side-full">
        <ul class="nav-main">
            {{-- <?php if ($is_admin) { ?> --}}
            <li class="nav-main-heading">QUẢN LÝ ADMIN</li>
            <li class="nav-main-item">
                <a class="nav-main-link" href="/admin/settings"><i class="nav-main-link-icon fa fa-cog"></i>
                  <span class="nav-main-link-name">Cài đặt chung</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link" href="/admin/users"><i class="nav-main-link-icon far fa-user"></i>
                  <span class="nav-main-link-name">Thành viên</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link" href="/admin/trans"><i class="nav-main-link-icon fa fa-dollar-sign"></i>
                  <span class="nav-main-link-name">Cộng/Trừ tiền</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link" href="/admin/notify"><i class="nav-main-link-icon fa fa-bell"></i>
                  <span class="nav-main-link-name">Thông báo</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link" href="/admin/thong-ke"><i class="nav-main-link-icon fa fa-money-bill-alt"></i>
                  <span class="nav-main-link-name">Thống kê doanh thu</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link" href="/admin/lich_su_hoat_dong"><i class="nav-main-link-icon fa fa-history"></i>
                  <span class="nav-main-link-name">Lịch sử hoạt động</span>
                </a>
            </li>

            @foreach ( SERVICE as $item)
            <li class="nav-main-item">
                <a class="nav-main-link nav-main-link-submenu active" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon fa fa-plus-circle"></i>
                    <span class="nav-main-link-name">Quản lý {{ mb_strtoupper($item) }}</span>
                </a>
                <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="/admin/{{ $item }}/create">
                            <i class="nav-main-link-icon fa fa-plus-circle"></i>
                            <span class="nav-main-link-name">Thêm</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="/admin/{{ $item }}?status={{ HET_HANG }}">    
                            <i class="nav-main-link-icon fa fa-list"></i>
                            <span class="nav-main-link-name">Quản lý</span>
                        </a>
                    </li>
             
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="/admin/type/{{ $item }}">
                            <i class="nav-main-link-icon fa fa-book"></i>
                            <span class="nav-main-link-name">Phân loại</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endforeach
              

            <li class="nav-main-heading">BUSINESS MANAGER</li>
            <li class="nav-main-item">
                <a class="nav-main-link" href="/#mua-bm"><i class="nav-main-link-icon far fa-eye"></i>
                  <span class="nav-main-link-name">Mua BM</span>
                  <span class="nav-main-link-badge badge badge-pill badge-success">new</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link" href="/order?type=bm"><i class="nav-main-link-icon fa fa-hand-holding"></i>
                  <span class="nav-main-link-name">BM đã mua</span>
                  <span class="nav-main-link-badge badge badge-pill badge-primary">0</span>
                </a>
            </li>
            <li class="nav-main-heading">Via, Clone Đã mua</li>
            <li class="nav-main-item">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon far fa-eye"></i>
                    <span class="nav-main-link-name">Lịch sử Mua Via</span>
                </a>
                <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="/#mua-via">
                            <i class="nav-main-link-icon far fa-eye"></i>
                            <span class="nav-main-link-name">Mua Via</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="/order?type=via">
                            <i class="nav-main-link-icon fa fa-history"></i>
                            <span class="nav-main-link-name">Lịch sử mua Via</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon far fa-eye"></i>
                    <span class="nav-main-link-name">Lịch sử Mua Clone</span>
                </a>
                <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="/#mua-clone">
                            <i class="nav-main-link-icon far fa-eye"></i>
                            <span class="nav-main-link-name">Mua Clone</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="/order?type=clone">
                            <i class="nav-main-link-icon fa fa-history"></i>
                            <span class="nav-main-link-name">Lịch sử mua Clone</span>
                        </a>
                    </li>
            
                </ul>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon far fa-eye"></i>
                    <span class="nav-main-link-name">Lịch sử Mua <span class="text-danger"></span> Proxy</span>
                </a>
                <ul class="nav-main-submenu">
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="/mua-proxy">
                            <i class="nav-main-link-icon far fa-eye"></i>
                            <span class="nav-main-link-name">Mua Proxy</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="order_proxy">
                            <i class="nav-main-link-icon fa fa-history"></i>
                            <span class="nav-main-link-name">Lịch sử mua proxy</span>
                        </a>
                    </li>
            
                </ul>
            </li>
            <li class="nav-main-heading">Thanh toán</li>
            <li class="nav-main-item">
                <a class="nav-main-link" href="/nap-tien"><i class="nav-main-link-icon fa fa-dollar-sign"></i>
                    <span class="nav-main-link-name">Nạp tiền</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link" href="/lich-su-nap-tien"><i class="nav-main-link-icon fa fa-history"></i>
                    <span class="nav-main-link-name">Lịch sử nạp tiền</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link" href="/lich-su-thanh-toan"><i class="nav-main-link-icon fa fa-history"></i>
                    <span class="nav-main-link-name">Lịch sử thanh toán</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link" href="/ho-tro"> <i class="nav-main-link-icon fa fa-headset"></i>
                    <span class="nav-main-link-name">Hỗ trợ</span>
                </a>
            </li>
            <li class="nav-main-heading">Ae Fan Chè Xanh</li>
            <li class="nav-main-item">
                <a class="nav-main-link" href="/note-tool"><i class="nav-main-link-icon fa fa-comment-dollar"></i>
                    <span class="nav-main-link-name">Cần biết về Tool</span>
                </a>
            </li>
             <li class="nav-main-item">
                <a class="nav-main-link" href="/check-live-uid"><i class="nav-main-link-icon fa fa-hand-holding"></i>
                    <span class="nav-main-link-name">Check Live UID</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link" href="/tool-mien-phi"><i class="nav-main-link-icon fa fa-hand-holding"></i>
                    <span class="nav-main-link-name">Tool Miễn Phí + Lưu ý </span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link" href="/mua-proxy"><i class="nav-main-link-icon fa fa-hand-holding"></i>
                    <span class="nav-main-link-name text-success">Mua Proxy <3 </span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link" href="/share-clone-to-via"><i class="nav-main-link-icon fa fa-hand-holding"></i>
                    <span class="nav-main-link-name">Share Tkqc Clone =>Via </span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link" href="/check-limit-ads"><i class="nav-main-link-icon fa fa-hand-holding"></i>
                    <span class="nav-main-link-name text-danger">Quản Lý Ads Meta</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link" href="/share-clone-to-bm"><i class="nav-main-link-icon fa fa-hand-holding"></i>
                    <span class="nav-main-link-name">Share Tkqc Clone =>BM</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link" href="/check-info-via"><i class="nav-main-link-icon fa fa-hand-holding"></i>
                    <span class="nav-main-link-name">Check Info Via</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link" href="/reg-bm"><i class="nav-main-link-icon fa fa-hand-holding"></i>
                    <span class="nav-main-link-name">Reg BM </span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link" href="/check-sai-pass"><i class="nav-main-link-icon fa fa-hand-holding"></i>
                    <span class="nav-main-link-name">Check Sai Pass Via</span>
                </a>
            </li>
            <li class="nav-main-item">
                <a class="nav-main-link" href="/change-info-ads"><i class="nav-main-link-icon fa fa-hand-holding"></i>
                    <span class="nav-main-link-name">Change Info TKQC</span>
                </a>
            </li>             
            <li class="nav-main-item">
                <a class="nav-main-link" href="/len-camp"><i class="nav-main-link-icon fa fa-hand-holding"></i>
                    <span class="nav-main-link-name">Add thẻ +Set Camp SLL</span>
                </a>
            </li>
         
        </ul>
    
    </div>
   
</nav>