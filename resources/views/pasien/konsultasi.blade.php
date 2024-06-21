@extends('pasien.layout')

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
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <p class="content-title">Konsultasi</p>
            <p class="content-sub-title">Halaman Konsultasi Penyakit</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item active" aria-current="page">Konsultasi</li>
            </ol>
        </nav>
    </div>
    <div class="w-100 mb-1">
        <p style="color: var(--dark); font-size: 1.25em; font-weight: bold; text-align: center; margin-bottom: 5px;">
            SELAMAT DATANG DI
            HALAMAN KONSULTASI PENYAKIT ISPA
        </p>
        <p style="color: var(--dark-tint); font-weight: 600; font-size: 0.8em; text-align: center;">
            Silahkan memilih
            gejela - gejala yang anda alami
        </p>
    </div>
    <form id="form-data" method="post">
        @csrf
        <div class="w-100 row" style="border: 1px solid var(--dark); border-radius: 12px; padding: 1rem 2rem;">
            @foreach($gejalas as $gejala)
                <div class="col-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input gejala" type="checkbox" name="gejala[]"
                               id="gejala-{{ $gejala->id }}"
                               value="{{ $gejala->id }}">
                        <label class="form-check-label" for="gejala-{{ $gejala->id }}"
                               style="font-size: 0.8em; color: var(--dark);">
                            {{ $gejala->nama }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
        <hr class="custom-divider"/>
        <div class="d-flex align-items-center justify-content-end w-100">
            <a href="#" class="btn-add" id="btn-save">
                <i class='bx bx-check'></i>
                <span>Konsultasi</span>
            </a>
        </div>
    </form>
@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        function eventSave() {
            $('#btn-save').on('click', function (e) {
                e.preventDefault();
                AlertConfirm('Konfirmasi!', 'Apakah anda yakin ingin mengajukan konsultasi?', function () {
                    $('#form-data').submit();
                })
            })
        }

        $(document).ready(function () {
            eventSave();
        })
    </script>
@endsection
