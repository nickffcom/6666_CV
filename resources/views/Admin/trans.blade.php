@extends('Layout.AD.index')

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="block block-rounded block-themed block-fx-pop">
            <div class="block-header bg-info">
                <h3 class="block-title"><i class="fa fa-dollar-sign"></i> Giao dịch</h3>
            </div>
            <div class="block-content">
                <form id="users" method="POST">
                	<input type="hidden" name="t" value="add">
                    @csrf
                    <div class="form-group">
                        <label>Chọn tài khoản :</label>
                        <datalist id="list_users">
                          
                            @foreach($lists_users as $x)
                            <option value="{{ $x['username'] }}">Số dư : {{  number_format($x['money']) }} VNĐ</option>
                            @endforeach
                        </datalist>
                        <input type="text" name="username" class="form-control" list="list_users" placeholder="Chọn tài khoản" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Số tiền :</label>
                        <input type="number" name="money" class="form-control" placeholder="Nhập số tiền">
                    </div>
                    <div class="form-group">
                        <label>TransactionID (Nếu có) :</label>
                        <input type="text" name="transactionID" class="form-control" placeholder="Nhập Id Transaction">
                    </div>
                    <div class="form-group">
                        <label>Thao tác :</label>
                        <select name="action" class="form-control">
                            <option value="plus">Cộng tiền</option>
                            <option value="minus">Trừ tiền</option>
                        </select>
                    </div>
                	<button type="submit" class="btn btn-success"><i class="fa fa-dollar-sign"></i> Thực hiện</button>
                </form>
            </div>
            <br>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $('form#users').bind('submit', function (e) {
    
        $.post('/admin/trans', $(this).serializeArray(), function (a) {

            showNotify((a.status > 0 ? 'success' : 'error'), a.message);
        });
        e.preventDefault();
    });
</script>
@endsection