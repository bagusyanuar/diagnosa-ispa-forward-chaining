@extends('admin.layout')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-1">
        <div>
            <p class="content-title">Pasien</p>
            <p class="content-sub-title">Daftar data pasen</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pasien</li>
            </ol>
        </nav>
    </div>
    <div class="card-content">
        <div class="content-header mb-3">
            <p class="header-title">Data Pasien</p>
        </div>
        <hr class="custom-divider"/>
        <table id="table-data" class="display table w-100">
            <thead>
            <tr>
                <th width="5%" class="text-center">#</th>
                <th width="15%" class="text-center">Username</th>
                <th width="15%" class="text-center">Nama</th>
                <th width="15%" class="text-center">Jenis Kelamin</th>
                <th>Alamat</th>
            </tr>
            </thead>
        </table>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        var path = '/{{ request()->path() }}';
        var table;

        function generateTable() {
            table = $('#table-data').DataTable({
                ajax: {
                    type: 'GET',
                    url: path,
                    // 'data': data
                },
                "aaSorting": [],
                "order": [],
                scrollX: true,
                responsive: true,
                paging: true,
                "fnDrawCallback": function (setting) {
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false, className: 'text-center middle-header',},
                    {
                        data: 'user.username',
                        className: 'middle-header text-center',
                    },
                    {
                        data: 'nama',
                        className: 'middle-header text-center',
                    },
                    {
                        data: 'jenis_kelamin',
                        className: 'middle-header text-center',
                    },
                    {
                        data: 'alamat',
                        className: 'middle-header',
                    },
                ],
            });
        }


        $(document).ready(function () {
            generateTable();
        })
    </script>
@endsection
