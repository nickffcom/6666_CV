@extends('Layout.US.Index')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<div class="row justify-content-center">
    <div class="col-12">
        <div class="block block-rounded block-themed block-fx-pop">
            <div class="block-header bg-info">
                <h3 class="block-title">Check Live UID </h3>
            </div>
            <div class="block-content">
                <div class="table-responsive">
                    <div class="form-group ">
                        <label for="textarea" class="control-label">Nhập Key 2FA</label>
                        <input class="form-control" id="key-2fa"  example-textarea-input  wrap ="off" rows="6" placeholder="Nhập key 2FA" onpaste="setTimeout( e => {get_code_2fa()},100)"></input>
                    </div>
                    <div class="form-group">
                        <label for="textarea" class="control-label">Check thoải mái đi ae - vì nó free mà   -Ae có thể bỏ vào gì vào cũng đc ,miễn đầu tiên là uid dạng 1000</label>
                        <!--<input class="form-control" id="ngancach" placeholder="Ký tự ngăn cách" value="|"></input>-->
                    </div>
                    <!--<div class="form-group">-->
                    <!--    <span class="nav-main-link-badge badge badge-pill badge-primary">Tổng: <b id="total">0</b></span>-->
                    <!--    <span class="nav-main-link-badge badge badge-pill badge-success">Live: <b id="live">0</b></span>-->
                    <!--    <span class="nav-main-link-badge badge badge-pill badge-danger">Die: <b id="die">0</b></span>-->
                    <!--</div>-->
                    
                    <div class="clearfix">
                        <div class="form-group text-center">
                            <button class="d-inline-block btn btn-hero-sm btn-hero-info" onclick="get_code_2fa();">Get Code 2FA</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="textarea" class="control-label">Mã Code</label>
                     <textarea wrap="off" class="form-control form-control-alt" id="listclonelive" name="example-textarea-input" rows="6" placeholder="Không có dữ liệu" style="font-size: 14px;"></textarea>
                    </div>
                    {{-- <div class="form-group">
                        <label for="textarea" class="control-label">UID DIE</label>
                      <textarea wrap="off" class="form-control form-control-alt is-invalid" id="listclonedie" name="example-textarea-input" rows="6" placeholder="Không có dữ liệu" style="font-size: 14px;"></textarea>
                    </div> --}}
                </div>
            </div>
            <div style="position: sticky; bottom: 0; margin-bottom: 0;">
           
            {{-- <span class="live badge badge-success" style="display: none;">Live: <span class="" id="live">0</span></span>
            <span class="die badge badge-danger" >Die: <span class="" id="die">0</span></span> --}}

            <!-- Animated -->
            {{-- <div class="progress push" style="position: sticky; bottom: 0px; margin-bottom: 0px;">
                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 200%;" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100">
                    <span class="font-size-sm font-w600">100%</span>
                </div>
            </div> --}}
            <!-- END Animated -->

        </div>
        </div>
    </div>
</div>


@endsection

@section('script')

<script>
    function get_code_2fa(){
        var key2fa = $('#key-2fa').val().trim();
        console.log("key2fa",key2fa);
        $.get(`https://2fa.live/tok/${key2fa}`, function(data, status){
            alert("Data: " + data + "\nStatus: " + status);
        });
    }

</script>
   
@endsection
