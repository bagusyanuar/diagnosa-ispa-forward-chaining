@extends('admin.layout')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-1">
        <div>
            <p class="content-title">Laporan Konsultasi</p>
            <p class="content-sub-title">Daftar data laporan konsultasi pasien</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">laporan konsultasi</li>
            </ol>
        </nav>
    </div>
    <div class="card-content">
        <div class="content-header mb-3">
            <p class="header-title">Data Laporan Konsultasi</p>
        </div>
        <hr class="custom-divider"/>
        <div class="w-100">
            <label for="filter" class="form-label input-label">Filter Tanggal</label>
            <div class="d-flex align-items-center justify-content-center w-50 gap-1">
                <input type="date" class="text-input" id="start" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                       name="start">
                <span style="font-weight: 600; color: var(--dark); font-size: 0.8em;">s/d</span>
                <input type="date" class="text-input" id="end" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                       name="end">
                <a href="#" class="btn-add" id="btn-search">
                    <i class='bx bx-search'></i>
                    <span>Cari</span>
                </a>
                <a href="#" class="btn-print" id="btn-print">
                    <i class='bx bx-printer'></i>
                    <span>Cetak</span>
                </a>
            </div>

        </div>
        <hr class="custom-divider"/>
        <table id="table-data" class="display table w-100">
            <thead>
            <tr>
                <th width="5%" class="text-center">#</th>
                <th width="15%" class="text-center">No. Konsultasi</th>
                <th width="12%" class="text-center">Tanggal</th>
                <th width="15%" class="text-center">Nama Pasien</th>
                <th>Gejala</th>
                <th>Diagnosa</th>
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
                    'data': function (d) {
                        d.start = $('#start').val();
                        d.end = $('#end').val();
                    }
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
                        data: 'no_konsultasi',
                        className: 'middle-header text-center',
                    },
                    {
                        data: 'tanggal',
                        className: 'middle-header text-center',
                    },
                    {
                        data: 'user.pasien.nama',
                        className: 'middle-header text-center',
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
                        className: 'middle-header',
                        render: function (data) {
                            let arrPenyakit = data['penyakit'];
                            if (arrPenyakit.length > 0) {
                                let result = '';
                                $.each(arrPenyakit, function (k, v) {
                                    let penyakit = v['penyakit'];
                                    result += penyakit['nama'] + ' ('+v['persentase']+'%), ';
                                });
                                return result;
                            }
                            return '-';
                        }
                    },
                ],
            });
        }


        $(document).ready(function () {
            generateTable();

            $('#btn-search').on('click', function (e) {
                e.preventDefault();
                table.ajax.reload();
            });
            $('#btn-print').on('click', function (e) {
                e.preventDefault();
                let start = $('#start').val();
                let end = $('#end').val();
                window.open('/admin/laporan-konsultasi/cetak?start=' + start + '&end=' + end, '_blank');
            })


        })
    </script>
@endsection
