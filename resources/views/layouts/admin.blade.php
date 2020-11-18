<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

         <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <meta name="description" content="Page Title">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
        <!-- Call App Mode on ios devices -->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <!-- Remove Tap Highlight on Windows Phone IE -->
        <meta name="msapplication-tap-highlight" content="no">

         <!-- base css -->
        <link rel="stylesheet" media="screen, print" href="{{asset('css/vendors.bundle.css')}}">
        <link rel="stylesheet" media="screen, print" href="{{asset('css/app.bundle.css')}}">
        <!-- Place favicon.ico in the root directory -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{asset('img/favicon/apple-touch-icon.png')}}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{asset('img/favicon/favicon-32x32.png')}}">
        <link rel="mask-icon" href="{{asset('img/favicon/safari-pinned-tab.svg')}}" color="#5bbad5">
        <!--<link rel="stylesheet" media="screen, print" href="css/your_styles.css">-->
        <link rel="stylesheet" media="screen, print" href="{{asset('css/datagrid/datatables/datatables.bundle.css')}}">
        <link rel="stylesheet" href="{{ asset('css/notifications/sweetalert2/sweetalert2.bundle.css') }}">
        {{-- <link rel="stylesheet" media="screen, print" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"> --}}

        {{-- <link rel="stylesheet" media="screen, print" href="{{asset('css/select2.min.css')}}"> --}}
        <link rel="stylesheet" href="{{ asset('css/formplugins/summernote/summernote.css') }}" >

        @yield('css')
        <style>
            .highlight{
                font-weight: bolder;
            }
        </style>
    </head>
    <body class="mod-bg-1 ">
        <!-- DOC: script to save and load page settings -->
        <script>
            /**
             *	This script should be placed right after the body tag for fast execution
             *	Note: the script is written in pure javascript and does not depend on thirdparty library
             **/
            'use strict';

            var classHolder = document.getElementsByTagName("BODY")[0],
                /**
                 * Load from localstorage
                 **/
                themeSettings = (localStorage.getItem('themeSettings')) ? JSON.parse(localStorage.getItem('themeSettings')) :
                {},
                themeURL = themeSettings.themeURL || '',
                themeOptions = themeSettings.themeOptions || '';
            /**
             * Load theme options
             **/
            if (themeSettings.themeOptions)
            {
                classHolder.className = themeSettings.themeOptions;
                console.log("%c✔ Theme settings loaded", "color: #148f32");
            }
            else
            {
                console.log("Heads up! Theme settings is empty or does not exist, loading default settings...");
            }
            if (themeSettings.themeURL && !document.getElementById('mytheme'))
            {
                var cssfile = document.createElement('link');
                cssfile.id = 'mytheme';
                cssfile.rel = 'stylesheet';
                cssfile.href = themeURL;
                document.getElementsByTagName('head')[0].appendChild(cssfile);
            }
            /**
             * Save to localstorage
             **/
            var saveSettings = function()
            {
                themeSettings.themeOptions = String(classHolder.className).split(/[^\w-]+/).filter(function(item)
                {
                    return /^(nav|header|mod|display)-/i.test(item);
                }).join(' ');
                if (document.getElementById('mytheme'))
                {
                    themeSettings.themeURL = document.getElementById('mytheme').getAttribute("href");
                };
                localStorage.setItem('themeSettings', JSON.stringify(themeSettings));
            }
            /**
             * Reset settings
             **/
            var resetSettings = function()
            {
                localStorage.setItem("themeSettings", "");
            }

        </script>
        <!-- BEGIN Page Wrapper -->
        <div class="page-wrapper">
            <div class="page-inner">
                <!-- BEGIN Left Aside -->
                <aside class="page-sidebar">
                    <div class="page-logo">
                        <a href="#" class="page-logo-link press-scale-down d-flex align-items-center position-relative" data-toggle="modal" data-target="#modal-shortcut">
                            {{-- <img src="{{asset('img/logo.png')}}" alt="SmartAdmin WebApp" aria-roledescription="logo"> --}}

                            <span class="page-logo-text mr-1"><b>INTEC</b> SIMS</span>
                            <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
                        </a>
                    </div>
                    <!-- BEGIN PRIMARY NAVIGATION -->
                    <nav id="js-primary-nav" class="primary-nav" role="navigation">
                        <div class="nav-filter">
                            <div class="position-relative">
                                <input type="text" id="nav_filter_input" placeholder="Filter menu" class="form-control" tabindex="0">
                                <a href="#" onclick="return false;" class="btn-primary btn-search-close js-waves-off" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar">
                                    <i class="fal fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="info-card">
                            <img src="{{asset('img/demo/avatars/avatar-m.png')}}" class="profile-image rounded-circle" alt="Dr. Codex Lantern">
                            <div class="info-card-text">
                                <a href="#" class="d-flex align-items-center text-white">
                                    <span class="text-truncate text-truncate-sm d-inline-block">
                                         {{Auth::user()->name}}
                                    </span>
                                </a>
                                <span class="d-inline-block text-truncate text-truncate-sm">{{Auth::user()->email}}</span>
                            </div>
                            <img src="{{asset('img/card-backgrounds/cover-2-lg.png')}}" class="cover" alt="cover">
                            <a href="#" onclick="return false;" class="pull-trigger-btn" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar" data-focus="nav_filter_input">
                                <i class="fal fa-angle-down"></i>
                            </a>
                        </div>

                        <ul id="js-nav-menu" class="nav-menu">
                            <li class="nav-title">Dashboard</li>
                            <li>
                                <a href="/home" title="Application Intel" data-filter-tags="application intel">
                                    <i class="fal fa-chart-pie"></i>
                                    <span class="nav-link-text" data-i18n="nav.application_intel">Home</span>
                                </a>
                            </li>

                            <li class="nav-title">Operation</li>

                            @role('sales manager|sales executive|admin assistant')
                            <li class="open">
                                <a href="#" title="Sales Intel" data-filter-tags="sales intel">
                                    <i class="fal fa-bullhorn"></i>
                                    <span class="nav-link-text" data-i18n="nav.sales_intel">Sales</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/lead/group_list" title="group_list" data-filter-tags="group_list">
                                            <i class="fal fa-users"></i>
                                            <span class="nav-link-text" data-i18n="nav.group_list">Group List</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/lead/active_lead" title="Active Leads" data-filter-tags="active_leads">
                                            <i class="fal fa-check"></i>
                                            <span class="nav-link-text" data-i18n="nav.active_leads">Active Leads</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" title="Inactive Leads" data-filter-tags="inactive_leads">
                                            <i class="fal fa-minus"></i>
                                            <span class="nav-link-text" data-i18n="nav.inactive_leads">Inactive Leads</span>
                                        </a>
                                        <ul>
                                            <li>
                                                <a href="/lead/inactive_lead" title="success_lead" data-filter-tags="success_lead">
                                                    <span class="nav-link-text" data-i18n="nav.success_lead">Successful Lead</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/lead/inactive_lead_un" title="unsuccess_lead" data-filter-tags="unsuccess_lead">
                                                    <span class="nav-link-text" data-i18n="nav.unsuccess_lead">Unsuccessful Lead</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="/lead/email_blast" title="email" data-filter-tags="email">
                                            <i class="fal fa-envelope"></i>
                                            <span class="nav-link-text" data-i18n="nav.email">Email Blast</span>
                                        </a>
                                    </li>
                                    @role('sales manager|sales executive')
                                    <li>
                                        <a href="/export_lead" title="lead_report" data-filter-tags="lead_report">
                                            <i class="fal fa-book"></i>
                                            <span class="nav-link-text" data-i18n="nav.lead_report">Report</span>
                                        </a>
                                    </li>
                                    @endrole
                                </ul>
                            </li>
                            @endrole

                            @can('check requirement')
                            <li class="open"> <!-- change active kalau nak activate dropdown-->
                                <a href="#" title="Application Intel" data-filter-tags="application intel">
                                    <i class="fal fa-address-book"></i>
                                    <span class="nav-link-text" data-i18n="nav.application_intel">Admission</span>
                                </a>
                                <ul class="collapsable-list">
                                    <li>
                                        <a href="/batch" title="Batch" data-filter-tags="batch">
                                            <i class="fal fa-address-card"></i>
                                            <span class="nav-link-text" data-i18n="nav.active_student">Batch</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/intake" title="Intake Information" data-filter-tags="active_student">
                                            <i class="fal fa-list"></i>
                                            <span class="nav-link-text" data-i18n="nav.active_student">Intake Information</span>
                                        </a>
                                    </li>
                                    {{-- <li>
                                        <a href="/offeredprogramme" title="Batch" data-filter-tags="batch">
                                            <i class="fal fa-file-excel"></i>
                                            <span class="nav-link-text" data-i18n="nav.active_student">Publish Offer Letter</span>
                                        </a>
                                    </li> --}}
                                    <li>
                                        <a href="/sponsorapplicant" title="Pending Applicant" data-filter-tags="active_student">
                                            <i class="fal fa-upload"></i>
                                            <span class="nav-link-text" data-i18n="nav.active_student">Upload Sponsor Applicant</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/incomplete" title="Pending Applicant" data-filter-tags="active_student">
                                            <i class="fal fa-clipboard-list"></i>
                                            <span class="nav-link-text" data-i18n="nav.active_student">Incomplete Application (0)</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/applicantresult" title="Pending Applicant" data-filter-tags="active_student">
                                            <i class="fal fa-user"></i>
                                            <span class="nav-link-text" data-i18n="nav.active_student">Application Received (2)</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/passapplicant" title="Pending Applicant" data-filter-tags="active_student">
                                            <i class="fal fa-check"></i>
                                            <span class="nav-link-text" data-i18n="nav.active_student">Passed Application (4A)</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/failapplicant" title="Pending Applicant" data-filter-tags="active_student">
                                            <i class="fal fa-minus"></i>
                                            <span class="nav-link-text" data-i18n="nav.active_student">Unqualified Application (3G)</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/offerapplicant" title="Pending Applicant" data-filter-tags="active_student">
                                            <i class="fal fa-envelope"></i>
                                            <span class="nav-link-text" data-i18n="nav.active_student">Offered Application (5A)</span>
                                        </a>
                                    </li>
                                    @endcan
                                    @can('email offer letter')
                                    <li>
                                        <a href="/offeredprogramme" title="Batch" data-filter-tags="batch">
                                            <i class="fal fa-file-excel"></i>
                                            <span class="nav-link-text" data-i18n="nav.active_student">Email Offer Letter</span>
                                        </a>
                                    </li>
                                    @endcan
                                    @can('check requirement')
                                    <li>
                                        <a href="/publishedoffer" title="Batch" data-filter-tags="batch">
                                            <i class="fal fa-envelope"></i>
                                            <span class="nav-link-text" data-i18n="nav.active_student">Published Offer Letter (5C)</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/applicantupdatestat" title="Pending Applicant" data-filter-tags="active_student">
                                            <i class="fal fa-plus"></i>
                                            <span class="nav-link-text" data-i18n="nav.active_student">Update Applicant Status</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/export_applicant" title="Batch" data-filter-tags="batch">
                                            <i class="fal fa-file-excel"></i>
                                            <span class="nav-link-text" data-i18n="nav.active_student">Reports</span>
                                        </a>
                                    </li>
                                    {{-- <li>
                                        <a href="/course" title="Active Student" data-filter-tags="active_student">
                                            <i class="fal fa-user"></i>
                                            <span class="nav-link-text" data-i18n="nav.active_student">Offer Histroy</span>
                                        </a>
                                    </li> --}}
                                </ul>
                            </li>
                            <li>
                                <a href="#" title="Application Intel" data-filter-tags="application intel">
                                    <i class="fal fa-user"></i>
                                    <span class="nav-link-text" data-i18n="nav.application_intel">Physical Registration</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/physical-registration" title="Active Student" data-filter-tags="active_student">
                                            <i class="fal fa-user"></i>
                                            <span class="nav-link-text" data-i18n="nav.active_student">New Student</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/student/filter/1" title="Inactive Student" data-filter-tags="inactive_student">
                                            <i class="fal fa-user-times"></i>
                                            <span class="nav-link-text" data-i18n="nav.inactive_student">Returning Student</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/student/filter/2" title="Completed Student" data-filter-tags="completed_student">
                                            <i class="fal fa-user-plus"></i>
                                            <span class="nav-link-text" data-i18n="nav.completed_student">Null Name</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @endcan
                            @can('view parameter')
                            <li>
                                <a href="#" title="Application Intel" data-filter-tags="application intel">
                                    <i class="fal fa-portrait"></i>
                                    <span class="nav-link-text" data-i18n="nav.application_intel">Accomodation</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/student" title="Active Student" data-filter-tags="active_student">
                                            <i class="fal fa-user"></i>
                                            <span class="nav-link-text" data-i18n="nav.active_student">New Student</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/student/filter/1" title="Inactive Student" data-filter-tags="inactive_student">
                                            <i class="fal fa-user-times"></i>
                                            <span class="nav-link-text" data-i18n="nav.inactive_student">Returning Student</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/student/filter/2" title="Completed Student" data-filter-tags="completed_student">
                                            <i class="fal fa-user-plus"></i>
                                            <span class="nav-link-text" data-i18n="nav.completed_student">Null Name</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @endcan
                            @can('view parameter')
                            <li>
                                <a href="#" title="Application Intel" data-filter-tags="application intel">
                                    <i class="fal fa-portrait"></i>
                                    <span class="nav-link-text" data-i18n="nav.application_intel">Course Registration</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/courseregistration" title="Active Student" data-filter-tags="active_student">
                                            <i class="fal fa-user"></i>
                                            <span class="nav-link-text" data-i18n="nav.active_student">Class Timetable</span>
                                        </a>
                                    </li>
                                    {{-- <li>
                                        <a href="/student/filter/1" title="Inactive Student" data-filter-tags="inactive_student">
                                            <i class="fal fa-user-times"></i>
                                            <span class="nav-link-text" data-i18n="nav.inactive_student">Non-Numeric StudentID</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/student/filter/2" title="Completed Student" data-filter-tags="completed_student">
                                            <i class="fal fa-user-plus"></i>
                                            <span class="nav-link-text" data-i18n="nav.completed_student">Null Name</span>
                                        </a>
                                    </li> --}}
                                </ul>
                            </li>
                            @endcan

                            @can('view parameter')
                            <li>
                                <a href="#" title="Application Intel" data-filter-tags="application intel">
                                    <i class="fal fa-portrait"></i>
                                    <span class="nav-link-text" data-i18n="nav.application_intel">Examination</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/examination" title="Active Student" data-filter-tags="active_student">
                                            <i class="fal fa-user"></i>
                                            <span class="nav-link-text" data-i18n="nav.active_student">Exam Timetable</span>
                                        </a>
                                    </li>
                                    {{-- <li>
                                        <a href="/student/filter/1" title="Inactive Student" data-filter-tags="inactive_student">
                                            <i class="fal fa-user-times"></i>
                                            <span class="nav-link-text" data-i18n="nav.inactive_student">Non-Numeric StudentID</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/student/filter/2" title="Completed Student" data-filter-tags="completed_student">
                                            <i class="fal fa-user-plus"></i>
                                            <span class="nav-link-text" data-i18n="nav.completed_student">Null Name</span>
                                        </a>
                                    </li> --}}
                                </ul>
                            </li>
                            @endcan
                            @can('view parameter')
                            <li>
                                <a href="#" title="Application Intel" data-filter-tags="application intel">
                                    <i class="fal fa-portrait"></i>
                                    <span class="nav-link-text" data-i18n="nav.application_intel">Finance</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/examination" title="Active Student" data-filter-tags="active_student">
                                            <i class="fal fa-user"></i>
                                            <span class="nav-link-text" data-i18n="nav.active_student">Exam Transaction Data</span>
                                        </a>
                                    </li>
                                    {{-- <li>
                                        <a href="/student/filter/1" title="Inactive Student" data-filter-tags="inactive_student">
                                            <i class="fal fa-user-times"></i>
                                            <span class="nav-link-text" data-i18n="nav.inactive_student">Non-Numeric StudentID</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/student/filter/2" title="Completed Student" data-filter-tags="completed_student">
                                            <i class="fal fa-user-plus"></i>
                                            <span class="nav-link-text" data-i18n="nav.completed_student">Null Name</span>
                                        </a>
                                    </li> --}}
                                </ul>
                            </li>
                            @endcan
                            <li class="nav-title">Parameter Setting</li>
                            @can('check requirement')
                            <li>
                                <a href="#" title="Application Intel" data-filter-tags="application intel">
                                    <i class="fal fa-portrait"></i>
                                    <span class="nav-link-text" data-i18n="nav.application_intel">Sponsor</span>
                                </a>
                                <ul>
                                    <li>
                                        <li>
                                            <a href="/param/sponsor" title="Active Student" data-filter-tags="active_student">
                                                <i class="fal fa-user"></i>
                                                <span class="nav-link-text" data-i18n="nav.active_student">Sponsor Detail</span>
                                            </a>
                                        </li>
                                    </li>
                                </ul>
                            </li>
                            @endcan
                            @can('view parameter')
                            <li>
                                <a href="#" title="Application Intel" data-filter-tags="application intel">
                                    <i class="fal fa-portrait"></i>
                                    <span class="nav-link-text" data-i18n="nav.application_intel">Semester</span>
                                </a>
                                <ul>
                                    <li>
                                        <li>
                                            <a href="/examination" title="Active Student" data-filter-tags="active_student">
                                                <i class="fal fa-user"></i>
                                                <span class="nav-link-text" data-i18n="nav.active_student">Semester List</span>
                                            </a>
                                        </li>
                                        <a href="/examination" title="Active Student" data-filter-tags="active_student">
                                            <i class="fal fa-user"></i>
                                            <span class="nav-link-text" data-i18n="nav.active_student">Semester Type</span>
                                        </a>
                                        <a href="/examination" title="Active Student" data-filter-tags="active_student">
                                            <i class="fal fa-user"></i>
                                            <span class="nav-link-text" data-i18n="nav.active_student">Semester Details</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" title="Application Intel" data-filter-tags="application intel">
                                    <i class="fal fa-portrait"></i>
                                    <span class="nav-link-text" data-i18n="nav.application_intel">Intake</span>
                                </a>
                                <ul>
                                    <li>
                                        <li>
                                            <a href="/intakeType" title="Active Student" data-filter-tags="active_student">
                                                <i class="fal fa-user"></i>
                                                <span class="nav-link-text" data-i18n="nav.active_student">Intake Type</span>
                                            </a>
                                        </li>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="#" title="Application Intel" data-filter-tags="application intel">
                                    <i class="fal fa-portrait"></i>
                                    <span class="nav-link-text" data-i18n="nav.application_intel">Study Plan</span>
                                </a>
                                <ul>
                                    <li>
                                        <li>
                                            <a href="/studyPlan" title="Study Plan" data-filter-tags="study_plan">
                                                {{-- <i class="fal fa-book"></i> --}}
                                                <span class="nav-link-text" data-i18n="nav.study_plan">Plan Management</span>
                                            </a>
                                        </li>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="#" title="Application Intel" data-filter-tags="application intel">
                                    <i class="fal fa-portrait"></i>
                                    <span class="nav-link-text" data-i18n="nav.application_intel">Programme</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/param/programme/" title="Active Student" data-filter-tags="active_student">
                                            <i class="fal fa-list"></i>
                                            <span class="nav-link-text" data-i18n="nav.active_student">Programme List</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/examination" title="Active Student" data-filter-tags="active_student">
                                            <i class="fal fa-user"></i>
                                            <span class="nav-link-text" data-i18n="nav.active_student">Exam Transaction Data</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/examination" title="Active Student" data-filter-tags="active_student">
                                            <i class="fal fa-user"></i>
                                            <span class="nav-link-text" data-i18n="nav.active_student">Program Detailsd</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="#" title="Application Intel" data-filter-tags="application intel">
                                    <i class="fal fa-portrait"></i>
                                    <span class="nav-link-text" data-i18n="nav.application_intel">Course</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/param/course/" title="Active Course" data-filter-tags="active_course">
                                            <i class="fal fa-list"></i>
                                            <span class="nav-link-text" data-i18n="nav.active_course">Course List</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="#" title="Application Intel" data-filter-tags="application intel">
                                    <i class="fal fa-portrait"></i>
                                    <span class="nav-link-text" data-i18n="nav.application_intel">Major</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/param/major/" title="Active Major" data-filter-tags="active_major">
                                            <i class="fal fa-list"></i>
                                            <span class="nav-link-text" data-i18n="nav.active_major">Major List</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="#" title="Application Intel" data-filter-tags="application intel">
                                    <i class="fal fa-portrait"></i>
                                    <span class="nav-link-text" data-i18n="nav.application_intel">Sources</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/param/source/" title="Active Source" data-filter-tags="active_source">
                                            <i class="fal fa-list"></i>
                                            <span class="nav-link-text" data-i18n="nav.active_source">Source List</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="#" title="Application Intel" data-filter-tags="application intel">
                                    <i class="fal fa-portrait"></i>
                                    <span class="nav-link-text" data-i18n="nav.application_intel">Fees & Payments</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/examination" title="Active Student" data-filter-tags="active_student">
                                            <i class="fal fa-user"></i>
                                            <span class="nav-link-text" data-i18n="nav.active_student">Exam Transaction Data</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" title="Application Intel" data-filter-tags="application intel">
                                    <i class="fal fa-diagnoses"></i>
                                    <span class="nav-link-text" data-i18n="nav.application_intel">Status</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/supervisor" title="Supervisor List" data-filter-tags="sv_list">
                                            <span class="nav-link-text" data-i18n="nav.sv_list">Admission Status</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/supervisor/create" title="Sejarah" data-filter-tags="sejarah">
                                            <span class="nav-link-text" data-i18n="sejarah">Academic Status</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" title="Application Intel" data-filter-tags="application intel">
                                    <i class="fal fa-user"></i>
                                    <span class="nav-link-text" data-i18n="nav.application_intel">User</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/user" title="Active Student" data-filter-tags="active_student">
                                            <span class="nav-link-text" data-i18n="nav.active_student">List of Users</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" title="Laporan" data-filter-tags="laporan">
                                    <i class="fal fa-table"></i>
                                    <span class="nav-link-text" data-i18n="nav.laporan">Roles & Permission</span>
                                </a>
                                <ul>
                                    {{-- <li>
                                        <a href="/report-active-student" title="How it works" data-filter-tags="theme settings how it works">
                                            <span class="nav-link-text" data-i18n="nav.theme_settings_how_it_works">Active Student List</span>
                                        </a>
                                    </li> --}}
                                    <li>
                                        <a href="/module-auth" title="How it works" data-filter-tags="theme settings how it works">
                                            <span class="nav-link-text" data-i18n="nav.theme_settings_how_it_works">Module</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/role" title="How it works" data-filter-tags="theme settings how it works">
                                            <span class="nav-link-text" data-i18n="nav.theme_settings_how_it_works">Role</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/permission" title="How it works" data-filter-tags="theme settings how it works">
                                            <span class="nav-link-text" data-i18n="nav.theme_settings_how_it_works">Permission</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="#" title="Space Setting" data-filter-tags="space-setting">
                                    <i class="fal fa-building"></i>
                                    <span class="nav-link-text" data-i18n="nav.space-setting">Space</span>
                                </a>
                                <ul>
                                   <li>
                                        <a href="#" title="Space Settings" data-filter-tags="space">
                                            <span class="nav-link-text" data-i18n="nav.space">Space Settings</span>
                                        </a>

                                        <ul>
                                            <li>
                                                <a href="/space/campus" title="Campus" data-filter-tags="campus">
                                                    <i class="fal fa-university"></i>
                                                <span class="nav-link-text" data-i18n="nav.campus">Campus</span>
                                                </a>
                                            </li>
                                           <li>
                                                <a href="/space/zone" title="Zone" data-filter-tags="zone">
                                                    <i class="fal fa-location-arrow"></i>
                                                <span class="nav-link-text" data-i18n="nav.zone">Zone</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/space/building" title="Building" data-filter-tags="building">
                                                    <i class="fal fa-building"></i>
                                                <span class="nav-link-text" data-i18n="nav.building">Building</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/space/level" title="Level" data-filter-tags="level">
                                                    <i class="fal fa-bars"></i>
                                                   <span class="nav-link-text" data-i18n="nav.level">Level</span>
                                               </a>
                                           </li>
                                           <li>
                                                <a href="/space/roomtype" title="RoomType" data-filter-tags="room_type">
                                                    <i class="fal fa-wrench"></i>
                                                <span class="nav-link-text" data-i18n="nav.room_type">Room Type</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/space/roomsuitability" title="RoomSuitability" data-filter-tags="room_suitability">
                                                    <i class="fal fa-check-circle"></i>
                                                <span class="nav-link-text" data-i18n="nav.room_suitability">Room Suitability</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/space/roomfacility" title="RoomFacility" data-filter-tags="room_facility">
                                                    <i class="fal fa-desktop"></i>
                                                <span class="nav-link-text" data-i18n="nav.room_facility">Room Facility</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/space/roomowner" title="RoomOwner" data-filter-tags="room_owner">
                                                    <i class="fal fa-user-plus"></i>
                                                <span class="nav-link-text" data-i18n="nav.room_owner">Room Owner</span>
                                                </a>
                                            </li>
                                        </ul>

                                    </li>
                                    <li>
                                        <a href="#" title="Space Management" data-filter-tags="space">
                                            <span class="nav-link-text" data-i18n="nav.space">Space Management</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" title="Space Reservation" data-filter-tags="space">
                                            <span class="nav-link-text" data-i18n="nav.space">Space Reservation</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @endcan

                            @role('student')
                            <li class="nav-title">MAIN NAVIGATION [STUDENT]</li>
                            <li>
                                <a href="#" title="Stud_dashboard" data-filter-tags="stud_dashboard">
                                    <i class="fal fa-object-group"></i>
                                    <span class="nav-link-text" data-i18n="nav.stud_dashboard">Dashboard</span>
                                </a>
                            </li>

                            <li>
                                <a href="#" title="Stud_profile" data-filter-tags="stud_profile">
                                    <i class="fal fa-male"></i>
                                    <span class="nav-link-text" data-i18n="nav.stud_profile">Profile</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/student/biodata/basic_info/{{Auth::user()->id}}" title="Basic_info" data-filter-tags="basic_info">
                                            <span class="nav-link-text" data-i18n="nav.basic_info">Personal Info</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/student/biodata/addressContact_info/{{Auth::user()->id}}" title="Contact_info" data-filter-tags="contact_info">
                                            <span class="nav-link-text" data-i18n="nav.address_info">Update Contact Info</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="#" title="Stud_register" data-filter-tags="stud_register">
                                    <i class="fal fa-briefcase"></i>
                                    <span class="nav-link-text" data-i18n="nav.stud_register">Registration</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/student/registration/course_register" title="Course_register" data-filter-tags="course_register">
                                            <span class="nav-link-text" data-i18n="nav.course_register">Course Registration</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/student/registration/credit_exemption" title="Credit_exempt" data-filter-tags="credit_exempt">
                                            <span class="nav-link-text" data-i18n="nav.credit_exempt">Credit Exemption</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/student/registration/project_info" title="eProject" data-filter-tags="e_project">
                                            <span class="nav-link-text" data-i18n="nav.e_project">Project Info</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" title="Industrial_training" data-filter-tags="industrial_training">
                                            <span class="nav-link-text" data-i18n="nav.industrial_training">Industrial Training</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="#" title="Examination" data-filter-tags="examination">
                                    <i class="fal fa-chart-bar"></i>
                                    <span class="nav-link-text" data-i18n="nav.examination">Examination</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/student/examination/course_performance" title="Course_perform" data-filter-tags="course_perform">
                                            <span class="nav-link-text" data-i18n="nav.course_perform">Course Performance</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/student/examination/exam_details" title="Exam_details" data-filter-tags="exam_details">
                                            <span class="nav-link-text" data-i18n="nav.exam_details">Examination Details</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="#" title="Graduation" data-filter-tags="graduate">
                                    <i class="fal fa-graduation-cap"></i>
                                    <span class="nav-link-text" data-i18n="nav.graduate">Graduation</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/student/graduation/graduation_info" title="Graduate_audit" data-filter-tags="graduate_audit">
                                            <span class="nav-link-text" data-i18n="nav.graduate_audit">Graduation Audit Checklist</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="#" title="Stud_account" data-filter-tags="stud_account">
                                    <i class="fal fa-book"></i>
                                    <span class="nav-link-text" data-i18n="nav.stud_account">Student Account</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/student/financial/stud_statement" title="Financial" data-filter-tags="financial">
                                            <span class="nav-link-text" data-i18n="nav.financial">Financial Statement</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="#" title="Others" data-filter-tags="others">
                                    <i class="fal fa-map-signs"></i>
                                    <span class="nav-link-text" data-i18n="nav.others">Others</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/student/others/activity_trans" title="Activities" data-filter-tags="activities">
                                            <span class="nav-link-text" data-i18n="nav.activities">Activities Transcript</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/student/others/residential_rcrd" title="Residential" data-filter-tags="residential">
                                            <span class="nav-link-text" data-i18n="nav.residential">Residential Record</span>
                                        </a>
                                    </li>
                                    {{-- <li>
                                        <a href="/student/others/resident_electric" title="Resident_sticker" data-filter-tags="resident_sticker">
                                            <span class="nav-link-text" data-i18n="nav.resident_sticker">Residential Electric Sticker</span>
                                        </a>
                                    </li> --}}
                                    <li>
                                        <a href="/student/others/vehicle_rcrd" title="Vehicle" data-filter-tags="vehicle">
                                            <span class="nav-link-text" data-i18n="nav.vehicle">Vehicle Record</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="#" title="Services" data-filter-tags="services">
                                    <i class="fal fa-sun"></i>
                                    <span class="nav-link-text" data-i18n="nav.services">Services</span>
                                </a>
                                <ul>
                                    {{-- <li>
                                        <a href="#" title="Bus_track" data-filter-tags="bus_track">
                                            <span class="nav-link-text" data-i18n="nav.bus_track">INTEC Bus Tracking</span>
                                        </a>
                                    </li> --}}
                                    {{-- <li>
                                        <a href="#" title="Wifi" data-filter-tags="wifi">
                                            <span class="nav-link-text" data-i18n="nav.wifi">Wifi@INTEC</span>
                                        </a>
                                    </li> --}}
                                    <li>
                                        <a href="/student/services/sw_download" title="Software" data-filter-tags="software">
                                            <span class="nav-link-text" data-i18n="nav.software">Software Downloads</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <form action="{{ route('logout') }}" id="logout-form"  method="POST">
                                    @csrf
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <i class="fal fa-sign-out-alt"></i>Sign Out</a>
                                </form>
                            </li>
                            @endrole

                        </ul>
                        <div class="filter-message js-filter-message bg-success-600"></div>

                        {{-- @php
                            $user = Auth::user();
                            $permissionNames = $user->getPermissionNames();
                            // dd($user);
                            dd($permissionNames);
                        @endphp --}}
                    </nav>
                    <!-- END PRIMARY NAVIGATION -->
                    <!-- NAV FOOTER -->

                </aside>
                <!-- END Left Aside -->
                <div class="page-content-wrapper">
                    <!-- BEGIN Page Header -->
                    <header class="page-header" role="banner">
                        <!-- we need this logo when user switches to nav-function-top -->
                        <div class="page-logo">
                            <a href="#" class="page-logo-link press-scale-down d-flex align-items-center position-relative" data-toggle="modal" data-target="#modal-shortcut">
                                <img src="{{asset('img/logo.png')}}" alt="SmartAdmin WebApp" aria-roledescription="logo">
                                <span class="page-logo-text mr-1"><b>INTEC</b> CMS</span>
                                <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2">SeedProject</span>
                                <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
                            </a>
                        </div>
                        <!-- DOC: nav menu layout change shortcut -->
                        <div class="hidden-md-down dropdown-icon-menu position-relative">
                            <a href="#" class="header-btn btn js-waves-off" data-action="toggle" data-class="nav-function-hidden" title="Hide Navigation">
                                <i class="ni ni-menu"></i>
                            </a>
                            <ul>
                                <li>
                                    <a href="#" class="btn js-waves-off" data-action="toggle" data-class="nav-function-minify" title="Minify Navigation">
                                        <i class="ni ni-minify-nav"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="btn js-waves-off" data-action="toggle" data-class="nav-function-fixed" title="Lock Navigation">
                                        <i class="ni ni-lock-nav"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- DOC: mobile button appears during mobile width -->
                        <div class="hidden-lg-up">
                            <a href="#" class="header-btn btn press-scale-down" data-action="toggle" data-class="mobile-nav-on">
                                <i class="ni ni-menu"></i>
                            </a>
                        </div>
                        <div class="ml-auto d-flex">

                            <!-- app user menu -->
                            <div>
                                <a href="#" data-toggle="dropdown" title="drlantern@gotbootstrap.com" class="header-icon d-flex align-items-center justify-content-center ml-2">
                                    <img src="{{asset('img/demo/avatars/avatar-m.png')}}" class="profile-image rounded-circle" alt="">
                                    <!-- you can also add username next to the avatar with the codes below:
									<span class="ml-1 mr-1 text-truncate text-truncate-header hidden-xs-down">Me</span>
									<i class="ni ni-chevron-down hidden-xs-down"></i> -->
                                </a>
                                <div class="dropdown-menu dropdown-menu-animated dropdown-lg">
                                    <div class="dropdown-header bg-trans-gradient d-flex flex-row py-4 rounded-top">
                                        <div class="d-flex flex-row align-items-center mt-1 mb-1 color-white">
                                            <span class="mr-2">
                                                <img src="{{asset('img/demo/avatars/avatar-m.png')}}" class="rounded-circle profile-image" alt="Dr. Codex Lantern">
                                            </span>
                                            <div class="info-card-text">
                                                <div class="fs-lg text-truncate text-truncate-lg">{{Auth::user()->name}}</div>
                                                <span class="text-truncate text-truncate-md opacity-80">{{Auth::user()->email}}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="dropdown-divider m-0"></div>
                                    <a class="dropdown-item fw-500 pt-3 pb-3" href="">
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                        <!--span data-i18n="drpdwn.page-logout">Logout</span-->
                                        <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                                        <!--span class="float-right fw-n">&commat;codexlantern</span-->
                                        </form>


                                    </a>
                                </div>
                            </div>
                        </div>
                    </header>
                    <!-- END Page Header -->
                    <!-- BEGIN Page Content -->
                    <!-- the #js-page-content id is needed for some plugins to initialize -->

                        <!--@yield('breadcrumbs')-->
                        @yield('content')

                    <!-- this overlay is activated only when mobile menu is triggered -->
                    <div class="page-content-overlay" data-action="toggle" data-class="mobile-nav-on"></div> <!-- END Page Content -->
                    <!-- BEGIN Page Footer -->
                    <footer class="page-footer" role="contentinfo">
                        <div class="d-flex align-items-center flex-1 text-muted">
                            <span class="hidden-md-down fw-700">2020 </span>© INTEC Education College
                        </div>
                    </footer>
                    <!-- END Page Footer -->

                </div>
            </div>
        </div>
        <!-- END Page Wrapper -->

        <!-- END Quick Menu -->

        <!-- base vendor bundle:
			 DOC: if you remove pace.js from core please note on Internet Explorer some CSS animations may execute before a page is fully loaded, resulting 'jump' animations
						+ pace.js (recommended)
						+ jquery.js (core)
						+ jquery-ui-cust.js (core)
						+ popper.js (core)
						+ bootstrap.js (core)
						+ slimscroll.js (extension)
						+ app.navigation.js (core)
						+ ba-throttle-debounce.js (core)
						+ waves.js (extension)
						+ smartpanels.js (extension)
						+ src/../jquery-snippets.js (core) -->
        <script src="{{asset('js/vendors.bundle.js')}}"></script>
        <script src="{{asset('js/app.bundle.js')}}"></script>
        <script src="{{asset('js/datagrid/datatables/datatables.bundle.js')}}"></script>
        <script src="{{ asset('js/notifications/sweetalert2/sweetalert2.bundle.js') }}"></script>

        {{-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script> --}}

        {{-- <script src="{{asset('js/select2.min.js')}}"></script> --}}
        <link rel="stylesheet" media="screen, print" href="{{asset('css/formplugins/select2/select2.bundle.css')}}">
        <script src="{{asset('js/formplugins/select2/select2.bundle.js')}}"></script>

        <script src="{{ asset('js/formplugins/summernote/summernote.js') }}"></script>

        @yield('script')
        <script>
            $('.collapsable-list li a').on('click', function(){
                $('.collapsable-list').find('a').next().collapse('hide');
                $(this).next().collapse('toggle');
            });

            $(function(){
                $('li a').each(function(x,val)
                {
                    var link = $(this).attr('href');
                    var url = "{{ url()->current() }}";
                    if( link && url.indexOf(link) !== -1)
                    {
                        $(this).addClass('highlight');
                        $(this).parent().parent().attr('style','display:block');
                        $(this).parent()
                        .addClass('open')
                        .find("a:first")
                        .attr('aria-expanded', true)
                        .find("b:first")
                        .delay(500)
                        .html(`<em class="fal fa-angle-up"></em>`);
                    }
                    else
                    {
                        $(this).removeClass('highlight');
                        // $(this).parent().parent().attr('style','display:none');
                        $(this).parent()
                        .removeClass('open')
                        .find("a:first")
                        .attr('aria-expanded', false)
                        .find("b:first")
                        .delay(500)
                        .html(`<em class="fal fa-angle-down"></em>`);
                    }
                })
            });
        </script>

    </body>
</html>
