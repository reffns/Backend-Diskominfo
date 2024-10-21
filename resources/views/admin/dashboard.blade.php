{{-- resources/views/admin/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            width: 90%;
            margin: 0 auto;
            padding: 20px;
            background: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .table th {
            background-color: #4CAF50;
            color: white;
        }
        .button {
            padding: 8px 12px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .accept { background-color: #4CAF50; color: white; }
        .reject { background-color: #f44336; color: white; }
        .delete { background-color: #ff9800; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Aptika - Dashboard Admin</h1>
        <h2>Permohonan</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Instansi</th>
                    <th>Tanggal Dikirim</th>
                    <th>Kategori</th>
                    <th>Kode e-office</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->instansi }}</td>
                        <td>{{ $item->created_at->format('Y-m-d') }}</td>
                        <td>{{ $item->kategori }}</td>
                        <td>{{ $item->codeOffice }}</td>
                        <td>{{ $item->description }}</td>
                        <td>
                            <form action="{{ route('admin.accept', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="button accept">Terima</button>
                            </form>
                            <form action="{{ route('admin.reject', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="button reject">Tolak</button>
                            </form>
                            <form action="{{ route('admin.delete', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="button delete">Hapus</button>
                            </form>
                        </td>
                        <td>{{ $item->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
