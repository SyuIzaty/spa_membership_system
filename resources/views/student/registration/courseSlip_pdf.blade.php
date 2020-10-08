<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" media="screen, print" href="{{asset('css/vendors.bundle.css')}}">
        <link rel="stylesheet" media="screen, print" href="{{asset('css/app.bundle.css')}}">
</head>
<body>
    <div class="col-sm-15">
        <div class="card">
             
    <div class="panel-content" id="courseSlip">
        <div class="card card-primary card-outline">
            <div class="card-body">

                <div class="box box-primary box-header" style="padding: 30px;"  id="printable">    
                    <div class="box-header with-border">
                        <h3 style="font-weight: bold;" class="box-title">COURSE REGISTRATION SLIP SEMESTER ? SESSION ?</h3>
                    </div>
                    <div id="">
                        <div class="box-body table-responsive">
                            <table>
                                <tbody>
                                    <tr>
                                        <td style="vertical-align: middle; width: 25%;"><img src="{{ URL::to('/') }}/img/intec_logo_new.png" height="90" width="200" alt="INTEC"></td>
                                        
                                        <td style="width: 75%; text-align: right;"><strong>COURSE REGISTRATION SLIP</strong><br>SEMESTER : ?<br>SESSION : ?</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div>
                                <table class="table table-bordered">
                                    <tbody><tr>
                                        <th style="width: 10%">Name</th>
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr>
                                        <th style="width: 10%">Student ID</th>
                                        <td></td>
                                        <th style="width: 10%">IC/Passport</th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>Programme</th>
                                        <td></td>
                                        <th>Faculty</th>
                                        <td></td>
                                    </tr>
                                </tbody></table>
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr class="bg-highlight">
                                            <th rowspan="2" style="text-align: left;">NO.</th>
                                            <th rowspan="2" style="text-align: left;">COURSE CODE</th>
                                            <th rowspan="2" style="text-align: left;">COURSE NAME</th>
                                            <th rowspan="2" style="text-align: center;">SECTION</th>
                                            <th colspan="2" style="text-align: center;">STATUS</th>
                                            <th rowspan="2" style="text-align: center;">CREDIT</th>
                                        </tr>
                                        <tr class="bg-highlight">
                                            <th style="text-align: center;">COURSE</th>
                                            <th style="text-align: center;">REGISTRATION</th>
                                        </tr>
                                        <tr>
                                            <td style="text-align: left;"></td>
                                            <td style="text-align: left;"></td>
                                            <td style="text-align: left;"></td>
                                            <td style="text-align: center;"></td>
                                            <td style="text-align: center;"></td>
                                            <td style="text-align: center;"></td>
                                            <td style="text-align: center;"></td>
                                        </tr>
                                        <tr style="background-color: maroon; font-weight: bold; color: white;">
                                            <td colspan="6" style="text-align: right;">TOTAL CREDITS REGISTERED</td>
                                            <td style="text-align: center;"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                
                                <div align="left"><span style="color: red; font-weight: bold;">NOTE</span>
                                    <li>If mistakenly registered, please do amendation immediately. Please inform your Academic Advisor if you have make any changes.</li>
                                </div>
                                <p>
                                </p><div align="left">Printed date: ?</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div></div>
</body>

<script>
    window.print();
</script>
