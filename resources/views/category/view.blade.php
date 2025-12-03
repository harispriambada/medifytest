@extends('layouts.app')

@section('content')
    <h3>Detail Kategori</h3>

    <p><strong>Kode:</strong> {{ $category->kode }}</p>
    <p><strong>Nama:</strong> {{ $category->nama }}</p>

    <h4>Items</h4>
    {{-- untuk cetak pdf --}}
    <a href="{{ route('category.pdf', $category->id) }}" class="btn btn-primary" target="_blank">
        Cetak PDF
    </a>
    <table class="table table-striped">
        <tr>
            <th>Kode</th>
            <th>Nama</th>
            <th>Supplier</th>
        </tr>
        @foreach ($items as $item)
            <tr>
                <td>{{ $item->kode }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->supplier }}</td>
            </tr>
        @endforeach
    </table>
@endsection
