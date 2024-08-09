@extends('web.layout.master')

@section('body')
<div class="container">
    <h2>Tambah Perusahaan</h2>
    <form action="{{ route('perusahaan.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama_perusahaan">Nama Perusahaan:</label>
            <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan" required>
        </div>
        <div class="form-group">
            <label for="tanggal">Tanggal:</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection