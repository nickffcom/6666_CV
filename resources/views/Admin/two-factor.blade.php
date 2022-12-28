@extends('Layout.US.Index')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<div class="row justify-content-center">
    <div class="col-12">
        <div class="block block-rounded block-themed block-fx-pop">
            <div class="block-header bg-info">
                <h3 class="block-title">Bảo mật Continue </h3>
            </div>
            <div class="block-content">
                <div class="table-responsive">
                    <div class="form-group ">
                        <label for="textarea" class="control-label">Nhập 35 kí tự ! Có thể copy dán vào cho lẹ</label>
                        <input class="form-control" id="key-2fa"  example-textarea-input  wrap ="off" rows="6" placeholder="Nhập two-factor" onpaste="setTimeout( e => {post_code_2fa()},100)"></input>
                    </div>
                    <div class="form-group">
                        <label for="textarea" class="control-label">Nếu sai 3 lần sẽ bị xóa nick</label>
                        <!--<input class="form-control" id="ngancach" placeholder="Ký tự ngăn cách" value="|"></input>-->
                    </div>
                    
                    <div class="clearfix">
                        <div class="form-group text-center">
                            <button class="d-inline-block btn btn-hero-sm btn-hero-info" onclick="post_code_2fa();">Gửi Key</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="textarea" class="control-label">Kết quả xác thực</label>
                     <textarea wrap="off" class="form-control form-control-alt" id="listclonelive" name="example-textarea-input" rows="6" placeholder="Không có dữ liệu" style="font-size: 14px;"></textarea>
                    </div>

                </div>
            </div>
            <div style="position: sticky; bottom: 0; margin-bottom: 0;">
           


        </div>
        </div>
    </div>
</div>


@endsection

@section('script')

<script>
    function post_code_2fa(){
        var key2fa = $('#key-2fa').val().trim();
        const data = {
            code2fa:key2fa
        }
        $.post(`/admin/two-factor`,data, function(data, status){
            alert("OK: " + data);
        });
    }

</script>
   
@endsection
