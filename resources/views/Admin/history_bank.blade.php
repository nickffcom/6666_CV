@extends('Layout.US.Index')
<style>
    th,
    td {
        text-align: center;
    }
</style>
@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="block block-rounded block-themed block-fx-pop">
                <div class="block-header bg-info">
                    <h3 class="block-title">
                        History Bank Của Tài Khoản 1016650160  =>>  {{$messageErr}}
                        <span style="width: 250px;">
                            <select id="status" class="form-control">
                                <option value="{{ CON_HANG }}">Hiển thị</option>
                                <option value="all">Hiển thị tất cả</option>
                            </select>
                        </span>
                    </h3>
                </div>
                <div class="block-content">
                    {{-- <div class="alert alert-danger">
                        Vui lòng chỉ cập nhật sản phẩm chứ không xóa sản phẩm, vì xóa sản phẩm khách hàng sẽ không thể
                        xem/check khi mua hoặc đã mua xong!
                    </div> --}}
                    @isset($banks)
                        
                   
                    <div class="table-responsive">
                        <table class="table table-hover table-vcenter">
                            <thead>
                                <tr>
                                    <th class="d-sm-table-cell">#</th>
                                    <th class="d-sm-table-cell">Id Transaction</th>
                                    <th class="d-sm-table-cell">Số Tiền</th>
                                    <th class="d-sm-table-cell">Description</th>
                                    <th class="d-sm-table-cell">TransactionDate</th>
                                    <th class="d-sm-table-cell">Cộng / Trừ Tiền</th>
                                    <th class="d-sm-table-cell">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($banks as $key => $item)
                                
                                    <tr id="tr{{ $key }}">
                                        <td class="d-sm-table-cell">{{ $key }}</td>
                                        <td class="d-sm-table-cell">{{ $item['Reference'] }}</td>
                                        <td class="d-sm-table-cell">
                                            
                                            {{ $item['Amount'] }}
   
                                        </td>
                                        <td class="d-sm-table-cell">
                                            <textarea name="des" id="" cols="20" rows="5">
                                                {{ $item['Description'] }}
                                            </textarea>
                                        </td>
                                        <td class="d-sm-table-cell"><span class="badge badge-success">{{ $item['TransactionDate'] }}</span></td>
                                        <td class="d-sm-table-cell">
                                        @if($item['CD']  == "+")
                                            Cộng tiền
                                        @elseif($item['CD']  == "-")
                                            Trừ tiền
                                        @endif
                                        </td>
                                        <td class="d-sm-table-cell">
                                          
                                        <td class="d-sm-table-cell">
                                            {{-- <button data-update="{{ $item['id'] }}" class="btn btn-info"><i
                                                    class="fa fa-edit"></i></button>
                                            <button data-delete="{{ $item['id'] }}" class="btn btn-danger"><i
                                                    class="fa fa-times"></i></button> --}}
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    @endisset
                    <br>
                    <div style="display: table; margin:0 auto;">
                        <nav>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-update-data" tabindex="-1" role="dialog" aria-labelledby="modal-block-fadein" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Cập nhật</h3>
                        <div class="block-options"></div>
                    </div>
                    <div class="block-content">
                        <form action="" id="update_data" method="POST">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <input type="hidden" name="t" value="update">
                            <input type="hidden" name="id">
                         
                            <button type="submit" class="btn btn-info btn-block"><i class="fa fa-check"></i> Lưu</button>
                        </form><br>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

@endsection
