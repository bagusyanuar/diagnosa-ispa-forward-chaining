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
                window.location.href = '{{ route('admin.dokter') }}';
            })
        </script>
    @endif
    <div class="d-flex justify-content-between align-items-center mb-1">
        <div>
            <p class="content-title">Dokter</p>
            <p class="content-sub-title">Manajemen data dokter</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.dokter') }}">Dokter</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah</li>
            </ol>
        </nav>
    </div>
    <div class="card-content">
        <form method="post" id="form-data">
            @csrf
            <div class="w-100 mb-3">
                <label for="username" class="form-label input-label">Username <span
                        class="color-danger">*</span></label>
                <input type="text" placeholder="username" class="text-input" id="username"
                       name="username">
                @if($errors->has('username'))
                    <span id="username-error" class="input-label-error">
                        {{ $errors->first('username') }}
                    </span>
                @endif
            </div>
            <div class="w-100 mb-3">
                <label for="name" class="form-label input-label">Nama Dokter <span
                        class="color-danger">*</span></label>
                <input type="text" placeholder="nama dokter" class="text-input" id="name"
                       name="name">
                @if($errors->has('name'))
                    <span id="name-error" class="input-label-error">
                        {{ $errors->first('name') }}
                    </span>
                @endif
            </div>
            <div class="w-100 mb-3">
                <label for="password" class="form-label input-label">Password <span
                        class="color-danger">*</span></label>
                <input type="password" placeholder="password" class="text-input" id="password"
                       name="password">
                @if($errors->has('password'))
                    <span id="password-error" class="input-label-error">
                        {{ $errors->first('password') }}
                    </span>
                @endif
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
