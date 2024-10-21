@extends('admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Permohonan</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Instansi</th>
                <th>Tanggal Terkirim</th>
                <th>Kategori</th>
                <th>Kode E-Office</th>
                <th>Keterangan</th>
                <th>Aksi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $index => $request)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $request->instansi }}</td>
                    <td>{{ $request->date }}</td>
                    <td>{{ $request->category }}</td>
                    <td>{{ $request->codeOffice }}</td>
                    <td>{{ $request->description }}</td>
                    <td>
                        <form action="{{ route('admin.requests.accept', $request->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-success">Terima</button>
                        </form>

                        <form action="{{ route('admin.requests.reject', $request->id) }}" method="POST" class="mt-2">
                            @csrf
                            <button class="btn btn-danger">Tolak</button>
                        </form>

                        <form action="{{ route('admin.requests.delete', $request->id) }}" method="POST" class="mt-2">
                            @csrf
                            <button class="btn btn-warning">Hapus</button>
                        </form>
                    </td>
                    <td>{{ $request->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
