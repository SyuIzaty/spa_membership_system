<head>
    <meta charset="UTF-8">

    <title>Offer Letter</title>

    <link rel="stylesheet" href="css/pdf.css">
</head>
<body>
    <img src="{{ public_path('img/intec_offer.png') }}" style="height: 170px; width: 650px">
    <div class="app_detail">
        {{$detail->applicant_name}}<br>{{$detail->applicant_ic}}
    </div>
    <div class="intake_detail">
        <p>Congratulations. INTEC Education College is pleased to inform you of your admission to our Institute.
            We are offering a placement for the following programme:
        </p>
    </div>
    <table class="prog_detail">
        <tr>
            <td>Programme</td>
            <td>:</td>
            <td>{{$detail->offeredProgramme->programme_code}} - {{$detail->offeredProgramme->programme_name}}</td>
        </tr>
        @if ($detail->offered_major != 'M0000')
        <tr>
            <td>Major</td>
            <td>:</td>
            <td>
                {{$detail->offeredMajor->id}} - {{$detail->offeredMajor->major_name}}
            </td>
        </tr>
        @endif
        <tr>
            <td>Duration</td>
            <td>:</td>
            <td>{{$detail->offeredProgramme->programme_duration}}</td>
        </tr>
        <tr>
            <td>Date</td>
            <td>:</td>
            <td>{{$intakes->intake_date}}</td>
        </tr>
        <tr>
            <td>Time</td>
            <td>:</td>
            <td>{{$intakes->intake_time}}</td>
        </tr>
        <tr>
            <td>Venue</td>
            <td>:</td>
            <td>{{$intakes->intake_venue}}</td>
        </tr>
    </table>
    <div class="intake_detail">
        <p>We take great pride in our outstanding students and look forward to have you as part of our learning community.</p>
    </div>
    <div class="important">
        <p>IMPORTANT:</p>
        <ol>
            <li>This official letter is for a STUDY PLACEMENT only.</li>
            <li>Kindly refer to <i>'Senarai Semak Dokumen Keperluan Pendaftaran'</i> for required documents during registration.</li>
            <li>Please bring original copies of sponsor's offer letter (if applicable) during the registration.</li>
            <li>Education loan is available subject to ELIGIBILITY.</li>
            <li>INTEC reserves the right to withdrawthis offer should and of your information deemed to be incorrect.</li>
            <li>This offer is invalid should the above-named candidate does not attend for registration within 2 weeks after the official registration date.</li>
            <li>INTEC Fees & Refund policy can be access at the link below https://intec.edu.my/students/information/academic-regulations</li>
        </ol>
    </div>
    <div class="note">
        <p>**Applicants will only be accepted as INTEC students after their documents that satisfy the conditions for admission as required
            by INTEC have been checked and verified on the day of registration.
        </p>
    </div>
    <div class="intake_detail">
        <p>ADMISSION UNIT<br>INTEC Education College</p>
    </div>
    <div class="footer">
        <p>This letter is computer generated, no signature required</p>
    </div>
</body>
