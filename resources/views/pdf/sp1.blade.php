<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    @if ($data['tipe'] == 'SP1')
        <title>Surat Peringatan 1 - {{ $mhs->name }}</title>
    @elseif($data['tipe'] == 'SP2')
        <title>Surat Peringatan 2 - {{ $mhs->name }}</title>
    @elseif($data['tipe'] == 'SP3')
        <title>Surat Peringatan 3 - {{ $mhs->name }}</title>
    @endif

    <style>
        @page {
            margin: 1.5cm;
        }

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
            line-height: 1.3;
        }

        .content .ttd {
            margin-top: 30px;
            width: 200px;
            float: right;
            text-align: left;
            line-height: 1.3;
            font-size: 13px;
        }

        span {
            line-height: 1.5;
        }

        p {
            text-indent: 1cm;
            /* bisa diatur sesuai selera */
            margin-top: 0;
            margin-bottom: 10px;
            text-align: justify;
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
        <table style="margin-top: 10px; margin-bottom: 10px;">
            <tr>
                <td>Nomor</td>
                <td>: {{ $data['no_surat'] }}</td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>: -</td>
            </tr>
            <tr>
                <td>Perihal</td>
                @if ($data['tipe'] == 'SP1')
                    <td>: Surat Panggilan 1</td>
                @elseif($data['tipe'] == 'SP2')
                    <td>: Surat Panggilan 2</td>
                @elseif($data['tipe'] == 'SP3')
                    <td>: Surat Panggilan 3</td>
                @endif

            </tr>
        </table><br />

        <span>Kepada Yth.</span><br>
        <span>{{ $mhs->name }} ({{ $mhs->nip_nim }})</span><br>
        <span>di Tempat</span><br>
        <br>

        <i>Assalamualaikum, wr.wb</i>
        <p>
            Sehubungan tata tertib Ma`had Al-Jamiah yang saudari lakukan yaitu <strong>{{ $data['alasan'] }}</strong>.
            Maka dengan ini kami meminta saudara untuk segera menghadap Mudir Ma`had Al-Jami`ah untuk
            memberikan penjelasan saudari terkait hal tersebut paling lambat pada tanggal
            <strong>{{ \Carbon\Carbon::parse($data['tenggat'])->locale('id')->translatedFormat('d F Y') }}</strong>.
        </p>
        @if ($data['tipe'] == 'SP1')
            <p>
                Apabila dalam batas waktu yang telah ditentukan tidak menghadap Mudir Ma`had Al Jamiah,
                maka kami akan mengeluarkan surat berikutnya.
            </p>
        @elseif($data['tipe'] == 'SP2')
            <p>
                Apabila dalam batas waktu yang telah ditentukan tidak menghadap Mudir Ma`had Al Jamiah, dengan
                didampingi Walisantri, maka kami akan mengeluarkan saudara dan akan mengembalikan saudara pada fakultas
                masing-masing dan BAK.
            </p>
        @endif

        <span>
            Demikian surat ini disampaikan atas perhatian dan kerjasamanya, kami ucapkan terima kasih.
        </span><br>
        <i>Waasalamu`alaikum Wr.Wb.</i>

        <div class="ttd">
            <span>Palembang, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}
                <br />Mudir
            </span>
            <br><br><br><br> <!-- jarak untuk tanda tangan -->
            <span><strong><u>Drs. H. Jumhur, M.A.</u></strong><br />NIP. 1234567891011123</span>
        </div>
    </div>
</body>

</html>
