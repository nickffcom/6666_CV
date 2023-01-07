<table class="table table-hover table-bordered table-vcenter">
    <thead>
        <tr>
            <th class="d-sm-table-cell text-center" style="width: 5%;">#</th>
            <th class="d-sm-table-cell text-center">Status</th>
            <th class="d-sm-table-cell text-center">Info {{ mb_strtoupper($type) }}</th>
        </tr>
    </thead>
    <tbody class="bm-list-data">
       
        @foreach ($lists as $k => $x)
            <tr>
                <td>{{ $k + 1 }}</td>
                <td><a href="#">OK</a></td>
                <td>{{ $x->attr->uid . '|' . $x->attr->pass . '|' . $x->attr->key2fa.'|' . $x->attr->email . '|' . $x->attr->passmail. '|'.$x->attr->note  }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
