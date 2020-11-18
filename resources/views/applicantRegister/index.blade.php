@extends('layouts.applicant')
@section('content')
<body>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <div class="card d-flex align-items-stretch">
                    <div class="card-header">
                        <div class="d-flex justify-content-center">
                            <div class="p-2">
                                <img src="{{ asset('img/intec_logo.png') }}" class="responsive"/>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($intake!=0)
                        <div class="d-flex justify-content-center">
                            <div class="p-2"><h3 class="text-center">NEW APPLICATION</h3><p>If you wish to apply for any INTEC programme, click on the button below.</p></div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="p-2"><a href="{{ route('registration.index') }}" class="btn btn-success"><i class="fal fa-pencil-alt"></i> NEW APPLICATION</a></div>
                        </div>
                        @else
                        <div class="d-flex justify-content-center">
                            <div class="p-2"><h3>Sorry application have been closed</p></div>
                        </div>
                        @endif
                        <hr class="mt-2 mb-3" style="border: 1px solid #ececec">
                        <div class="d-flex justify-content-center">
                            <div class="p-2">
                                <h3 class="text-center">UPDATE EXISTING APPLICATION <br> OR <br>CHECK APPLICATION STATUS</h3>
                                <br>
                                <p class="text-center">If you have made application for any INTEC programme before and wish to continue with your application or you wish to check your status for any application , kindly login below.</p>
                            </div>
                        </div>
                        {!! Form::open(['action' => 'RegistrationController@search', 'method' => 'GET']) !!}
                        <div class="d-flex justify-content-center">
                            <div class="p-2">
                                {{Form::label('title', 'IC Number / Passport')}}
                                {{Form::text('applicant_ic', '', ['class' => 'form-control', 'placeholder' => 'Applicant IC', 'onkeyup' => 'this.value = this.value.toUpperCase()', 'placeholder' => 'Eg: 991023106960'])}}
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="p-2">
                                <button type="submit" class="btn btn-primary mt-4"><i class="fal fa-search"></i> CONTINUE APPLICATION / CHECK APPLICATION</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12 p-2 text-center">
                                Contact our helpdesk:<br>
                                <span class="font-weight-bold">MARKETING & STUDENT ADMISSION DEPARTMENT</span>
                                <br>Email: marketing.admission@intec.edu.my<br>Website: <a href="www.intec.edu.my">www.intec.edu.my</a>
                                <br>Phone: +603-5522 7267 / 7056 / 7080<br>
                            </div>
                            <div class="col-md-6 p-2 text-right">
                                <span class="font-weight-bold">Address</span>
                                <p class="text-break">INTEC Education College<br>Level 2, Block F<br> Jalan Senangin Satu 17/2A<br> Section 17, 40200 Shah Alam<br> Selangor, MALAYSIA</p>
                            </div>
                            <div class="col-md-6 p-2">

                                <span class="font-weight-bold">Whatsapp:</span> <br>+6012-264 7657 (Mr. Shurabil) <br> +60 10-566 9143 (Mr. Norshahril) <br>+60 11-1024 0305 (Mr. Norazmin)<br>+60 11-2621 7508 (Ms. Dewi)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card d-flex align-items-stretch">
                    <div class="card-header text-center">
                                <span class="font-weight-bold">APPLICATION PROCEDURE</span>
                    </div>
                    <div class="card-body">
                        <div class="accordion accordion-outline accordion-hover" id="js_demo_accordion-5">
                            <div class="card">
                                <div class="card-header">
                                    <a href="javascript:void(0);" class="card-title" data-toggle="collapse" data-target="#js_demo_accordion-5a" aria-expanded="true">
                                        APPLICATION PROCEDURES & GUIDELINE FOR LOCAL APPLICANT (MALAYSIAN)
                                        <span class="ml-auto">
                                            <span class="collapsed-reveal">
                                                <i class="fal fa-chevron-up fs-xl"></i>
                                            </span>
                                            <span class="collapsed-hidden">
                                                <i class="fal fa-chevron-down fs-xl"></i>
                                            </span>
                                        </span>
                                    </a>
                                </div>
                                <div id="js_demo_accordion-5a" class="collapse show" data-parent="#js_demo_accordion-5" style="">
                                    <div class="card-body">
                                        <table class="table table-bordered table-sm">
                                            <tr>
                                                <td class="text-nowrap">Step 1:</td>
                                                <td>Fill the online application form (with accurate information).</td>
                                            </tr>
                                            <tr>
                                                <td class="text-nowrap">Step 2:</td>
                                                <td>Your application will be processed <br>upon receiving the completed info in online application</td>
                                            </tr>
                                            <tr>
                                                <td class="text-nowrap">Step 3:</td>
                                                <td>Successful candidate will be contacted via email <b>OR</b> Candidate can check their application status online.</td>
                                            </tr>
                                            <tr>
                                                <td class="text-nowrap">Step 4:</td>
                                                <td>
                                                    Attend for new student registration at INTEC on the date stated in your offer letter.
                                                    <ol>
                                                        <li>Complete your tuition fees payment as stated in the offer letter.</li>
                                                        <li>Bring the offer letter and documents required.</li>
                                                    </ol>
                                                    Failure to make payment and submit the documents required is not allowed to register as a student.
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#js_demo_accordion-5b" aria-expanded="false">
                                        APPLICATION PROCEDURES & GUIDELINE FOR INTERNATIONAL APPLICANT (NON-MALAYSIAN)
                                        <span class="ml-auto">
                                            <span class="collapsed-reveal">
                                                <i class="fal fa-chevron-up fs-xl"></i>
                                            </span>
                                            <span class="collapsed-hidden">
                                                <i class="fal fa-chevron-down fs-xl"></i>
                                            </span>
                                        </span>
                                    </a>
                                </div>
                                <div id="js_demo_accordion-5b" class="collapse" data-parent="#js_demo_accordion-5" style="">
                                    <div class="card-body">
                                        <table class="table table-bordered table-sm">
                                            <tr>
                                                <td class="text-nowrap">Step 1:</td>
                                                <td><p class="text-justify">Fill the online application form (with accurate information)</p><p class="text-justify">Application must be done within <b>8 weeks</b> from the registration date (to ensure ample time for EMGS processing and student pass endorsement).</p></td>
                                            </tr>
                                            <tr>
                                                <td class="text-nowrap">Step 2:</td>
                                                <td>
                                                    <p>The processing fee must be made and payable INTEC Education College</p>
                                                    <p class="text-justify">A) For International applicant <b>RESIDING in MALAYSIA</b>, payment can be done as follows:</p>
                                                    <div class="p-2">
                                                        <table class="table table-sm table-bordered">
                                                            <tr>
                                                                <td>BANK</td>
                                                                <td><span class="font-weight-bold">BANK ISLAM MALAYSIA BERHAD</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td>ACCOUNT NO</td>
                                                                <td><span class="font-weight-bold">122-340-1000-3584</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td>AMOUNT IN RM</td>
                                                                <td><span class="font-weight-bold">RM200.00</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td>RECEIVING BANK CONTACT NAME</td>
                                                                <td><span class="font-weight-bold">UITM PRIVATE EDUCATION SDN BHD</span></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <p style="padding-top: 20px">B) For International applicant <b>NOT RESIDING in MALAYSIA</b>, payment can be done as follows:</p>
                                                    <p class="text-justify">i) To obtain swift code number from the home country bank:</p>
                                                    <div class="p-2">
                                                        <table class="table table-sm table-bordered">
                                                            <tr>
                                                                <td>Bank</td>
                                                                <td><span class="font-weight-bold">BANK ISLAM MALAYSIA BERHAD</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td>CITY / STATE OF BANK</td>
                                                                <td><span class="font-weight-bold">SECTION 18, SHAH ALAM, SELANGOR DARUL EHSAN</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td>SWIFT CODE</td>
                                                                <td><span class="font-weight-bold">BIMBMYKL</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td>BRANCH CODE</td>
                                                                <td><span class="font-weight-bold">114, BANK ISLAM SECTION 18 SHAH ALAM</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td>ACCOUNT NO</td>
                                                                <td><span class="font-weight-bold">122-340-1000-3584</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td>AMOUNT IN USD</td>
                                                                <td><span class="font-weight-bold">USD70.00</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td>RECEIVING CONTACT NAME</td>
                                                                <td><span class="font-weight-bold">UITM PRIVATE EDUCATION SDN BHD</span></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <p class="text-justify"><b>The application only be process after the completed documents and the processing fee is received</b></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-nowrap">Step 3:</td>
                                                <td>
                                                    <p class="text-justify">Prepare the following documents:</p>
                                                    1) A Passport Size Photograph
                                                    <ul>
                                                        <li>White background</li>
                                                        <li>35mm wide x 45mm high</li>
                                                    </ul>
                                                    2) Student Passport
                                                    <ul class="text-justify">
                                                        <li>Biodata page</li>
                                                        <li>All pages</li>
                                                        <li>Passport validity must be 12 months & above</li>
                                                        <li>Maximum of 2 passport pages per each A4 pape</li>
                                                    </ul>
                                                    <p class="text-justify">3) Academic Transcript **</p>
                                                    <p class="text-justify">4) English Requirements **</p>
                                                    <ul>
                                                        <li class="text-justify">Demonstrate acceptable level of English proficiency (as required by EMGS), 1 of the listed below</li>
                                                        <ul>
                                                            <li>Pearson Test of English (PTE)</li>
                                                            <li>IELTS (International English Language Testing System)</li>
                                                            <li>TOEFL (Test of English as a Foreign Language)</li>
                                                            <li>Cambridge English Advance (CAE)</li>
                                                            <li>Cambridge English Proficiency (CPE)</li>
                                                            <li>MUET (Malaysian University English Test)</li>
                                                        </ul>
                                                    </ul>
                                                    <p class="text-justify">5) Certificate of Completion or Clearance/Release Letter from previous institution **</p>
                                                    <p class="text-justify">6) Financial Bank Statement</p>
                                                    <ul><li class="text-justify">The statement must show sufficient funding amount for 2 semesters’ programme fees.</li></ul>
                                                    <p class="text-justify">ACCA Exemption (for application of ACCA programme only)</p>
                                                    <p class="text-justify">Copy of swift code receipt / proof of payment with the applicant full name and passport number</p>
                                                    <p class="text-justify font-weight-bold">** Relevant academic transcript, certificate of completion, English requirement must have “certified true copy” by the authorize personnel/embassy/government.</p>
                                                    <p class="text-justify font-weight-bold">All document submitted must be translated in English.</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-nowrap">Step 4:</td>
                                                <td>
                                                    <p class="text-justify">Upload the documents in <b>Step 2 & Step 3</b> into your online application.</p>
                                                    <p class="text-justify">All the documents are stated above are <b>COMPULSORY</b>. Unable to submit those documents will cause unsuccessful application.</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-nowrap">Step 5:</td>
                                                <td><p class="text-justify">Your application will be processed upon receiving the documents & processing fees payment.</p></td>
                                            </tr>
                                            <tr>
                                                <td class="text-nowrap">Step 6:</td>
                                                <td><p class="text-justify">Successful candidate will be contacted via email <b>OR</b> Candidate can check their application status online.</p></td>
                                            </tr>
                                            <tr>
                                                <td class="text-nowrap">Step 7:</td>
                                                <td>
                                                    <p class="text-justify">Application for Visa</p>
                                                    <p class="text-justify">Section 10 of the Immigration Regulations 1963 requires all international students (including the mobility students) who wish to study at any higher education institutions in Malaysia to obtain Student Pass before entering Malaysia.</p>
                                                    <p class="text-justify">Our International Unit will provide you with a guideline to apply for the student pass through Education Malaysia Global Services (EMGS) website.</p>
                                                    <p class="text-justify">Students are required to submit application for Student Pass at the Education Malaysia Global Service (EMGS*) through online system at <a href="https://visa.educationmalaysia.gov.my/">https://visa.educationmalaysia.gov.my/</a></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-nowrap">Step 8:</td>
                                                <td>
                                                    <p class="text-justify">Attend for new student registration at INTEC on the date stated in your offer letter.</p>
                                                    <ul class="text-justify">
                                                        <li>Complete your tuition fees payment as stated in the offer letter.</li>
                                                        <li>Bring the offer letter and documents required.</li>
                                                    </ul>
                                                    <p class="text-justify font-weight-bold">Failure to make payment and submit the documents required is not allowed to register as a student.</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
@endsection
