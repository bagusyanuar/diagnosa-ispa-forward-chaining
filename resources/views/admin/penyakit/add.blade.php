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
            <p class="content-title">Penyakit</p>
            <p class="content-sub-title">Manajemen data penyakit</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.penyakit') }}">Penyakit</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah</li>
            </ol>
        </nav>
    </div>
    <div class="card-content">
        <form method="post" id="form-data">
            @csrf
            <div class="w-100 mb-3">
                <label for="name" class="form-label input-label">Nama Penyakit <span
                        class="color-danger">*</span></label>
                <input type="text" placeholder="nama penyakit" class="text-input" id="name"
                       name="name">
                @if($errors->has('name'))
                    <span id="name-error" class="input-label-error">
                        {{ $errors->first('name') }}
                    </span>
                @endif
            </div>
            <div class="w-100 mb-3">
                <label for="description" class="form-label input-label">Keterangan</label>
                <textarea rows="6" placeholder="Keterangan Penyakit" class="text-input" id="description"
                          name="description"></textarea>
            </div>
            <div class="w-100">
                <label for="prevention" class="form-label input-label">Pencegahan</label>
                <textarea rows="6" placeholder="Pencegahan" class="text-input" id="prevention"
                          name="prevention"></textarea>
            </div>
            <hr class="custom-divider"/>
            <div class="d-flex align-items-center justify-content-end w-100">
                <a href="#" class="btn-add" id="btn-save">
                    <i class='bx bx-check'></i>
                    <span>Simpan</span>
                </a>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        function eventSave() {
            $('#btn-save').on('click', function (e) {
                e.preventDefault();
                AlertConfirm('Konfirmasi!', 'Apakah anda yakin ingin menyimpan data?', function () {
                    $('#form-data').submit();
                })
            })
        }

        $(document).ready(function () {
            eventSave();
        })
    </script>
@endsection
