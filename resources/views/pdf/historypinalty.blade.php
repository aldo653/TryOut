<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{$detail['mhs_name' ?? '-']}}</title>
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 12pt;
        }

        .kop {
            width: 100%;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .kop img {
            width: 80px;
            height: auto;
        }

        .kop .title {
            text-align: center;
            line-height: 1.2;
        }

        .kop .title h4,
        .kop .title h4 {
            margin: 0;
            font-weight: bold;
        }

        .kop .title .text {
            font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
            font-size: 10px;
        }

        .content {
            margin-top: 20px;
            text-align: justify;
            font-family: 'Times New Roman', Times, serif;
            font-size: 13px;
        }

        .content table.nilai {
            width: 100%;
            border-collapse: collapse;
            font-family: 'Times New Roman', Times, serif font-size: 13px;
            line-height: 1.2;
            text-align: center;
        }

        .content table.nilai th,
        .content table.nilai td {
            border: 1px solid #000;
            padding: 4px 6px;
            vertical-align: middle;
        }

        .content .ttd {
            margin-top: 30px;
            width: 180px;
            float: right;
            text-align: left;
            line-height: 1.3;
            font-size: 13px;
        }
    </style>
</head>

<body>
    <table class="kop">
        <tr>
            <td style="width: 100px;">
                <img src="{{ public_path('assets/img/logo_kemenag.png') }}" alt="Logo" style="width:110px;">
            </td>
            <td class="title">
                <h4>KEMENTERIAN AGAMA REPUBLIK INDONESIA</h4>
                <h4>UNIVERSITAS ISLAM NEGERI</h4>
                <h4>RADEN FATAH PALEMBANG</h4>
                <div class="text">Kampus Sudirman: Jl. Prof. K.H. Zainal Abidin Fikry, No.1, Km.3.5 Palembang 30126
                </div>
                <div class="text">Kampus Jakabaring: Jl. Pangeran Ratu, No. 475, Kel. 5 Ulu, Kec. Seberang Ulu I,
                    Palembang 30452</div>
                <div class="text">Telepon: (0711) 354668 Faximile (0711) 356209</div>
                <div class="text"><i>Website: www.radenfatah.ac.id</i></div>
            </td>
            <td style="width: 100px;">
                <img src="{{ public_path('assets/img/Logo UIN.png') }}" alt="Logo" style="width:110px;">
            </td>
        </tr>
    </table>
    <div class="content">
        <table style="margin-bottom: 10px;">
            <tr>
                <td>NIM</td>
                <td>: {{ $detail['nip_nim'] ?? '-' }}</td>
            </tr>
            <tr>
                <td>Nama Mahasiswa</td>
                <td>: {{ $detail['mhs_name'] ?? '-' }}</td>
            </tr>
        </table>

        <div><strong>Penilaian Kehadiran Kegiatan</strong></div><br />
        <table class="nilai">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kegiatan</th>
                    <th>Pengampu</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Poin Pengurangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detail['details'] as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_kegiatan ?? '-' }}</td>
                        <td>{{ $item->pengampu ?? '-' }}</td>
                        <td>{{ $item->deskripsi ?? '-' }}</td>
                        <td>{{ $item->status ?? '-' }}</td>
                        <td>{{ $item->poin_kegiatan ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table><br />

        <div><strong>Penilaian Holistik</strong></div><br />
        <table class="nilai">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis</th>
                    <th>Tipe</th>
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                    <th>Poin</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reward['rewards'] as $item)
                    <tr>
                        <td>{{ $loop->iteration ?? '-' }}</td>
                        <td>{{ $item->jenis ?? '-' }}</td>
                        <td>{{ $item->tipe ?? '-' }}</td>
                        <td>{{ $item->tgl ?? '-' }}</td>
                        <td>{{ $item->deskripsi ?? '-' }}</td>
                        <td>{{ $item->poin ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="ttd">
            <p>Palembang, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}
                <br />Mudir
            </p>
            <br><br><br> <!-- jarak untuk tanda tangan -->
            <p><strong><u>Drs. H. Jumhur, M.A.</u></strong><br />NIP. 1234567891011123</p>
        </div>

    </div>
</body>

</html>
