@extends('layouts.app')

@section('content')
    <h3>Kategori</h3>

    <form class="mb-3">
        <input type="text" name="kode" placeholder="Filter kode">
        <input type="text" name="nama" placeholder="Filter nama">
        <button class="btn btn-primary">Filter</button>
    </form>

    <a href="{{ route('category.create') }}" class="btn btn-success">Tambah Kategori</a>

    <table class="table table-bordered mt-3">
        <tr>
            <th>Kode</th>
            <th>Nama</th>
            <th>Aksi</th>
        </tr>

        @foreach ($categories as $cat)
            <tr>
                <td>{{ $cat->kode }}</td>
                <td>{{ $cat->nama }}</td>
                <td>
                    <a href="{{ route('category.show', $cat->id) }}" class="btn btn-primary btn-sm">View</a>
                    <a href="{{ route('category.edit', $cat->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('category.destroy', $cat->id) }}" method="post" style="display:inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                    <a href="{{ route('category.pdf', $cat->id) }}" class="btn btn-primary" target="_blank">
                        Cetak PDF
                    </a>
                </td>
            </tr>
        @endforeach
    </table>

    {{ $categories->links() }}
@endsection
