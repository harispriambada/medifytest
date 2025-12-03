<!DOCTYPE html>
<html>

<head>
    <title>Detail Kategori {{ $category->nama }}</title>
    <style>
        body {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            font-size: 12px;
            text-align: right;
        }
    </style>
</head>

<body>

    <h2>Detail Kategori</h2>
    <p><strong>Kode:</strong> {{ $category->kode }}</p>
    <p><strong>Nama:</strong> {{ $category->nama }}</p>

    <h4>Items</h4>
    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Supplier</th>
                <th>Harga Beli</th>
                <th>Laba (%)</th>
                <th>Harga Jual</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->supplier }}</td>
                    <td>{{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                    <td>{{ $item->laba }}</td>
                    <td>{{ number_format($item->harga_beli + ($item->harga_beli * $item->laba) / 100, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ $printDate }}
    </div>

</body>

</html>
