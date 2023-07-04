<!-- invoice.blade.php -->

<!DOCTYPE html>
<html>

<head>
    <title>Invoice</title>
    <style>
        /* Gaya invoice */
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .invoice-info .left {
            font-weight: bold;
        }

        .invoice-info .right {
            text-align: right;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        .table th {
            background-color: #f0f0f0;
        }

        .total {
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>

<body onload="window.print();">
    <div class="container">
        <div class="header">
            <h1>Invoice</h1>
        </div>

        <div class="invoice-info">
            <div class="left">
                <p>Invoice: {{ $transaksi->invoice }}</p>
                <p>Tanggal: {{ $transaksi->created_at }}</p>
            </div>
            <div class="right">
                <p>Nama: {{ $transaksi->user->name }}</p>
                <p>No Telepon: {{ $transaksi->user->no_telepon }}</p>
            </div>
        </div>

        <table class="table">
            <tr>
                <th>Jenis Pakaian</th>
                <th>Berat</th>
                <th>Selesai</th>
                <th>Total</th>
            </tr>
                <tr>
                    <td>{{ $transaksi->jenis_pakaian->jenis_pakaian }}</td>
                    <td>{{ $transaksi->berat }}</td>
                    <td>{{ $transaksi->tgl_selesai }}</td>
                    <td>{{ $transaksi->harga }}</td>
                </tr>
            
            <tr class="total">
                <td colspan="3">Total</td>
                <td>{{ $transaksi->harga }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
