<!DOCTYPE html>
<html>
<head>
    <title>Laporan Produksi</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 30px; }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h2>PT. METINCA PRIMA INDUSTRIAL WORKS</h2>
        <h3>Laporan Realisasi Produksi</h3>
        <p>Periode: {{ $startDate }} s/d {{ $endDate }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>No PO</th>
                <th>Customer</th>
                <th>Produk</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $index => $rpt)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $rpt->production_date }}</td>
                <td>{{ $rpt->salesOrder->po_number }}</td>
                <td>{{ $rpt->salesOrder->customer->name ?? '-' }}</td>
                <td>{{ $rpt->product->name ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>