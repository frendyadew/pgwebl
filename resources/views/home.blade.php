@extends('layouts/template')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-body text-center">
            <h1 class="display-4 mb-3" style="color: #2d6a4f;">
                @auth
                    Selamat Datang, {{ Auth::user()->name }}
                @else
                    Selamat Datang, Tamu
                @endauth
                <span style="color: #40916c;">PGWEBL UGM</span>
            </h1>
            <p class="lead mb-4">Website Praktikum Pemrograman Web Lanjut Universitas Gadjah Mada</p>
            <hr>
            @auth
            <div class="mt-4">
                <h5>Profil Mahasiswa</h5>
                <ul class="list-unstyled">
                    <li><strong>Nama:</strong> Frendy Ade Wicaksono</li>
                    <li><strong>NIM:</strong> 23/523180/SV/23868</li>
                    <li><strong>Kelas:</strong> A</li>
                </ul>
            </div>
            @endauth
            <div class="mt-4">
                <span class="badge bg-success fs-6">Selamat belajar dan semoga sukses!</span>
            </div>
        </div>
    </div>
</div>
@endsection
