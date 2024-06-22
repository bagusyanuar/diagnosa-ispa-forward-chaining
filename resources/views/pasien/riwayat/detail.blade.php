@extends('pasien.layout')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-1">
        <div>
            <p class="content-title">Riwayat Konsultasi</p>
            <p class="content-sub-title">Halaman Riwayat Konsultasi</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Gejala</li>
            </ol>
        </nav>
    </div>
    <div class="card-content">
        <div class="content-header mb-3">
            <p class="header-title">Data Riwayat Konsultasi</p>
        </div>
        <hr class="custom-divider"/>
        <div class="d-flex justify-content-between align-items-center">
            <div style="margin-bottom: 10px; font-size: 0.8em; font-weight: 600; color: var(--dark);">
                No. Konsultasi : {{ $data->no_konsultasi }}
            </div>
            <div style="margin-bottom: 10px; font-size: 0.8em; font-weight: 600; color: var(--dark);">
                Tanggal : {{ \Carbon\Carbon::parse($data->tanggal)->format('d F Y') }}
            </div>
        </div>
        <hr class="custom-divider"/>
        <p style="margin-bottom: 10px; font-size: 0.8em; font-weight: 600; color: var(--dark);">
            Daftar gejala yang dialami
        </p>
        <div>
            @foreach($data->gejala as $gejala)
                <p style="font-size: 0.8em; color: var(--dark); margin-bottom: 0">- {{ $gejala->gejala->nama }}</p>
            @endforeach
        </div>
        <hr class="custom-divider"/>
        <p style="margin-bottom: 10px; font-size: 1em; font-weight: 600; color: var(--dark); text-align: center">
            HASIL DIAGNOSA
        </p>
        <div>
            @foreach($data->penyakit as $penyakit)
                <p style="font-size: 1em; font-weight: 600; color: var(--dark); margin-bottom: 0; text-align: center;">
                    {{ $penyakit->penyakit->nama }} : {{ $penyakit->persentase }}%
                </p>
            @endforeach
        </div>
    </div>
@endsection
