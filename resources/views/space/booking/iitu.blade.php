<head>
  <meta charset="UTF-8">
  <title>Booking Form</title>
  <link rel="stylesheet" href="css/booking.css">
</head>
<body>
  <div style="margin-top:100px; margin-left:600px;">
    <p>
      <b>ROOM AND SPACE REQUEST FORM</b>
    </p>
  </div>
  <table class="first-table" style="margin-top:20pt">
    <tr>
      <td style="width:20%">APPLICANT NAME</td>
      <td style="width:40%">{{ isset($booking->spaceBookingMain->user->name) ? $booking->spaceBookingMain->user->name : '' }}</td>
      <td style="width:20%">STUDENT / STAFF ID</td>
      <td style="width:20%">{{ isset($booking->spaceBookingMain->user->id) ? $booking->spaceBookingMain->user->id : '' }}</td>
    </tr>
  </table>
  <table class="first-table" style="margin-top:0pt">
    <tr>
      <td style="width:30%">PROG / UNIT / DEPARTMENT</td>
      <td style="width:70%">
        @if($user->category == 'STF')
          {{ isset($user->staff->staff_dept) ? $user->staff->staff_dept : '--' }}
        @endif
        @if($user->category == 'STD')
          {{ isset($user->student->programmes->programme_name) ? $user->student->programmes->programme_name : '--' }}
        @endif
      </td>
    </tr>
  </table>
  <table class="first-table" style="margin-top:0pt">
    <tr>
      <td style="width:20%">OFFICE NO</td>
      <td style="width:40%">{{ isset($booking->spaceBookingMain->user_office) ? $booking->spaceBookingMain->user_office : '' }}</td>
      <td style="width:20%">PHONE</td>
      <td style="width:20%">{{ isset($booking->spaceBookingMain->user_phone) ? $booking->spaceBookingMain->user_phone : '' }}</td>
    </tr>
  </table>
  <div style="margin-top:20pt;">
    <p>
      <b>VENUE & BOOKING DETAILS</b>
    </p>
  </div>
  <table class="first-table" style="margin-top:10pt;">
    @php
        $venueArray = $venue->toArray();
        $chunkedVenue = array_chunk($venueArray, 3);
    @endphp
    @foreach($chunkedVenue as $chunk)
    <tr>
        @foreach($chunk as $venues)
          <td style="border:none">
            <input type="checkbox" style="font-size:15pt; margin-right:5pt" {{ ($booking->venue_id == $venues['id']) ? 'checked' : '' }}>
          </td>
          <td style="border:none">{{ $venues['name'] }}</td>
        @endforeach
    </tr>
    @endforeach
  </table>
  <table class="first-table" style="margin-top:20pt">
    <tr>
      <td style="width:25%">START DATE</td>
      <td style="width:35%">{{ isset($booking->spaceBookingMain->start_date) ? date('jS F Y', strtotime($booking->spaceBookingMain->start_date)) : '' }}</td>
      <td style="width:25%">END DATE</td>
      <td style="width:35%">{{ isset($booking->spaceBookingMain->end_date) ? date('jS F Y', strtotime($booking->spaceBookingMain->end_date)) : '' }}</td>
    </tr>
    <tr>
      <td style="width:25%">TIME BEGINS</td>
      <td style="width:35%">{{ isset($booking->spaceBookingMain->start_time) ? $booking->spaceBookingMain->start_time : '' }}</td>
      <td style="width:25%">TIME ENDS</td>
      <td style="width:35%">{{ isset($booking->spaceBookingMain->end_time) ? $booking->spaceBookingMain->end_time : '' }}</td>
    </tr>
    <tr>
      <td style="width:25%">PURPOSE</td>
      <td style="width:75%" colspan="3">{{ isset($booking->spaceBookingMain->purpose) ? $booking->spaceBookingMain->purpose : '' }}</td>
    </tr>
    <tr>
      <td style="width:25%">NO OF USER</td>
      <td style="width:75%" colspan="3">{{ isset($booking->spaceBookingMain->no_user) ? $booking->spaceBookingMain->no_user : '-' }}</td>
    </tr>
    <tr>
      <td style="width:25%">REMARK</td>
      <td style="width:75%" colspan="3">{{ isset($booking->spaceBookingMain->remark) ? $booking->spaceBookingMain->remark : '' }}</td>
    </tr>
  </table>
  <div style="margin-top:20pt;">
    <p>
      <b>REQUIREMENT</b>
    </p>
  </div>
  <table class="first-table" style="margin-top:10pt;">
    @php
        $itemArray = $item->toArray();
        $chunkedItem = array_chunk($itemArray, 2);
    @endphp
    @foreach($chunkedItem as $chunks)
    <tr>
        @foreach($chunks as $items)
          <td style="border:none">
            <input type="checkbox" style="font-size:15pt; margin-right:5pt" {{ in_array(($items['id']),($booking_item->pluck('item_id')->toArray())) ? 'checked' : '' }}>
          </td>
          <td style="border:none">{{ $items['name'] }}</td>
          <td style="border:none">
            <div style="border: 5px solid black; width:20pt; height: 15pt; padding: 1pt">
            @if($booking_item->where('item_id',$items['id'])->count() >= 1)
              <span style="padding-left:20px; padding-top:20px">{{ $booking_item->where('item_id',$items['id'])->first()->unit }}</span>
            @endif
            </div>
          </td>
        @endforeach
    </tr>
    @endforeach
  </table>
  <div style="border: 5px solid black; margin-top: 20pt">
    <b style="padding-left:180pt">FOR OFFICE USE ONLY</b>
  </div>
  <p style="margin-top:10pt;">
    <b>STATUS: {{ Str::upper(Str::limit(isset($booking->spaceStatus->name) ? $booking->spaceStatus->name : '',110)) }}</b>
  </p>
  <p style="margin-top:20pt; font-size:8pt;">
    <b>NOTE :</b><br>
    <p style="font-size:8pt">1. Approval is subject to the venue availability or no maintenance work in the room.</p>
  </p>
  <div style="margin-left:90pt;">
    <p style="margin-top:200px; margin-bottom:20pt">
      <b>PERATURAN PENGGUNAAN RUANG MAKMAL KOMPUTER</b>
    </p>
  </div>
  <ol style="font-size:8pt;">
    <li style="margin-bottom:10pt">
      Tempahan ruang makmal komputer hendaklah dibuat selewat - lewatnya 3 hari sebelum tarikh penggunaan. 
      (Sebarang tembahan tanpa borang tidak akan dilayan)
    </li>
    <li style="margin-bottom:10pt">
      Pihak IITU tidak menyediakan sebarang perkhidmatan mengubah susun atur bilik / ruang makmal.
    </li>
    <li style="margin-bottom:10pt">
      Sekiranya memerlukan tambahan peralatan atau mengubah susun atur ruang, boleh terus berurusan dengan pihak unit majlis
      INTEC sehingga program selesai.
    </li>
    <li style="margin-bottom:10pt">
      Sebarang pembatalan tempahan ruang, mohon untuk memaklumkan kepada pegawai yang bertugas sekurang - kurangnya
      sehari sebelum tarikh penggunaan.
    </li>
    <li style="margin-bottom:10pt">
      Sila pastikan keadaakn bilik / ruang makmal yang telah digunakan berkeadaan baik seperti sediakala selepas
      penggunaan untuk memberi keselesaan kepada pengguna seterusnya.
    </li>
  </ol>
  <p style="margin-top:50pt; margin-left:180pt">
    <b>AKUAN PEMOHON</b>
  </p>
  <p style="margin-left:60pt">
    <b>PINJAMAN PERALATAN DI BILIK DAN RUANG MAKMAL KOMPUTER</b>
  </p>
  <p style="font-size:8pt;">
    Saya yang bernama {{ $user->name }} No K/P 
    @if($user->category == 'STF')
      {{ isset($user->staff->staff_ic) ? $user->staff->staff_ic : '' }}.
    @endif
    @if($user->category == 'STD')
      {{ isset($user->student->students_ic) ? $user->student->students_ic : '' }}.
    @endif
    Mengaku memohon pinjaman dan penggunaan peralatan di Bilik dn Ruang makmal komputer INTEC dan saya telah membaca
    serta memahami peraturan dan prosedur dibawah ini:
    <ol style="font-size:8pt;">
      <li style="margin-bottom:10pt">Saya mengaku bahawa butiran diri yang saya berikan adalah sah dan benar.</li>
      <li style="margin-bottom:10pt">Saya bertanggungjawab sepenuhnya ke atas peralatan yang dipinjamkan dan digunakan.</li>
      <li style="margin-bottom:10pt">
        Saya bersedia menanggung segala kos pembayaran jika peralatan yang dipinjam dan digunakan hilang,
        rosak atau gagal dipulangkan. Kadar gantirugi adalah sama dengan harga asal peralatan.
      </li>
      <li style="margin-bottom:10pt">
        Saya mengaku bahawa saya akan membayar segala denda yang dikenakan ke atas saya akibat kecuaian 
        saya sendiri.
      </li>
    </ol>
  </p>
</body>
