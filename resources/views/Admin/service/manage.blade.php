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
                        Danh sách sản phẩm {{ mb_strtoupper($type) }}
                        <span style="width: 250px;">
                            <select id="status" class="form-control">
                                <option value="{{ CON_HANG }}"<?= $_GET['status'] == 1 ? 'selected' : '' ?>>Hiển thị sản
                                    phẩm đã bán</option>
                                <option value="{{ HET_HANG }}"<?= $_GET['status'] == 0 ? 'selected' : '' ?>>Hiển thị sản
                                    phẩm chưa bán</option>
                                <option value="all"<?= $_GET['status'] == 'all' ? 'selected' : '' ?>>Hiển thị tất cả
                                </option>
                            </select>
                        </span>
                    </h3>
                </div>
                <script>
                    $('#status').bind('change', function() {
                        window.location.href = '?type=<?= $type ?>&status=' + $(this).val();
                    });
                </script>
                <div class="block-content">
                    <div class="alert alert-danger">
                        Vui lòng chỉ cập nhật sản phẩm chứ không xóa sản phẩm, vì xóa sản phẩm khách hàng sẽ không thể
                        xem/check khi mua hoặc đã mua xong!
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-vcenter">
                            <thead>
                                <tr>
                                    <th class="d-sm-table-cell">#</th>
                                    <th class="d-sm-table-cell">UID</th>
                                    <th class="d-sm-table-cell">Loại</th>
                                    <th class="d-sm-table-cell">Giá</th>
                                    <th class="d-sm-table-cell">Trạng thái</th>
                                    <th class="d-sm-table-cell">Thời gian</th>
                                    <th class="d-sm-table-cell">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($listData as $key => $item)
                                
                                    <tr>
                                        <td class="d-sm-table-cell">{{ $key + 1 }}</td>
                                        <td class="d-sm-table-cell">{{ $item->attr->uid }}</td>
                                        <td class="d-sm-table-cell">{{ $item->service->name }}</td>
                                        <td class="d-sm-table-cell">{{ number_format($item->price) }} VNĐ</td>
                                        @if ($item->status == CON_HANG)
                                            <td class="d-sm-table-cell"> <span class="badge badge-danger">Chưa bán</span>
                                            </td>
                                        @else
                                            <td class="d-sm-table-cell"><span class="badge badge-success">Đã bán</span></td>
                                        @endif
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
                    </div><br>
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
                            <input type="hidden" name="t" value="update">
                            <input type="hidden" name="id">
                            @foreach (explode('|', FORMAT_UPDATE[$type]) as $key => $value)
                            <div class="form-group">
                                <label>{{ mb_strtoupper($value) }} :</label>
                                <input type="text" name="{{ $value }}" class="form-control">
                            </div>
                            @endforeach
                            <button type="submit" class="btn btn-info btn-block"><i class="fa fa-check"></i> Lưu</button>
                        </form><br>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $('[data-delete]').bind('click', function() {
            if (confirm('Chắc chắn xóa này ?')) {
                $that = $(this);
                $id = $that.data('delete');
                $.post(api('admin/action_data'), {
                    t: 'delete',
                    id: $id
                }, function(a) {
                    if (a.status > 0) {
                        $that.parent().parent().fadeOut();
                    }
                    showNotify((a.status > 0 ? 'success' : 'error'), a.message);
                });
            }
        });
        $('[data-update]').bind('click', function() {
            $that = $(this);
            $id = $that.data('update');
            let idnek = $that.data('update')
            console.log("id",idnek);
            $.get(`/admin/{{ $type }}/${idnek}`,function(a) {
                console.log("a",a);
                $.each(a.attr, (k, v) => {
                    console.log("a=>>attr",a.attr);
                    console.log("k",k);
                    console.log("v",v);
                    $('form#update_data').find('[name="' + k + '"]').val(v);
                });
                $('#modal-update-data').modal('show');
            });
            // $('#modal-update-data').modal('show'); [name="id"]  [name="password"]
        });
        $('form#update_data').bind('submit', function(e) {
            
            $.post(api('admin/action_data'), $(this).serializeArray(), function(a) {
                showNotify((a.status > 0 ? 'success' : 'error'), a.message);
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
