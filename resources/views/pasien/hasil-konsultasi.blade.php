@extends('pasien.layout')

@section('content')
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
    @foreach($results as $result)
        <div>{{ $result['nama'] }}</div>
    @endforeach
@endsection
