<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; -webkit-text-size-adjust: none; background-color: #ffffff; color: #718096; height: 100%; line-height: 1.4; margin: 0; padding: 0; width: 100% !important;">
    <style>
        @media  only screen and (max-width: 600px) {
            .inner-body {
            width: 100% !important;
            }

            .footer {
            width: 100% !important;
            }
        }

        @media  only screen and (max-width: 500px) {
            .button {
            width: 100% !important;
            }
        }
    </style>
    <h2 style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; color: #3d4852; font-size: 19px; font-weight: bold; text-decoration: none; display: inline-block;">

    </h2>

    <table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; background-color: #ffffff; margin: 0; padding: 0; width: 100%;">
        <tr>
            <td align="center" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;">
                <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; margin: 0; padding: 0; width: 100%;">
                    <tr>
                        <td class="header" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; padding: 25px 0; text-align: center;">

                        </td>
                    </tr>

                <!-- Email Body -->
                <tr>
                    <td>
                        <div style="margin-left: 30px; line-height: 1em; color: black">
                            <p style="line-height: 3em">Assalamualaikum wbt & Salam Sejahtera.</p>
                            <p style="line-height: 2em">Tuan/Puan/Encik/Cik, {{ $nama_penerima }}.</p>
                            <p>{{ $pembuka }}</p>
                            <p>Tiket ID : <b>{{ $tiket_aduan }}</b></p>
                            @if(isset($nama_pengadu))<p>Pengadu : <b>{{ $nama_pengadu }}</b></p>@endif
                            @if(isset($lokasi_aduan))<p>Lokasi : <b>{{ $lokasi_aduan }}</b></p>@endif
                            @if(isset($kategori_aduan))<p>Kategori Aduan : <b>{{ $kategori_aduan }}</b></p>@endif
                            @if(isset($jenis_kerosakan))<p>Jenis Kerosakan : <b>{{ $jenis_kerosakan }}</b></p>@endif
                            @if(isset($sebab_kerosakan))<p>Sebab Kerosakan : <b>{{ $sebab_kerosakan }}</b></p>@endif
                            @if(isset($tarikh))<p>Tarikh Aduan : <b>{{ $tarikh }}</b></p>@endif
                            @if(isset($tarikh_serahan))<p>Tarikh Serahan : <b>{{ $tarikh_serahan }}</b></p>@endif
                            @if(isset($tarikh_selesai))<p>Tarikh Selesai : <b>{{ $tarikh_selesai }}</b></p>@endif
                            @if(isset($tarikh_pembatalan))<p>Tarikh Pembatalan : <b>{{ $tarikh_pembatalan }}</b></p>@endif
                            @if(isset($sebab_pembatalan))<p>Sebab Pembatalan : <b>{{ $sebab_pembatalan }}</b></p>@endif
                            <p style="line-height: 2em">{{ $penutup }}</p>
                            <sub><i>Ini adalah hasil janaan komputer dan tidak memerlukan balasan.</i></sub>
                        </div><br><br>
                    </td>
                </tr>

                <tr>
                    <td style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;">
                        <table class="footer" align="left" width="570" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px; margin: 0 auto; padding: 0; text-align: center; width: 570px;">
                            <tr>
                                <td class="content-cell" align="center" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; max-width: 100vw; padding: 32px;">
                                    <p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; line-height: 1.5em; margin-top: 0; color: #b0adc5; font-size: 12px; text-align: left;">© {{ \Carbon\Carbon::now()->format('Y') }} {{ config('app.name') }}. All rights reserved.</p>

                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
