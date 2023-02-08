<style>
  @page { margin: 0mm; }
  body { margin: 0mm; }
  @font-face {
      font-family: 'Montserrat';
      src: url({{ storage_path('fonts/Montserrat-Regular.ttf') }});
  }
  @font-face {
      font-family: 'Butler';
      src: url({{ storage_path('fonts/Butler_Black.otf') }});
  }
  #staff-card-front .category{
      position:absolute;
      top:200mm;
      left:25mm;
      font-family: 'Butler';
      font-size:80pt;
      font-weight:bold;
      color: white;

  }
  #staff-card-front .name{
      position:absolute;
      top:230mm;
      left:25mm;
      font-family: 'Montserrat', sans-serif;
      font-size:40pt;
      text-transform:uppercase;
      font-weight:medium;
      color:white;
  }

  #staff-card-front .barcode{
      position:absolute;
      top:280mm;
      left:25mm;
      color:#373739;
      text-transform:uppercase;
      /* background-color: white; */
  }

  #staff-card-front .sid{
      position:relative;
      top:20mm;
      color:#373739;
      text-transform:uppercase;
  }

  #profile_picture{
      position: absolute;
      top:80.5mm;
      left:25mm;
      width               : 96mm;
      height              : 105mm;
  }

  #student-card-back .details {
        position:relative;
        top:20mm;
        left:25mm;
        font-family: 'Montserrat',sans-serif;
        font-size:26pt;
        margin-right:40mm;
    }

    #student-card-back .details2 {
        position:absolute;
        /* top:25mm; */
        top:120mm;
        left: 20mm;
        right: 3mm;
        font-family: 'Montserrat',sans-serif;
        font-size:30pt;
    }

    #student-card-back .qrcode{
        position: absolute;
        margin-left: 10mm;
        margin-top: 5mm;
    }

    #student-card-back .returnpolicy{
        position:absolute;
        /* bottom:120mm; */
        bottom:100mm;
        color:#1f1f11;
        font-family: 'Montserrat', sans-serif;
        font-size:22pt;
        font-weight:bold;
        width:100%;
        margin-left: 10mm;
        padding:1mm 3mm;
    }

    .font-weight-bold{
        font-weight:bold;
    }

    #student-card-back .qrcode{
        margin-left: 25mm;
        margin-top: 40mm;
    }
</style>

<body style="background-image:url('img/card-backgrounds/staff_card_front.jpg');background-size: cover;margin:0;padding:0;">
  <div id="staff-card-front">
      @isset($staff->user)
          <img src="{{ isset($user->image_path) ? 'sims.intec.edu.my/'.(('storage/card/'.$user->image_path)) : '' }}" id="profile_picture">
          {{-- <img src="{{ isset($user->image_path) ? 'sims.intec.edu.my/storage/card/1656994685.png' : '' }}" id="profile_picture"> --}}
      @endisset
      <div class="category">Staff</div>
      <div class="name">{{ isset($user->short_name) ? $user->short_name : '' }}</div>
      <div class="name" style="margin-top: 200px">{{ isset($staff->staff_id) ? $staff->staff_id : '' }}</div>
      <div class="barcode">
      </div>
  </div>
</body>
<body style="background-image:url('img/card-backgrounds/staff_card_back.jpg');background-size: cover;margin:0;padding:0;">
  <div class="card-body" id="student-card-back">
      <table class="details">
          <tr>
              <td>
                  <?php $staff_name = explode(' ',$staff->staff_name); ?>
                  <b>{{ isset($staff_name[0]) ? $staff_name[0] : '' }}</b> <b>{{ isset($staff_name[1]) ? $staff_name[1] : '' }}</b> <b>{{ isset($staff_name[2]) ? $staff_name[2] : '' }}</b>
                  <b>{{ isset($staff_name[3]) ? $staff_name[3] : '' }}</b> <b>{{ isset($staff_name[4]) ? $staff_name[4] : '' }}</b> <b>{{ isset($staff_name[5]) ? $staff_name[5] : '' }}</b>
                  <b>{{ isset($staff_name[6]) ? $staff_name[6] : '' }}</b> <b>{{ isset($staff_name[7]) ? $staff_name[7] : '' }}</b> <b>{{ isset($staff_name[8]) ? $staff_name[8] : '' }}</b>
                  <b>{{ isset($staff_name[9]) ? $staff_name[9] : '' }}</b> <b>{{ isset($staff_name[10]) ? $staff_name[10] : '' }}</b> <b>{{ isset($staff_name[11]) ? $staff_name[11] : '' }}</b>
              </td>
          </tr>
          <tr>
              <td valign="top" class="font-weight-bold">{{ $staff->staff_id }}</td>
          </tr>
      </table>

      <div class="qrcode"><img src="data:image/png;base64, {{ $qr }}"></div>
      <div class="returnpolicy" style="padding-left: 15mm">This card is issued specifically for <br> INTEC STAFF ONLY<br>  If found please return to:<br><br>INTEC Education College. <br/>Jalan Senangin Satu 17/2A, <br>Seksyen 17, 40200 Shah Alam,<br> Selangor, Malaysia<br>+603 8603 7000 / corporate@intec.edu.my</div>
  </div>
</body>

