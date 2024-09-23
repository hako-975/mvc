<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
            margin: 0;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            page-break-inside: auto;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        th, td {
            page-break-inside: avoid;
            page-break-after: auto;
            border: 1px solid #ccc;
            padding: 8px 12px;
            text-align: left;
        }
        
        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .col {
            width: 50%; /* Adjust as needed */
        }

    </style>
</head>
<body>
    <h2><?= (isset($tanggal_laporan)) ? $tanggal_laporan : $title; ?></h2>
    <div class="row">
        <div class="col">
            <strong>Kecamatan:</strong> <?= (isset($nama_kecamatan)) ?  $nama_kecamatan : 'Semua'; ?>
        </div>
        <div class="col">
            <strong>Jenis Laporan:</strong> <?= (isset($jenis_laporan)) ?  $jenis_laporan : 'Semua'; ?>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <strong>Kelurahan:</strong> <?= (isset($nama_kelurahan)) ?  $nama_kelurahan : 'Semua'; ?>
        </div>
        <div class="col">
            <strong>Status Laporan:</strong> <?= (isset($status_laporan)) ?  $status_laporan : 'Semua'; ?>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Status Laporan</th>
                <th>Judul Laporan</th>
                <th>Tanggal Laporan</th>
                <th>Kelurahan/Desa</th>
                <th>Bidang</th>
                <th>Jenis Laporan</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php foreach ($laporan as $dl): ?>
                <tr>
                    <td><?= $i++; ?>.</td>
                    <td><?= $dl['status_laporan']; ?></td>
                    <td><?= $dl['judul_laporan']; ?></td>
                    <td><?= date('d-M-Y H:i', strtotime($dl['tgl_laporan'])); ?></td>
                    <td><?= $dl['nama_kelurahan']; ?></td>
                    <td><?= $dl['nama_bidang']; ?></td>
                    <td><?= $dl['jenis_laporan']; ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
