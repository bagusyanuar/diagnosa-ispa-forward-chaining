@extends('pasien.layout')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <p class="content-title">Riwayat Konsultasi</p>
            <p class="content-sub-title">Halaman Riwayat Konsultasi</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item active" aria-current="page">Riwayat Konsultasi</li>
            </ol>
        </nav>
    </div>
    <div class="card-content">
        <div class="content-header mb-3">
            <p class="header-title">Data Gejala</p>
            <a href="{{ route('admin.gejala.add') }}" class="btn-add">
                <i class='bx bx-plus'></i>
                <span>Tambah Gejala</span>
            </a>
        </div>
        <hr class="custom-divider"/>
        <table id="table-data" class="display table w-100">
            <thead>
            <tr>
                <th width="5%" class="text-center">#</th>
                <th width="10%">Tanggal</th>
                <th width="15%">No. Konsultasi</th>
                <th>Gejala</th>
                <th width="10%" class="text-center">Aksi</th>
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
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false,
                        className: 'text-center middle-header',
                    },
                    {
                        data: 'tanggal',
                        className: 'middle-header',
                    },
                    {
                        data: 'no_konsultasi',
                        className: 'middle-header',
                    },
                    {
                        data: null,
                        className: 'middle-header',
                        render: function (data) {
                            let arrGejala = data['gejala'];
                            if (arrGejala.length > 0) {
                                let result = '';
                                $.each(arrGejala, function (k, v) {
                                    let gejala = v['gejala'];
                                    result += gejala['nama'] + ', ';
                                });
                                return result;
                            }
                            return '-';
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        className: 'text-center middle-header',
                        render: function (data) {
                            let id = data['id'];
                            let urlEdit = path + '/' + id + '/edit';
                            return '<div class="w-100 d-flex justify-content-center align-items-center gap-1">' +
                                '<a href="#" class="btn-table-action-delete" data-id="' + id + '"><i class="bx bx-trash"></i></a>' +
                                '<a href="' + urlEdit + '" class="btn-table-action-edit"><i class="bx bx-edit-alt"></i></a>' +
                                '</div>';
                        }
                    }
                ],
            });
        }


        $(document).ready(function () {
            generateTable();
        })
    </script>
@endsection
