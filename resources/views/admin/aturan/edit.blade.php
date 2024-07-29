@extends('admin.layout')

@section('content')
    @if (\Illuminate\Support\Facades\Session::has('failed'))
        <script>
            Swal.fire("Ooops", '{{ \Illuminate\Support\Facades\Session::get('failed') }}', "error")
        </script>
    @endif
    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            Swal.fire({
                title: 'Success',
                text: '{{ \Illuminate\Support\Facades\Session::get('success') }}',
                icon: 'success',
                timer: 700
            }).then(() => {
                window.location.reload();
            })
        </script>
    @endif
    <div class="d-flex justify-content-between align-items-center mb-1">
        <div>
            <p class="content-title">Aturan Diagnosa</p>
            <p class="content-sub-title">Manajemen data aturan diagnosa</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.aturan') }}">Aturan Diagnosa</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $data->nama }}</li>
            </ol>
        </nav>
    </div>
    <div class="card-content">
        <div class="content-header mb-3">
            <p class="header-title">Aturan Diagnosa Penyakit {{ $data->nama }}</p>
        </div>
        <hr class="custom-divider"/>
        <form method="post" id="form-data">
            @csrf
            <div class="row mb-3">
                <div class="col-6">
                    <div class="w-100">
                        <label for="gejala" class="form-label input-label">Gejala <span
                                class="color-danger">*</span></label>
                        <select id="gejala" name="gejala" class="text-input">
                            @foreach($gejalas as $key => $gejala)
                                <option value="{{ $gejala->id }}">{{ $gejala->nama }} ({{ $key+1 }})</option>
                            @endforeach
                        </select>
                        @if($errors->has('gejala'))
                            <span id="gejala-error" class="input-label-error">
                                {{ $errors->first('gejala') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-6">
                    <div class="w-100">
                        <label for="weight" class="form-label input-label">Gejala <span
                                class="color-danger">*</span></label>
                        <input type="number" placeholder="" value="0" class="text-input" id="weight"
                               name="weight">
                        @if($errors->has('weight'))
                            <span id="name-error" class="input-label-error">
                                {{ $errors->first('weight') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <hr class="custom-divider"/>
            <div class="d-flex align-items-center justify-content-end w-100">
                <a href="#" class="btn-add" id="btn-save">
                    <span>Tambah</span>
                </a>
            </div>
        </form>
        <hr class="custom-divider"/>
        <p class="header-title" style="font-size: 0.8em; font-weight: 600;">Data Aturan</p>
        <hr class="custom-divider"/>
        <table id="table-data" class="display table w-100">
            <thead>
            <tr>
                <th width="5%" class="text-center">#</th>
                <th>Gejala</th>
                <th width="12%" class="text-center">Bobot</th>
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
                },
                "aaSorting": [],
                "order": [],
                scrollX: true,
                responsive: true,
                paging: true,
                "fnDrawCallback": function (setting) {
                    eventDelete();
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
                        data: 'gejala.nama',
                        className: 'middle-header',
                    },
                    {
                        data: 'bobot',
                        className: 'middle-header text-center',
                    },
                    {
                        data: null,
                        orderable: false,
                        className: 'text-center middle-header',
                        render: function (data) {
                            let id = data['id'];
                            return '<div class="w-100 d-flex justify-content-center align-items-center gap-1">' +
                                '<a href="#" class="btn-table-action-delete" data-id="' + id + '"><i class="bx bx-trash"></i></a>' +
                                '</div>';
                        }
                    }
                ],
            });
        }

        function eventSave() {
            $('#btn-save').on('click', function (e) {
                e.preventDefault();
                AlertConfirm('Konfirmasi!', 'Apakah anda yakin ingin menambah aturan?', function () {
                    $('#form-data').submit();
                })
            })
        }

        function eventDelete() {
            $('.btn-table-action-delete').on('click', function (e) {
                e.preventDefault();
                let id = this.dataset.id;
                AlertConfirm('Konfirmasi', 'Apakah anda yakin ingin menghapus data?', function () {
                    let url = path + '/' + id + '/delete';
                    BaseDeleteHandler(url, id);
                })
            })
        }

        $(document).ready(function () {
            generateTable();
            eventSave();
        })
    </script>
@endsection
