<head>
    <meta charset="UTF-8">

    <title>Offer Letter</title>
    <style>
        @page :right {
            margin: 2cm;
        }

        @page {
            size: A4;
        }

        body{
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
        }

        .app_detail{
            text-transform: uppercase;
            font-weight: bold;
            line-height: 1.2;
        }

        .intake_detail p{
            line-height: 1.2;
        }

        .prog_detail tr td:nth-child(3){
            text-transform: uppercase;
            font-weight: bold;
            width: 500px;
        }

        .prog_detail tr td:nth-child(1){
            width: 150px;
        }

        .important{
            line-height: 1.2;
            border: 2px solid black;
            font-weight: bold;
        }

        .important p{
            margin-left: 10px;
        }

        .note p{
            line-height: 1.2;
            font-style: italic;
        }

        .footer p{
            font-style: italic;
        }
    </style>
</head>
<body>
    <img src="{{ storage_path('app/public/intec_offer.png') }}" style="height: 170px; width: 650px">
    <div class="app_detail">
        {{$applicant->applicant_name}}<br>{{$applicant->applicant_ic}}
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
            <td>{{$programme->programme_code}} - {{$programme->programme_name}}</td>
        </tr>
        <tr>
            <td>Duration</td>
            <td>:</td>
            <td>{{$programme->programme_duration}}</td>
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
