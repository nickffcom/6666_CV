@extends('Layout.US.Index')
<style>
    th,
    td {
        text-align: center;
    }
</style>
@section('content')
<textarea class="description" name="description"></textarea>
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="block block-rounded block-themed block-fx-pop">
                <div class="block-header bg-info">
                    <h3 class="block-title">
                        Các bản ghi website Ads69.Net {{ mb_strtoupper($type) }}
                        <span style="width: 250px;">
                            <select id="status" class="form-control">
                                <option value="{{ CON_HANG }}">Hiển thị sản phẩm chưa bán</option>
                                <option value="all">Hiển thị tất cả</option>
                            </select>
                        </span>
                    </h3>
                </div>
                <script>
                    $('#status').bind('change', function() {
                        
                     
                            window.location.href ='{{$type}}?status=' + $(this).val();
                        
                    });
                </script>
                <div class="block-content">
                    {{-- <div class="alert alert-danger">
                        Vui lòng chỉ cập nhật sản phẩm chứ không xóa sản phẩm, vì xóa sản phẩm khách hàng sẽ không thể
                        xem/check khi mua hoặc đã mua xong!
                    </div> --}}
                    @isset($logs)
                        
                   
                    <div class="table-responsive">
                        <table class="table table-hover table-vcenter">
                            <thead>
                                <tr>
                                    <th class="d-sm-table-cell">#</th>
                                    <th class="d-sm-table-cell">Name</th>
                                    <th class="d-sm-table-cell">Description</th>
                                    <th class="d-sm-table-cell">Var_dump</th>
                                    <th class="d-sm-table-cell">Level</th>
                                    <th class="d-sm-table-cell">User ???</th>
                                    <th class="d-sm-table-cell">Thời gian</th>
                                    <th class="d-sm-table-cell">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($logs as $key => $item)
                                
                                    <tr>
                                        <td class="d-sm-table-cell">{{ $item->id }}</td>
                                        <td class="d-sm-table-cell">{{ $item->name }}</td>
                                        <td class="d-sm-table-cell">
                                            <textarea id="w3review" name="w3review" rows="5" cols="20">
                                            {{ $item->description }}
                                            </textarea>
                                        </td>
                                        <td class="d-sm-table-cell">{{ $item->var_dump }} VNĐ</td>
                                        <td class="d-sm-table-cell"><span class="badge badge-success">{{ $item->level }}</span></td>
                                        <td class="d-sm-table-cell">{{ $item->user_id }}</td>
                                        <td class="d-sm-table-cell">
                                            <?= date('H:i:s - d/m/Y', strtotime($item->updated_at)) ?></td>
                                        <td class="d-sm-table-cell">
                                            <button data-update="{{ $item['id'] }}" class="btn btn-info"><i
                                                    class="fa fa-edit"></i></button>
                                            <button data-delete="{{ $item['id'] }}" class="btn btn-danger"><i
                                                    class="fa fa-times"></i></button>
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
                        <h3 class="block-title">Cập nhật sản phẩm</h3>
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
{{-- <script src="{{ asset('tinymce/tinymce.js') }}"></script>
<script> --}}
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js"></script>   
<script>
tinymce.init({
    selector:'textarea.description',
    width: 900,
    height: 300
});
</script>
</script>
    <script>
        $('[data-delete]').bind('click', function() {
            if (confirm('Chắc chắn xóa này ?')) {
                $that = $(this);
                $id = $that.data('delete');
                let idnek = $that.data('delete');
                 $.ajax({
                url: `/admin/{{ $type}}/${idnek}`,
                type: 'DELETE',
                data:$('form#update_data').serialize(),
                success: function (result) {
                    showNotify((result.status == true ? 'success' : 'error'), result.message);
                }
            });
    	}
        });
        $('[data-update]').bind('click', function() {
            $that = $(this);
            $id = $that.data('update');
            let idnek = $that.data('update')
            $.get(`/admin/{{ $type }}/${idnek}`,function(a) {
                 $('form#update_data').find('[name="id"]').val(a.id);
                $.each(a.attr, (k, v) => {
                    $('form#update_data').find('[name="' + k + '"]').val(v);
                });
                $('#modal-update-data').modal('show');
            });
        });
        $('form#update_data').bind('submit', function(e) {
            let idnek= $('form#update_data input[name=id]').val();
            $.ajax({
            url: `/admin/{{ $type}}/${idnek}`,
            type: 'PATCH',
            data:$('form#update_data').serialize(),
            success: function (result) {
                showNotify((result.status == true ? 'success' : 'error'), result.message);
            }
        });
            e.preventDefault();
        });
        $(function() {
            $('table').DataTable({
                'charset': 'utf8',
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': true,
                'responsive': true,
                'order': [
                    [0, 'desc']
                ],
                'pageLength': 25,
                'lengthMenu': [
                    [5, 10, 25, 50, 100, 200, 500, 1000, -1],
                    [5, 10, 25, 50, 100, 200, 500, 1000, 'Tất cả']
                ],
                'language': {
                    'info': 'Hiển trị trang _PAGE_ trong tổng _PAGES_ trang',
                    'searchPlaceholder': 'Nội dung...',
                    'search': 'Tìm kiếm :',
                    'zeroRecords': 'Không tìm thấy kết quả...',
                    'infoEmpty': 'Không tìm thấy kết quả...',
                    'lengthMenu': 'Hiển thị _MENU_ kết quả',
                    'infoFiltered': ''
                },
                'paginate': {
                    'first': 'Đầu',
                    'last': 'Cuối',
                    'next': 'Tiếp',
                    'previous': 'Trước'
                },
                'columnDefs': [{
                    'type': 'input',
                    'targets': [1, 2, 3]
                }]
            });
        });
    </script>
@endsection
