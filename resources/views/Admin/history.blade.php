@extends('Layout.AD.index')

@section('content')
    

<div class="row justify-content-center">
    <div class="col-12">
        <div class="block block-rounded block-themed block-fx-pop">
            <div class="block-header bg-info">
                <h3 class="block-title"><i class="fa fa-history"></i> Hoạt động</h3>
            </div>
            <div class="block-content">
                <div class="table-responsive">
                    <table class="table table-hover table-vcenter">
                        <thead>
                            <tr>
                                <th class="d-sm-table-cell">#</th>
                                <th class="d-sm-table-cell">Tài khoản</th>
                                <th class="d-sm-table-cell">Hoạt động</th>
                                <th class="d-sm-table-cell">Số tiền</th>
                                <th class="d-sm-table-cell">Thời gian</th>
                                <th class="d-sm-table-cell">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                         
                            @foreach($lists as $k=>$x)
                            <tr>
                                <td class="d-sm-table-cell">{{   ($k + 1) }}</td>
                                <td class="d-sm-table-cell">{{  $x['username'] }}</td>
                                <td class="d-sm-table-cell">{{  $x['content'] }}</td>
                             
                                <td class="d-sm-table-cell"><span class="badge badge-success">{{ number_format( $x['total_money']) }} </span></td>

                                <td class="d-sm-table-cell" data-toggle="tooltip" title="{{  date('H:i:s - d/m/Y', strtotime($x['created_at'])) }}">{{   date('H:i:s - d/m/Y', strtotime($x['created_at'])) }}</td>
                                <td class="d-sm-table-cell">
                                	<button data-delete="{{  $x['id'] }}" class="btn btn-danger"><i class="fa fa-times"></i></button>
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
@endsection

@section('script')
<script>
    $('[data-delete]').bind('click', function () {
    	if (confirm('Chắc chắn xóa lịch sử này ?')) {
    		$that = $(this);
	    	$id = $that.data('delete');
	    	$.post('/admin/action', {t: 'delete_history', id: $id}, function (a) {
	    		if (a.status > 0) {
	    			$that.parent().parent().fadeOut();
	    		}
	    		showNotify((a.status > 0 ? 'success' : 'error'), a.message);
	    	});
    	}
    });
    $(function () {
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
                // 'infoEmpty': 'Không tìm thấy kết quả...',
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
            'columnDefs': [
               {
                   'type': 'input',
                   'targets': [1, 2, 3]
               }
            ]
        });
    });
</script>
@endsection