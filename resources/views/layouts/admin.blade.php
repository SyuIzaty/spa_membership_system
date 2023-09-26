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

    @yield('css')
    <!-- base css -->
    <link rel="stylesheet" media="screen, print" href="{{ asset('css/vendors.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ asset('css/app.bundle.css') }}">
    <!-- Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon/favicon-32x32.png') }}">
    <link rel="stylesheet" href="{{ asset('css/statistics/chartjs/chartjs.css.map') }}">
    <link rel="stylesheet" href="{{ asset('css/statistics/chartjs/chartjs.css') }}">
    <link rel="mask-icon" href="{{ asset('img/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
    <!--<link rel="stylesheet" media="screen, print" href="css/your_styles.css">-->
    <link rel="stylesheet" media="screen, print" href="{{ asset('css/datagrid/datatables/datatables.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/notifications/sweetalert2/sweetalert2.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ asset('css/formplugins/dropzone/dropzone.css') }}">
    {{-- <link rel="stylesheet" media="screen, print" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"> --}}

    {{-- <link rel="stylesheet" media="screen, print" href="{{asset('css/select2.min.css')}}"> --}}
    <link rel="stylesheet" href="{{ asset('css/formplugins/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('css/indicator.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.fancybox.css') }}" />
    <style>
        .highlight {
            font-weight: bolder;
        }
    </style>
</head>

<body class="mod-bg-1 mod-nav-link">

    <!-- BEGIN Page Wrapper -->
    <div class="page-wrapper">
        <div class="page-inner">
            <!-- BEGIN Left Aside -->
            <aside class="page-sidebar">
                <div class="page-logo">
                    <a href="#"
                        class="page-logo-link press-scale-down d-flex align-items-center position-relative"
                        data-toggle="modal" data-target="#modal-shortcut">
                        {{-- <img src="{{asset('img/logo.png')}}" alt="SmartAdmin WebApp" aria-roledescription="logo"> --}}

                        <span class="page-logo-text mr-1"><b>INTEC</b> IDS</span>
                        <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
                    </a>
                </div>
                <!-- BEGIN PRIMARY NAVIGATION -->
                <nav id="js-primary-nav" class="primary-nav" role="navigation">
                    <div class="nav-filter">
                        <div class="position-relative">
                            <input type="text" id="nav_filter_input" placeholder="Filter menu" class="form-control"
                                tabindex="0">
                            <a href="#" onclick="return false;" class="btn-primary btn-search-close js-waves-off"
                                data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar">
                                <i class="fal fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="info-card">
                        <img src="{{ asset('img/demo/avatars/avatar-m.png') }}" class="profile-image rounded-circle"
                            alt="Dr. Codex Lantern">
                        <div class="info-card-text">
                            <a href="#" class="d-flex align-items-center text-white">
                                <span class="text-truncate text-truncate-sm d-inline-block">
                                    {{ Auth::user()->name }}
                                </span>
                            </a>
                            <span
                                class="d-inline-block text-truncate text-truncate-sm">{{ Auth::user()->email }}</span>
                        </div>
                        <img src="{{ asset('img/card-backgrounds/cover-2-lg.png') }}" class="cover" alt="cover">
                        <a href="#" onclick="return false;" class="pull-trigger-btn" data-action="toggle"
                            data-class="list-filter-active" data-target=".page-sidebar" data-focus="nav_filter_input">
                            <i class="fal fa-angle-down"></i>
                        </a>
                    </div>

                    <ul id="js-nav-menu" class="nav-menu">
                        <li class="nav-title">Dashboard</li>
                        <li>
                            <a href="/home" title="Application Intel" data-filter-tags="application intel">
                                <i class="fal fa-chart-pie"></i>
                                <span class="nav-link-text" data-i18n="nav.application_intel">Dashboard</span>
                            </a>
                        </li>
                        @canany(['View Card'])
                            <li>
                                <a href="/card/staff" title="Staff Card" data-filter-tags="Staff Card">
                                    <i class="fal fa-id-card"></i>
                                    <span class="nav-link-text" data-i18n="nav.staff_card">Staff Card</span>
                                </a>
                            </li>
                        @endcanany

                        {{-- @role('Super Admin') --}}
                        {{-- @canany(['Rent Form'])
                            <li>
                                <a href="#" title="Rent Form" data-filter-tags="Rent Form">
                                    <i class="fal fa-clipboard-list"></i>
                                    <span class="nav-link-text" data-i18n="nav.rent_form">ICT Equipment Rental</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/test2" title="Rental Form" data-filter-tags="Rental Form">
                                            <span class="nav-link-text" data-i18n="nav.rental_form">Rental Form</span>
                                        </a>
                                    </li>
                                    @canany(['Manage Rent Form'])
                                        <li>
                                            <a href="/show" title="View Record" data-filter-tags="View Record">
                                                <span class="nav-link-text" data-i18n="nav.view_record">View Record</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/report" title="View Report" data-filter-tags="View Report">
                                                <span class="nav-link-text" data-i18n="nav.report">Report</span>
                                            </a>
                                        </li>
                                    @endcanany
                                    <li>
                                        <a href="/showApplication" title="Application" data-filter-tags="Application">
                                            <span class="nav-link-text" data-i18n="nav.showApplication">Application</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcanany --}}
                        {{-- @endrole --}}
                        {{-- Start Aduan --}}
                        @php
                            // $user = Auth()->user();
                            // $permission = $user->getAllPermissions();
                            // echo ($user);
                            // echo ($permission);
                        @endphp

                        <!-- Start SOP System -->

                        @php
                            $isAdmin = Auth::user()->hasRole('SOP Admin');
                            $owner = App\SopOwner::where('owner_id', Auth::user()->id)->first();
                        @endphp

                        @role('Staff')
                            <li class="nav-title">SOP Management</li>
                            <li>
                                <a href="/sop-list" style="text-decoration: none!important;" title="SOP"
                                    data-filter-tags="list">
                                    <i class="fal fa-list"></i>
                                    <span class="nav-link-text" data-i18n="nav.sop">SOP</span>
                                </a>
                            </li>
                            @if ($isAdmin || isset($owner))
                                <li>
                                    <a href="/sop" style="text-decoration: none!important;" title="SOP Progress"
                                        data-filter-tags="list">
                                        <i class="ni ni-briefcase"></i>
                                        <span class="nav-link-text" data-i18n="nav.sop">SOP Progress</span>
                                    </a>
                                </li>
                                @if ($isAdmin)
                                    <li class="open">
                                        <a href="#" title="SOP Admin" data-filter-tags="list">
                                            <i class="fal fa-user"></i>
                                            <span class="nav-link-text" data-i18n="nav.list">Admin</span>
                                        </a>
                                        <ul>
                                            <li>
                                                <a href="/sop-title" title="SOP Title" data-filter-tags="sopTitle">
                                                    <span class="nav-link-text" data-i18n="nav.sopTitle">SOP Title</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/sop-department" title="Department List"
                                                    data-filter-tags="department">
                                                    <span class="nav-link-text"
                                                        data-i18n="nav.department">Department</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="/sop-owner" title="SOP Owner List" data-filter-tags="owner">
                                                    <span class="nav-link-text" data-i18n="nav.owner">SOP Owner</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                @endif
                            @endif
                        @endrole

                        <!-- End SOP System -->

                        <!-- Start eAduan Korporat System -->
                        @role('eAduan Super Admin')
                            <li class="nav-title">i-Complaint</li>
                            <li>
                                <a href="/iComplaint" style="text-decoration: none!important;" title="Form"
                                    data-filter-tags="form" target="_blank">
                                    <i class="fal fa-file-alt"></i>
                                    <span class="nav-link-text" data-i18n="nav.form">i-Complaint</span>
                                </a>
                            </li>

                            @can('assign department')
                                <li>
                                    <a href="/dashboard-icomplaint" title="Dashboard i-Complaint"
                                        data-filter-tags="dashboard">
                                        <i class="fal fa-chart-pie"></i>
                                        <span class="nav-link-text" data-i18n="nav.dashboard">Dashboard</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="/reports" title="Report" data-filter-tags="report">
                                        <i class="fal fa-clipboard-list"></i>
                                        <span class="nav-link-text" data-i18n="nav.report">Report</span>
                                    </a>
                                </li>
                            @endcan

                            @can('take action')
                                <li class="open">
                                    <a href="#" title="iComplaint List" data-filter-tags="list">
                                        <i class="fal fa-list"></i>
                                        <span class="nav-link-text" data-i18n="nav.list">List</span>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="/lists/2" title="Pending List" data-filter-tags="pending">
                                                <span class="nav-link-text" data-i18n="nav.pending">Pending</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/lists/4" title="Complete List" data-filter-tags="complete">
                                                <span class="nav-link-text" data-i18n="nav.complete">Complete</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan

                            @can('assign department')
                                <li class="open">
                                    <a href="#" title="Complaint List" data-filter-tags="list">
                                        <i class="fal fa-list"></i>
                                        <span class="nav-link-text" data-i18n="nav.list">Complaint List</span>
                                    </a>
                                    <ul>
                                        <li>
                                            @inject('lists', 'App\AduanKorporat')
                                            <a href="/lists/1" title="Pending" data-filter-tags="pending">
                                                <span class="nav-link-text" data-i18n="nav.pending">Pending
                                                    ({{ $lists->countPending() }})</span>
                                            </a>
                                        </li>
                                        @inject('lists', 'App\AduanKorporat')
                                        <li>
                                            <a href="/lists/2" title="Has Assigned" data-filter-tags="assign">
                                                <span class="nav-link-text" data-i18n="nav.assign">Has Assigned
                                                    ({{ $lists->countAssigned() }})</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/lists/3" title="Action Taken" data-filter-tags="action">
                                                <span class="nav-link-text" data-i18n="nav.action">Action Taken
                                                    ({{ $lists->countAction() }})</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/lists/4" title="Completed" data-filter-tags="completed">
                                                <span class="nav-link-text" data-i18n="nav.completed">Completed
                                                    ({{ $lists->countCompleted() }})</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan

                            {{-- @role('eAduan Super Admin') --}}
                            <li class="open">
                                <a href="#" title="Setting" data-filter-tags="setting">
                                    <i class="fal fa-cogs"></i>
                                    <span class="nav-link-text" data-i18n="nav.setting">Setting</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/admin-list" title="Admin" data-filter-tags="admin">
                                            <span class="nav-link-text" data-i18n="nav.admin">Admin</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/status-list" title="Status" data-filter-tags="status">
                                            <span class="nav-link-text" data-i18n="nav.status">Status</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/category-lists" title="Category" data-filter-tags="category">
                                            <span class="nav-link-text" data-i18n="nav.category">Category</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/user-category-list" title="User Category"
                                            data-filter-tags="usercategory">
                                            <span class="nav-link-text" data-i18n="nav.usercategory">User Category</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/subcategory-list" title="Sub Category" data-filter-tags="subcategory">
                                            <span class="nav-link-text" data-i18n="nav.subcategory">Subcategory</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endrole

                        <!-- End eAduan Korporat System -->

                        <!-- Start eKenderaan Management System -->
                        <li class="nav-title">e-Kenderaan</li>
                        <li>
                            <a href="/ekenderaan-application" title="eKenderaan Form"
                                data-filter-tags="eKenderaan-form">
                                <i class="fal fa-file-alt"></i>
                                <span class="nav-link-text" data-i18n="nav.eKenderaan-form">Application</span>
                            </a>
                        </li>
                        <li>
                            <a href="/user-manual" title="User Manual" data-filter-tags="User Manual"
                                target="_blank" style="text-decoration: none!important">
                                <i class="fal fa-info"></i>
                                <span class="nav-link-text" data-i18n="nav.user-manual">User Manual</span>
                            </a>
                        </li>
                        @role('eKenderaan Admin')
                            <li class="open">
                                <a href="#" title="List" data-filter-tags="list">
                                    <i class="fal fa-list"></i>
                                    <span class="nav-link-text" data-i18n="nav.list">Admin</span>
                                </a>
                                <ul>
                                    @inject('grant', 'App\eKenderaan')
                                    <li>
                                        <a href="/eKenderaan-list/2" title="Pending Operation"
                                            data-filter-tags="hodHopApproved">
                                            <span class="nav-link-text" data-i18n="nav.hodhopApproved">Pending
                                                ({{ $grant->countOperationPending() }})</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/eKenderaan-list/3" title="Operation Verified"
                                            data-filter-tags="adminApproved">
                                            <span class="nav-link-text" data-i18n="nav.adminApproved">Verified
                                                ({{ $grant->countAdminVerified() }})</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/eKenderaan-list/5" title="Feedback Submitted"
                                            data-filter-tags="feedbackSubmitted">
                                            <span class="nav-link-text" data-i18n="nav.feedbackSubmitted">Feedback
                                                Submitted
                                                ({{ $grant->countFeedbackSubmitted() }})</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/eKenderaan-list/4" title="Rejected" data-filter-tags="rejected">
                                            <span class="nav-link-text" data-i18n="nav.rejected">Rejected
                                                ({{ $grant->countRejected() }})</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/eKenderaan-list/6" title="Cancelled" data-filter-tags="cancelled">
                                            <span class="nav-link-text" data-i18n="nav.cancelled">Cancelled
                                                ({{ $grant->countCancelled() }})</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="open">
                                <a href="#" title="Setting" data-filter-tags="setting">
                                    <i class="fal fa-cogs"></i>
                                    <span class="nav-link-text" data-i18n="nav.setting">Setting</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/eKenderaan-driver" title="Driver" data-filter-tags="ekenderaanDriver">
                                            <span class="nav-link-text" data-i18n="nav.ekenderaanDriver">Driver</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/eKenderaan-vehicle" title="Vehicle"
                                            data-filter-tags="ekenderaanVehicle">
                                            <span class="nav-link-text" data-i18n="nav.ekenderaanVehicle">Vehicle</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/eKenderaan-feedback-questions" title="Question"
                                            data-filter-tags="ekenderaanQuestions">
                                            <span class="nav-link-text" data-i18n="nav.ekenderaanQuestions">Feedback
                                                Questions</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="open">
                                <a href="#" title="Report" data-filter-tags="report">
                                    <i class="fal fa-clipboard-list"></i>
                                    <span class="nav-link-text" data-i18n="nav.report">Report</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/ekn-report" title="Report" data-filter-tags="report">
                                            <span class="nav-link-text" data-i18n="nav.report">Application</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/ekn-driver-report" title="Driver" data-filter-tags="driver">
                                            <span class="nav-link-text" data-i18n="nav.driver">Driver</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endrole

                        <!-- End eKenderaan Management System -->
                        \
                        <!-- Start eDocument Management System -->
                        @role('Staff')
                            <li class="nav-title">eDocument Management</li>
                            <li>
                                <a href="/index" title="Document" data-filter-tags="doc">
                                    <i class="fal fa-file"></i>
                                    <span class="nav-link-text" data-i18n="nav.document">Document</span>
                                </a>
                            </li>
                        @endrole
                        @role('eDocument (Super Admin)')
                            <li>
                                <a href="/department-list" title="Admin" data-filter-tags="doc">
                                    <i class="fal fa-users"></i>
                                    <span class="nav-link-text" data-i18n="nav.admin">Admin List</span>
                                </a>
                            </li>
                        @endrole
                        <!-- End eDocument Management System -->

                        <!-- Start eVoting Management System -->

                        <li class="nav-title">E-VOTING</li>

                        @can('Manage eVoting')
                            <li>
                                <a href="#" title="e-Voting Management"
                                    data-filter-tags="vote-management">
                                    <i class="ni ni-briefcase"></i>
                                    <span class="nav-link-text" data-i18n="nav.vote-management">Voting Management</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/voting-dashboard" title="dashboard" data-filter-tags="dashboard">
                                            <span class="nav-link-text" data-i18n="nav.dashboard">Dashboard Analysis</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/voting-manage" title="parameter" data-filter-tags="parameter">
                                            <span class="nav-link-text" data-i18n="nav.parameter">Manage Voting</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/voting-report" title="report" data-filter-tags="report">
                                            <span class="nav-link-text" data-i18n="nav.report">Manage Report</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan

                        @can('View eVoting Platform')
                            <li>
                                <a href="/voting-platform" title="platform" data-filter-tags="platform">
                                    <i class="ni ni-envelope-letter"></i>
                                    <span class="nav-link-text" data-i18n="nav.platform">Voting Platform</span>
                                </a>
                            </li>
                        @endcan

                        @role('Super Admin')
                            <li class="nav-title">E-VOTING OLD VERSION</li>
                            @can('eVoting - Management System')
                                <li>
                                    <a href="/vote-management" title="e-Voting Management"
                                        data-filter-tags="vote-management">
                                        <!-- <i class="fal fa-file"></i> -->
                                        <i class="ni ni-briefcase"></i>
                                        <span class="nav-link-text" data-i18n="nav.vote-management">e-Voting Management</span>
                                    </a>
                                </li>
                            @endcan
                            <li>
                                <a href="/vote-platform" title="e-Voting Platform" data-filter-tags="vote-platform">
                                    <!-- <i class="fal fa-file"></i> -->
                                    <i class="ni ni-envelope-letter"></i>
                                    <span class="nav-link-text" data-i18n="nav.vote-platform">e-Voting Platform</span>
                                </a>
                            </li>
                            @can('eVoting - View Report')
                                <li>
                                    <a href="/vote-report" title="e-Voting Report" data-filter-tags="vote-report">
                                        <!-- <i class="fal fa-file"></i> -->
                                        <i class="ni ni-doc"></i>
                                        <span class="nav-link-text" data-i18n="nav.vote-report">e-Voting Report</span>
                                    </a>
                                </li>
                            @endcan
                        @endrole

                        <!-- End eVoting Management System -->

                        <!-- Start Engagement Management System -->

                        {{-- @role('Engagement (Admin)|Engagement (Team Member)')
                            <li class="nav-title">Engagement Management</li>
                            <li>
                                <a href="/list/active" title="Active Engagement" data-filter-tags="engagement">
                                    <i class="fal fa-users"></i>
                                    <span class="nav-link-text" data-i18n="nav.engagement">Active Engagement</span>
                                </a>
                            </li>
                            <li>
                                <a href="/list/complete" title="Completed Engagement" data-filter-tags="engagement">
                                    <i class="fal fa-file-check"></i>
                                    <span class="nav-link-text" data-i18n="nav.engagement">Completed Engagement</span>
                                </a>
                            </li>
                            </li>
                            <li class="open">
                                <a href="#" title="Setting" data-filter-tags="setting">
                                    <i class="fal fa-cogs"></i>
                                    <span class="nav-link-text" data-i18n="nav.setting">Setting</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/status" title="Status" data-filter-tags="emsstatus">
                                            <span class="nav-link-text" data-i18n="nav.emsstatus">Status</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endrole --}}
                        <!-- End Engagement Management System -->

                        <!-- Start ShortCourse Management System -->
                        @role('Super Admin')
                        @can('Short Course Management - View All')
                            <li class="nav-title">Short Course Management</li>
                            <li>
                                <a href="#" title="Catalogues" data-filter-tags="catalogues">
                                    <i class="ni ni-list"></i>
                                    <span class="nav-link-text" data-i18n="nav.catalogues">Catalogues</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/topics" title="Topic" data-filter-tags="topic-catalogue">
                                            <i class="ni ni-book-open"></i>
                                            <span class="nav-link-text" data-i18n="nav.topic-catalogue">Topic-Category
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/shortcourses" title="Course" data-filter-tags="course-catalogue">
                                            <i class="ni ni-book-open"></i>
                                            <span class="nav-link-text" data-i18n="nav.course-catalogue">Course
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/venues" title="Venue" data-filter-tags="venue-catalogue">
                                            <i class="ni ni-book-open"></i>
                                            <span class="nav-link-text" data-i18n="nav.venue-catalogue">Venue
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/feedback-sets" title="Feedback Set"
                                            data-filter-tags="feedback-set-catalogue">
                                            <i class="ni ni-book-open"></i>
                                            <span class="nav-link-text" data-i18n="nav.feedback-set-catalogue">Feedback
                                                Set
                                            </span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="/trainers" title="Trainer" data-filter-tags="trainer">
                                            <i class="ni ni-earphones-alt"></i>
                                            <span class="nav-link-text" data-i18n="nav.trainer">Trainer</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <li>
                                <a href="/events" title="Event Management" data-filter-tags="event-management">
                                    <i class="ni ni-calendar-fine"></i>
                                    <span class="nav-link-text" data-i18n="nav.event-management">Event Management</span>
                                </a>
                            </li>
                        <li>
                                <a href="#" title="People" data-filter-tags="people">
                                    <i class="ni ni-list"></i>
                                    <span class="nav-link-text" data-i18n="nav.people">People</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/participants" title="Participant" data-filter-tags="participant">
                                            <i class="ni ni-users"></i>
                                            <span class="nav-link-text" data-i18n="nav.participant">Participant</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <li>
                                <a href="#" title="Application" data-filter-tags="application">
                                    <i class="ni ni-list"></i>
                                    <span class="nav-link-text" data-i18n="nav.application">Application</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="#" title="Records" data-filter-tags="records">
                                            <i class="ni ni-notebook"></i>
                                            <span class="nav-link-text" data-i18n="nav.records">Records</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                        <li>
                                <a href="/shortcourse" title="Public View" data-filter-tags="shortcourse">
                                    <i class="fal fa-users"></i>
                                    <span class="nav-link-text" data-i18n="nav.shortcourse">Public View</span>
                                </a>
                            </li>

                        <li>
                                <a href="/feedback/form" title="Feedback" data-filter-tags="feedback">
                                    <i class="ni ni-note"></i>
                                    <span class="nav-link-text" data-i18n="nav.shortcourse">Feedback</span>
                                </a>
                            </li>
                        @endcan
                        @endrole
                        <!-- End ShortCourse Management System -->

                        {{-- Start Aduan --}}
                        <li class="nav-title">E-ADUAN</li>
                        @can('view technical admin')
                            <li>
                                <a href="/dashboard-aduan" title="Application Intel"
                                    data-filter-tags="application intel">
                                    <i class="fal fa-chart-pie"></i>
                                    <span class="nav-link-text" data-i18n="nav.application_intel">Dashboard Aduan</span>
                                </a>
                            </li>
                        @endcan
                        @can('view complaint form')
                            <li>
                                <a href="#" title="Aduan" data-filter-tags="aduan">
                                    <i class="fal fa-users"></i>
                                    <span class="nav-link-text" data-i18n="nav.aduan">Permohonan Aduan</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/borang-aduan" title="Borang Aduan" data-filter-tags="borang">
                                            <span class="nav-link-text" data-i18n="nav.borang"> Borang Aduan</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/aduan-individu" title="Senarai Aduan" data-filter-tags="senarai">
                                            <span class="nav-link-text" data-i18n="nav.senarai"> Senarai Aduan</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/manual-aduan" title="Manual Pengguna"
                                            data-filter-tags="Manual Pengguna" target="_blank"
                                            style="text-decoration: none!important">
                                            <span class="nav-link-text" data-i18n="nav.user-manual">Manual Pengguna</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan
                        @can('view complaint list')
                            @can('view technical admin')
                                <li class="open">
                                    <a href="#" title="Aduan" data-filter-tags="aduan">
                                        <i class="fal fa-list"></i>
                                        <span class="nav-link-text" data-i18n="nav.aduan">Pengurusan Aduan</span>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="/senarai-aduan" title="Dalam Tindakan" data-filter-tags="dlm_tindakan">
                                                <span class="nav-link-text" data-i18n="nav.dlm_tindakan"> Dalam
                                                    Tindakan</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/senarai-selesai" title="Aduan Selesai" data-filter-tags="selesai">
                                                <span class="nav-link-text" data-i18n="nav.selesai"> Selesai</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/senarai-kiv" title="Aduan KIV" data-filter-tags="kiv">
                                                <span class="nav-link-text" data-i18n="nav.kiv"> KIV </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/senarai-bertindih" title="Aduan Bertindih"
                                                data-filter-tags="bertindih">
                                                <span class="nav-link-text" data-i18n="nav.bertindih"> Bertindih</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan
                            @can('view technical staff')
                                <li class="open">
                                    <a href="#" title="Aduan" data-filter-tags="aduan">
                                        <i class="fal fa-list"></i>
                                        <span class="nav-link-text" data-i18n="nav.aduan">Pengurusan Aduan Juruteknik</span>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="/senarai-teknikal" title="Dalam Tindakan"
                                                data-filter-tags="dlm_tindakan">
                                                <span class="nav-link-text" data-i18n="nav.dlm_tindakan"> Dalam
                                                    Tindakan</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/senarai-teknikal-selesai" title="Aduan Selesai"
                                                data-filter-tags="selesai">
                                                <span class="nav-link-text" data-i18n="nav.selesai"> Selesai</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/senarai-teknikal-kiv" title="Aduan KIV" data-filter-tags="kiv">
                                                <span class="nav-link-text" data-i18n="nav.kiv"> KIV </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/senarai-teknikal-bertindih" title="Aduan Bertindih"
                                                data-filter-tags="bertindih">
                                                <span class="nav-link-text" data-i18n="nav.bertindih"> Bertindih</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan
                            <li>
                                <a href="#" title="Laporan" data-filter-tags="laporan">
                                    <i class="fal fa-file-excel"></i>
                                    <span class="nav-link-text" data-i18n="nav.laporan">Laporan</span>
                                </a>
                                <ul>
                                    @canany(['view technical admin', 'view technical staff'])
                                        @can('view technical admin')
                                            <li>
                                                <a href="/export_aduan" title="Kategori" data-filter-tags="kategori">
                                                    <span class="nav-link-text" data-i18n="nav.kategori">Keseluruhan</span>
                                                </a>
                                            </li>
                                        @endcan
                                        <li>
                                            <a href="/export_aduan_staf" title="Kategori" data-filter-tags="kategori">
                                                <span class="nav-link-text" data-i18n="nav.kategori">Juruteknik</span>
                                            </a>
                                        </li>
                                    @endcanany
                                </ul>
                            </li>
                            @can('view complaint parameter')
                                <li>
                                    <a href="#" title="Parameter" data-filter-tags="parameter">
                                        <i class="fal fa-list-alt"></i>
                                        <span class="nav-link-text" data-i18n="nav.parameter">Pengurusan Parameter</span>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="/kategori-aduan" title="Kategori" data-filter-tags="kategori">
                                                <span class="nav-link-text" data-i18n="nav.kategori">Kategori Aduan</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/jenis-kerosakan" title="Jenis" data-filter-tags="jenis">
                                                <span class="nav-link-text" data-i18n="nav.jenis">Jenis Kerosakan</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/sebab-kerosakan" title="Sebab" data-filter-tags="sebab">
                                                <span class="nav-link-text" data-i18n="nav.sebab">Sebab Kerosakan</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/alat-ganti" title="Sebab" data-filter-tags="sebab">
                                                <span class="nav-link-text" data-i18n="nav.sebab">Alat/Bahan Ganti</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan
                        @endcan
                        {{-- End Aduan --}}

                        {{-- Start Training --}}
                        @can('view training component')
                            <li class="nav-title">TRAINING RECORD MANAGEMENT</li>

                            <li>
                                <a href="/training-dashboard" title="Application Intel"
                                    data-filter-tags="application intel">
                                    <i class="fal fa-chart-pie"></i>
                                    <span class="nav-link-text" data-i18n="nav.application_intel">Analysis
                                        Dashboard</span>
                                </a>
                            </li>

                            <li class="open">
                                <a href="#" title="Training" data-filter-tags="training">
                                    <i class="fal fa-location-arrow"></i>
                                    <span class="nav-link-text" data-i18n="nav.asset">Training Request</span>
                                </a>
                            </li>

                            <li class="open">
                                <a href="#" title="training" data-filter-tags="training">
                                    <i class="fal fa-expand-arrows-alt"></i>
                                    <span class="nav-link-text" data-i18n="nav.training">Training Hour</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/hour-list" title="Detail" data-filter-tags="detail">
                                            <span class="nav-link-text" data-i18n="nav.detail"> Assign Hour</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/training-list" title="Report" data-filter-tags="report">
                                            <span class="nav-link-text" data-i18n="nav.report"> Training List</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/claim-list" title="Detail" data-filter-tags="detail">
                                            <span class="nav-link-text" data-i18n="nav.detail"> Approval Process</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/record-staff" title="Detail" data-filter-tags="detail">
                                            <span class="nav-link-text" data-i18n="nav.detail"> Training Record</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/bulk-claim-form" title="Detail" data-filter-tags="detail">
                                            <span class="nav-link-text" data-i18n="nav.detail"> Bulk Application
                                                Form</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="open">
                                <a href="#" title="Training" data-filter-tags="training">
                                    <i class="fal fa-bookmark"></i>
                                    <span class="nav-link-text" data-i18n="nav.training">Training Evaluation</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/evaluation-question" title="Training" data-filter-tags="training">
                                            <span class="nav-link-text" data-i18n="nav.training">Evaluation
                                                Question</span>
                                        </a>
                                        <a href="/evaluation-report" title="Training" data-filter-tags="training">
                                            <span class="nav-link-text" data-i18n="nav.training">Evaluation Report</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="open">
                                <a href="#" title="Training" data-filter-tags="training">
                                    <i class="fal fa-cogs"></i>
                                    <span class="nav-link-text" data-i18n="nav.training">Parameter Setting</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/type-list" title="Report" data-filter-tags="report">
                                            <span class="nav-link-text" data-i18n="nav.report"> Training Type</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/category-list" title="Report" data-filter-tags="report">
                                            <span class="nav-link-text" data-i18n="nav.report"> Training Category</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan

                        @can('view training menu')
                            <li class="nav-title">MYTRAINING</li>

                            <li class="open">
                                <a href="#" title="Claim" data-filter-tags="claim">
                                    <i class="fal fa-expand-arrows-alt"></i>
                                    <span class="nav-link-text" data-i18n="nav.claim">MyTraining</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/claim-form" title="App" data-filter-tags="app">
                                            <span class="nav-link-text" data-i18n="nav.app"> Application Form</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/claim-record" title="Record" data-filter-tags="record">
                                            <span class="nav-link-text" data-i18n="nav.record"> Training Record</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan
                        {{-- End Training --}}

                        {{-- Start Inventory --}}
                        @can('view inventory menu')
                            <li class="nav-title">INVENTORY MANAGEMENT</li>
                            @can('view inventory')
                                <li>
                                    <a href="/asset-dashboard" title="Application Intel"
                                        data-filter-tags="application intel">
                                        <i class="fal fa-chart-pie"></i>
                                        <span class="nav-link-text" data-i18n="nav.application_intel">Inventory
                                            Dashboard</span>
                                    </a>
                                </li>
                                <li class="open">
                                    <a href="#" title="Asset" data-filter-tags="asset">
                                        <i class="fal fa-barcode-read"></i>
                                        <span class="nav-link-text" data-i18n="nav.asset">Asset Management</span>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="/asset-index" title="Detail" data-filter-tags="detail">
                                                <span class="nav-link-text" data-i18n="nav.detail"> Asset Detail</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/asset-upload" title="Upload" data-filter-tags="upload">
                                                <span class="nav-link-text" data-i18n="nav.upload"> Bulk Upload</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/export_asset" title="Report" data-filter-tags="report">
                                                <span class="nav-link-text" data-i18n="nav.report"> Reporting</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="open">
                                    <a href="#" title="Stock" data-filter-tags="stock">
                                        <i class="fal fa-calendar-times"></i>
                                        <span class="nav-link-text" data-i18n="nav.stock">Stock Management</span>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="/stock-index" title="Detail" data-filter-tags="detail">
                                                <span class="nav-link-text" data-i18n="nav.detail"> Stock Detail</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="open">
                                    <a href="#" title="Borrow" data-filter-tags="borrow">
                                        <i class="fal fa-address-book"></i>
                                        <span class="nav-link-text" data-i18n="nav.borrow">Borrower Management</span>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="/borrow-index" title="Detail" data-filter-tags="detail">
                                                <span class="nav-link-text" data-i18n="nav.detail"> Borrower Detail</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/monitor-list" title="Monitoring" data-filter-tags="delay">
                                                <span class="nav-link-text" data-i18n="nav.delay"> Monitoring</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/export-borrow" title="Report" data-filter-tags="report">
                                                <span class="nav-link-text" data-i18n="nav.report"> Reporting</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="open">
                                    <a href="#" title="Parameter" data-filter-tags="parameter">
                                        <i class="fal fa-asterisk"></i>
                                        <span class="nav-link-text" data-i18n="nav.parameter">Parameter Settings</span>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="/asset-type" title="Asset" data-filter-tags="asset">
                                                <span class="nav-link-text" data-i18n="nav.asset">Asset Type</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/asset-class" title="Asset" data-filter-tags="asset">
                                                <span class="nav-link-text" data-i18n="nav.asset">Asset Class</span>
                                            </a>
                                        </li>
                                        @can('create custodian')
                                            <li>
                                                <a href="/asset-custodian" title="Manager" data-filter-tags="manager">
                                                    <span class="nav-link-text" data-i18n="nav.manager">Manager List</span>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcan
                            <li class="nav-title">MYASSET</li>
                            <li class="open">
                                <a href="#" title="List" data-filter-tags="list">
                                    <i class="fal fa-archive"></i>
                                    <span class="nav-link-text" data-i18n="nav.list">MyAsset</span>
                                </a>
                                <ul>
                                    {{-- <li>
                                        <a href="/verify-list" title="Pending" data-filter-tags="pending">
                                            <span class="nav-link-text" data-i18n="nav.pending">Pending
                                                Verification</span>
                                        </a>
                                    </li> --}}
                                    <li>
                                        <a href="/individual-list" title="MyAsset" data-filter-tags="myasset">
                                            <span class="nav-link-text" data-i18n="nav.myasset">MyAsset List</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan
                        <li class="nav-title">BOOKING</li>
                        @canany(['Manage Booking'])
                            <li class="open">
                                <a href="#" title="List" data-filter-tags="list">
                                    <i class="fal fa-book"></i>
                                    <span class="nav-link-text" data-i18n="nav.list">Booking Management</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/space/venue-management" title="Arkib" data-filter-tags="Arkib">
                                            <span class="nav-link-text" data-i18n="nav.arkib">Venue Management</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/space/item-management" title="Arkib" data-filter-tags="Arkib">
                                            <span class="nav-link-text" data-i18n="nav.arkib">Item Management</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/space/booking-management" title="Arkib" data-filter-tags="Arkib">
                                            <span class="nav-link-text" data-i18n="nav.arkib">Booking Management</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/space/booking-report" title="Arkib" data-filter-tags="Arkib">
                                            <span class="nav-link-text" data-i18n="nav.arkib">Report</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcanany
                        <li class="open">
                            <a href="#" title="List" data-filter-tags="list">
                                <i class="fal fa-book"></i>
                                <span class="nav-link-text" data-i18n="nav.list">Booking Application</span>
                            </a>
                            <ul>
                                <li>
                                    <a href="/space/booking/create" title="Arkib" data-filter-tags="Arkib">
                                        <span class="nav-link-text" data-i18n="nav.arkib">Application</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/space/booking" title="Arkib" data-filter-tags="Arkib">
                                        <span class="nav-link-text" data-i18n="nav.arkib">List of Application</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        </li>
                        @canany(['Manage Arkib', 'View Arkib'])
                            <li class="nav-title">LIBRARY</li>
                            <li class="open">
                                <a href="#" title="List" data-filter-tags="list">
                                    <i class="fal fa-book"></i>
                                    <span class="nav-link-text" data-i18n="nav.list">Arkib</span>
                                </a>
                                <ul>
                                    @canany(['Manage Arkib'])
                                        <li>
                                            <a href="/library/dashboard" title="Arkib" data-filter-tags="Arkib">
                                                <span class="nav-link-text" data-i18n="nav.arkib">Analysis Dashboard</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/library/arkib-main" title="Arkib" data-filter-tags="Arkib">
                                                <span class="nav-link-text" data-i18n="nav.arkib">Manage Arkib</span>
                                            </a>
                                        </li>
                                    @endcanany
                                    @canany(['Manage Arkib', 'View Arkib'])
                                        <li>
                                            <a href="/library/arkib" title="Arkib" data-filter-tags="Arkib">
                                                <span class="nav-link-text" data-i18n="nav.arkib">Arkib List</span>
                                            </a>
                                        </li>
                                    @endcanany
                                    @canany(['Manage Arkib'])
                                        <li>
                                            <a href="/library/report/arkib" title="Arkib" data-filter-tags="Arkib">
                                                <span class="nav-link-text" data-i18n="nav.arkib">Report</span>
                                            </a>
                                        </li>
                                    @endcanany
                                </ul>
                            </li>
                            </li>
                        @endcanany
                        {{-- End Inventory --}}

                        {{-- Start Computer Grant Management --}}
                        @role('Lecturer|Computer Grant (IT Admin)|Computer Grant (Finance Admin)|Super Admin')
                            <li class="nav-title">COMPUTER GRANT MANAGEMENT</li>

                            {{-- User --}}
                            @role('Lecturer|Super Admin')
                                <li>
                                    <a href="/grant-list" title="Grant" data-filter-tags="grant">
                                        <i class="fal fa-archive"></i>
                                        <span class="nav-link-text" data-i18n="nav.grant">Grant</span>
                                    </a>
                                </li>
                            @endrole

                            {{-- All --}}
                            <li>
                                <a href="/faq" title="Grant FAQ" data-filter-tags="faq">
                                    <i class="fal fa-info"></i>
                                    <span class="nav-link-text" data-i18n="nav.faq">FAQ</span>
                                </a>
                            </li>

                            {{-- IT Admin --}}
                            @role('Computer Grant (IT Admin)')
                                <li class="open">
                                    <a href="#" title="List" data-filter-tags="list">
                                        <i class="fal fa-list"></i>
                                        <span class="nav-link-text" data-i18n="nav.list">Grant List</span>
                                    </a>
                                    <ul>
                                        <li>
                                            @inject('grant', 'App\ComputerGrant')
                                            <a href="/all-grant-list/1" title="Pending" data-filter-tags="pending">
                                                <span class="nav-link-text" data-i18n="nav.pending">Pending
                                                    ({{ $grant->countPending() }})</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/all-grant-list/2" title="Approved for Purchase"
                                                data-filter-tags="approve">
                                                <span class="nav-link-text" data-i18n="nav.approve">Purchase Approved
                                                    ({{ $grant->countPurchase() }})</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/all-grant-list/3" title="Pending for Verification"
                                                data-filter-tags="verification">
                                                <span class="nav-link-text" data-i18n="nav.verification">Pending Purchase
                                                    Verification ({{ $grant->countPendingVerifyPurchase() }})</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/all-grant-list/4" title="Purchase Verified"
                                                data-filter-tags="verified">
                                                <span class="nav-link-text" data-i18n="nav.verified">Purchase Verified
                                                    ({{ $grant->countPurchaseVerified() }})</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/all-grant-list/6" title="Reimbursement Completed"
                                                data-filter-tags="reimbursement">
                                                <span class="nav-link-text" data-i18n="nav.reimbursement">Completed
                                                    ({{ $grant->countReimbursement() }})</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/all-grant-list/7" title="Request for Cancellation"
                                                data-filter-tags="cancel">
                                                <span class="nav-link-text" data-i18n="nav.cancel">Request Cancellation
                                                    ({{ $grant->countRequestCancel() }})</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/all-grant-list/8" title="Request for Cancellation Verified"
                                                data-filter-tags="cancelverified">
                                                <span class="nav-link-text" data-i18n="nav.cancelverified">Cancellation
                                                    Verified ({{ $grant->countCancelVerified() }})</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endrole

                            {{-- Finance Admin --}}
                            @role('Computer Grant (Finance Admin)')
                                <li class="open">
                                    <a href="#" title="Grant Claim" data-filter-tags="claim">
                                        <i class="fal fa-dollar-sign"></i>
                                        <span class="nav-link-text" data-i18n="nav.claim">Grant Claim</span>
                                    </a>
                                    <ul>
                                        <li>
                                            @inject('grant', 'App\ComputerGrant')
                                            <a href="/all-grant-list/4" title="Pending" data-filter-tags="signed">
                                                <span class="nav-link-text" data-i18n="nav.signed">Pending Reimbursement
                                                    ({{ $grant->countPurchaseVerified() }})</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/all-grant-list/6" title="Completed" data-filter-tags="completed">
                                                <span class="nav-link-text" data-i18n="nav.completed">Completed
                                                    ({{ $grant->countReimbursement() }})</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endrole

                            @role('Computer Grant (IT Admin)')
                                <li class="open">
                                    <a href="#" title="Grant" data-filter-tags="grant">
                                        <i class="fal fa-cogs"></i>
                                        <span class="nav-link-text" data-i18n="nav.grant">Setting</span>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="/quota-list" title="Grant Quota" data-filter-tags="quota">
                                                <span class="nav-link-text" data-i18n="nav.quota">Grant Quota</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/faq-list" title="FAQ Grant" data-filter-tags="createFAQ">
                                                <span class="nav-link-text" data-i18n="nav.createFAQ">Grant FAQ</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endrole
                            @role('Computer Grant (IT Admin)|Computer Grant (Finance Admin)')
                                <li>
                                    <a href="/report/all" title="Grant Report" data-filter-tags="report">
                                        <i class="fal fa-clipboard-list"></i>
                                        <span class="nav-link-text" data-i18n="nav.report">Report</span>
                                    </a>
                                </li>
                            @endrole
                        @endrole
                        {{-- End Computer Grant Management --}}

                        {{-- Start Covid --}}
                        @can('view admin')
                            <li class="nav-title">COVID19 MANAGEMENT</li>
                            <li class="open">
                                <a href="/covid-dashboard" title="Application Intel"
                                    data-filter-tags="application intel">
                                    <i class="fal fa-chart-pie"></i>
                                    <span class="nav-link-text" data-i18n="nav.application_intel">Covid19 Dashboard</span>
                                </a>
                            </li>
                            <li class="open">
                                <a href="/declarationList/{{ Auth::user()->id }}" title="Declaration"
                                    data-filter-tags="declaration">
                                    <i class="fal fa-calendar-times"></i>
                                    <span class="nav-link-text" data-i18n="nav.declaration">Today Declaration List</span>
                                </a>
                            </li>
                            <li class="open">
                                <a href="#" title="Category" data-filter-tags="category">
                                    <i class="fal fa-list"></i>
                                    <span class="nav-link-text" data-i18n="nav.category">Category</span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="/catA" title="catA" data-filter-tags="catA">
                                            <span class="nav-link-text" data-i18n="nav.catA"> Category A</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/catB" title="catB" data-filter-tags="catB">
                                            <span class="nav-link-text" data-i18n="nav.catB"> Category B</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/catC" title="catC" data-filter-tags="catC">
                                            <span class="nav-link-text" data-i18n="nav.catC"> Category C</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/catD" title="catD" data-filter-tags="catD">
                                            <span class="nav-link-text" data-i18n="nav.catD"> Category D</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/catE" title="catE" data-filter-tags="catE">
                                            <span class="nav-link-text" data-i18n="nav.catE"> Category E</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="open">
                                <a href="/historyForm/{{ Auth::user()->id }}" title="History"
                                    data-filter-tags="history">
                                    <i class="fal fa-clock"></i>
                                    <span class="nav-link-text" data-i18n="nav.history">History List</span>
                                </a>
                            </li>
                            <li class="open">
                                <a href="/declareNew" title="Declaration" data-filter-tags="declaration">
                                    <i class="fal fa-user"></i>
                                    <span class="nav-link-text" data-i18n="nav.declaration">Declaration Form</span>
                                </a>
                            </li>
                            <li class="open">
                                <a href="/export_covid" title="Report" data-filter-tags="report">
                                    <i class="fal fa-file-alt"></i>
                                    <span class="nav-link-text" data-i18n="nav.report">Report</span>
                                </a>
                            </li>
                            <li class="open">
                                <a href="/vaccineIndex" title="Vaccine" data-filter-tags="vaccine">
                                    <i class="fal fa-head-side-mask"></i>
                                    <span class="nav-link-text" data-i18n="nav.vaccine">Vaccination Details</span>
                                </a>
                            </li>
                        @endcan

                        @can('view user')
                            <li class="nav-title">Covid19 Daily Declaration</li>

                            <li class="open">
                                <a href="/declarationForm" title="Declaration" data-filter-tags="declaration">
                                    <i class="fal fa-calendar-times"></i>
                                    <span class="nav-link-text" data-i18n="nav.declaration">Today Declaration</span>
                                </a>
                            </li>
                            @role('Staff')
                                <li class="open">
                                    <a href="/vaccineForm" title="Vaccine" data-filter-tags="vaccine">
                                        <i class="fal fa-syringe"></i>
                                        <span class="nav-link-text" data-i18n="nav.vaccine">Vaccination</span>
                                    </a>
                                </li>
                                <li class="open">
                                    <a href="/dependentForm" title="Vaccine" data-filter-tags="vaccine">
                                        <i class="fal fa-pills"></i>
                                        <span class="nav-link-text" data-i18n="nav.vaccine">Dependent Vaccination</span>
                                    </a>
                                </li>
                            @endrole
                            <li class="open">
                                <a href="/selfHistory/{{ Auth::user()->id }}" title="History"
                                    data-filter-tags="history">
                                    <i class="fal fa-clock"></i>
                                    <span class="nav-link-text" data-i18n="nav.history">Declaration History</span>
                                </a>
                            </li>
                        @endcan
                        {{-- End Covid --}}
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
                        <a href="#"
                            class="page-logo-link press-scale-down d-flex align-items-center position-relative"
                            data-toggle="modal" data-target="#modal-shortcut">
                            <img src="{{ asset('img/logo.png') }}" alt="SmartAdmin WebApp"
                                aria-roledescription="logo">
                            <span class="page-logo-text mr-1"><b>INTEC</b> CMS</span>
                            <span
                                class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2">SeedProject</span>
                            <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
                        </a>
                    </div>
                    <!-- DOC: nav menu layout change shortcut -->
                    <div class="hidden-md-down dropdown-icon-menu position-relative">
                        <a href="#" class="header-btn btn js-waves-off" data-action="toggle"
                            data-class="nav-function-hidden" title="Hide Navigation">
                            <i class="ni ni-menu"></i>
                        </a>
                        <ul>
                            <li>
                                <a href="#" class="btn js-waves-off" data-action="toggle"
                                    data-class="nav-function-minify" title="Minify Navigation">
                                    <i class="ni ni-minify-nav"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="btn js-waves-off" data-action="toggle"
                                    data-class="nav-function-fixed" title="Lock Navigation">
                                    <i class="ni ni-lock-nav"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- DOC: mobile button appears during mobile width -->
                    <div class="hidden-lg-up">
                        <a href="#" class="header-btn btn press-scale-down" data-action="toggle"
                            data-class="mobile-nav-on">
                            <i class="ni ni-menu"></i>
                        </a>
                    </div>
                    <div class="ml-auto d-flex">

                        <!-- app user menu -->
                        <div>
                            <a href="#" data-toggle="dropdown" title="drlantern@gotbootstrap.com"
                                class="header-icon d-flex align-items-center justify-content-center ml-2">
                                <img style="cursor:pointer;" src="{{ asset('img/demo/avatars/avatar-m.png') }}"
                                    class="profile-image rounded-circle" alt="">
                                <!-- you can also add username next to the avatar with the codes below:
                                <span class="ml-1 mr-1 text-truncate text-truncate-header hidden-xs-down">Me</span>
                                <i class="ni ni-chevron-down hidden-xs-down"></i> -->
                            </a>
                            <div class="dropdown-menu dropdown-menu-animated dropdown-lg">
                                <div class="dropdown-header bg-trans-gradient d-flex flex-row py-4 rounded-top">
                                    <div class="d-flex flex-row align-items-center mt-1 mb-1 color-white">
                                        <span class="mr-2">
                                            <img src="{{ asset('img/demo/avatars/avatar-m.png') }}"
                                                class="rounded-circle profile-image" alt="Dr. Codex Lantern">
                                        </span>
                                        <div class="info-card-text">
                                            <div class="fs-lg text-truncate text-truncate-lg">
                                                {{ Auth::user()->name }}
                                            </div>
                                            <span
                                                class="text-truncate text-truncate-md opacity-80">{{ Auth::user()->email }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown-divider m-0"></div>
                                <a class="dropdown-item fw-500 pt-3 pb-3" href="/change-password">
                                    <span data-i18n="drpdwn.page-logout">Change Password</span>
                                </a>
                                <div class="dropdown-divider m-0"></div>
                                <a class="dropdown-item fw-500 pt-3 pb-3" href="">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <!--span data-i18n="drpdwn.page-logout">Logout</span-->
                                        <button type="submit" class="btn btn-danger btn-sm">Log Out</button>
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
                <router-view></router-view>

                <!-- this overlay is activated only when mobile menu is triggered -->
                <div class="page-content-overlay" data-action="toggle" data-class="mobile-nav-on"></div>
                <!-- END Page Content -->
                <!-- BEGIN Page Footer -->
                <footer class="page-footer" role="contentinfo">
                    <div class="d-flex align-items-center flex-1 text-muted">
                        <span class="hidden-md-down fw-700">{{ \Carbon\Carbon::now()->format('Y') }} </span>© INTEC
                        Education College
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





</body>
<script src="{{ asset('js/vendors.bundle.js') }}"></script>
<script src="{{ asset('js/app.bundle.js') }}"></script>
<script src="{{ asset('js/datagrid/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('js/notifications/sweetalert2/sweetalert2.bundle.js') }}"></script>
<script src="{{ asset('js/sweetalert.min.js') }} "></script>
<script src="{{ asset('js/statistics/chartjs/chartjs.bundle.js') }}"></script>
<script src="{{ asset('js/statistics/easypiechart/easypiechart.bundle.js') }}"></script>
<script src="{{ asset('js/formplugins/dropzone/dropzone.js') }}"></script>
{{-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script> --}}

{{-- <script src="{{asset('js/select2.min.js')}}"></script> --}}
<link rel="stylesheet" media="screen, print" href="{{ asset('css/formplugins/select2/select2.bundle.css') }}">
<script src="{{ asset('js/formplugins/select2/select2.bundle.js') }}"></script>

<script src="{{ asset('js/formplugins/summernote/summernote-bs4.js') }}"></script>
<script src="{{ asset('js/jquery.tabledit.min.js') }}"></script>
<script src="{{ asset('js/jquery.fancybox.js') }}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/29.1.0/classic/ckeditor.js"></script>
{{-- <script src="https://cdn.ckeditor.com/ckeditor5/29.1.0/decoupled-document/ckeditor.js"></script> --}}
<!-- DOC: script to save and load page settings -->

@yield('script')
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
    if (themeSettings.themeOptions) {
        classHolder.className = themeSettings.themeOptions;
        console.log("%c✔ Theme settings loaded", "color: #148f32");
    } else {
        console.log("Heads up! Theme settings is empty or does not exist, loading default settings...");
    }
    if (themeSettings.themeURL && !document.getElementById('mytheme')) {
        var cssfile = document.createElement('link');
        cssfile.id = 'mytheme';
        cssfile.rel = 'stylesheet';
        cssfile.href = themeURL;
        document.getElementsByTagName('head')[0].appendChild(cssfile);
    }
    /**
     * Save to localstorage
     **/
    var saveSettings = function() {
        themeSettings.themeOptions = String(classHolder.className).split(/[^\w-]+/).filter(function(item) {
            return /^(nav|header|mod|display)-/i.test(item);
        }).join(' ');
        if (document.getElementById('mytheme')) {
            themeSettings.themeURL = document.getElementById('mytheme').getAttribute("href");
        };
        localStorage.setItem('themeSettings', JSON.stringify(themeSettings));
    }
    /**
     * Reset settings
     **/
    var resetSettings = function() {
        localStorage.setItem("themeSettings", "");
    }
</script>
<script>
    // var CKEDITOR = require('@ckeditor/ckeditor5-build-[name]');
    // $('.collapsable-list li a').on('click', function() {
    //     $('.collapsable-list').find('a').next().collapse('hide');
    //     $(this).next().collapse('toggle');
    // });



    // DecoupledEditor
    //     .create(document.querySelector('.document-editor__editable'), {
    //         cloudServices: {
    //             ....
    //         }
    //     })
    //     .then(editor => {
    //         const toolbarContainer = document.querySelector('.document-editor__toolbar');

    //         toolbarContainer.appendChild(editor.ui.view.toolbar.element);

    //         window.editor = editor;
    //     })
    //     .catch(err => {
    //         console.error(err);
    //     });

    $(function() {
        $('li a').each(function(x, val) {
            var link = $(this).attr('href');
            var url = "{{ url()->current() }}";
            if (link && url.indexOf(link) !== -1) {
                $(this).addClass('highlight');
                $(this).parent().parent().attr('style', 'display:block');
                $(this).parent()
                    .addClass('open')
                    .find("a:first")
                    .attr('aria-expanded', true)
                    .find("b:first")
                    .delay(500)
                    .html(`<em class="fal fa-angle-up"></em>`);
            } else {
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
@yield('style')
<style>
    /* For CKEditor */

    .ck-editor__editable_inline {
        min-height: 250px;
    }

    .document-editor {
        border: 1px solid var(--ck-color-base-border);
        border-radius: var(--ck-border-radius);

        /* Set vertical boundaries for the document editor. */
        max-height: 700px;

        /* This element is a flex container for easier rendering. */
        display: flex;
        flex-flow: column nowrap;
    }

    .document-editor__toolbar {
        /* Make sure the toolbar container is always above the editable. */
        z-index: 1;

        /* Create the illusion of the toolbar floating over the editable. */
        box-shadow: 0 0 5px hsla(0, 0%, 0%, .2);

        /* Use the CKEditor CSS variables to keep the UI consistent. */
        border-bottom: 1px solid var(--ck-color-toolbar-border);
    }

    /* Adjust the look of the toolbar inside the container. */
    .document-editor__toolbar .ck-toolbar {
        border: 0;
        border-radius: 0;
    }

    /* Make the editable container look like the inside of a native word processor application. */
    .document-editor__editable-container {
        padding: calc(2 * var(--ck-spacing-large));
        background: var(--ck-color-base-foreground);

        /* Make it possible to scroll the "page" of the edited content. */
        overflow-y: scroll;
    }

    .document-editor__editable-container .ck-editor__editable {
        /* Set the dimensions of the "page". */
        width: 15.8cm;
        min-height: 21cm;

        /* Keep the "page" off the boundaries of the container. */
        padding: 1cm 2cm 2cm;

        border: 1px hsl(0, 0%, 82.7%) solid;
        border-radius: var(--ck-border-radius);
        background: white;

        /* The "page" should cast a slight shadow (3D illusion). */
        box-shadow: 0 0 5px hsla(0, 0%, 0%, .1);

        /* Center the "page". */
        margin: 0 auto;
    }

    /* Set the default font for the "page" of the content. */
    .document-editor .ck-content,
    .document-editor .ck-heading-dropdown .ck-list .ck-button__label {
        font: 16px/1.6 "Helvetica Neue", Helvetica, Arial, sans-serif;
    }

    /* Adjust the headings dropdown to host some larger heading styles. */
    .document-editor .ck-heading-dropdown .ck-list .ck-button__label {
        line-height: calc(1.7 * var(--ck-line-height-base) * var(--ck-font-size-base));
        min-width: 6em;
    }

    /* Scale down all heading previews because they are way too big to be presented in the UI.
Preserve the relative scale, though. */
    .document-editor .ck-heading-dropdown .ck-list .ck-button:not(.ck-heading_paragraph) .ck-button__label {
        transform: scale(0.8);
        transform-origin: left;
    }

    /* Set the styles for "Heading 1". */
    .document-editor .ck-content h2,
    .document-editor .ck-heading-dropdown .ck-heading_heading1 .ck-button__label {
        font-size: 2.18em;
        font-weight: normal;
    }

    .document-editor .ck-content h2 {
        line-height: 1.37em;
        padding-top: .342em;
        margin-bottom: .142em;
    }

    /* Set the styles for "Heading 2". */
    .document-editor .ck-content h3,
    .document-editor .ck-heading-dropdown .ck-heading_heading2 .ck-button__label {
        font-size: 1.75em;
        font-weight: normal;
        color: hsl(203, 100%, 50%);
    }

    .document-editor .ck-heading-dropdown .ck-heading_heading2.ck-on .ck-button__label {
        color: var(--ck-color-list-button-on-text);
    }

    /* Set the styles for "Heading 2". */
    .document-editor .ck-content h3 {
        line-height: 1.86em;
        padding-top: .171em;
        margin-bottom: .357em;
    }

    /* Set the styles for "Heading 3". */
    .document-editor .ck-content h4,
    .document-editor .ck-heading-dropdown .ck-heading_heading3 .ck-button__label {
        font-size: 1.31em;
        font-weight: bold;
    }

    .document-editor .ck-content h4 {
        line-height: 1.24em;
        padding-top: .286em;
        margin-bottom: .952em;
    }

    /* Set the styles for "Paragraph". */
    .document-editor .ck-content p {
        font-size: 1em;
        line-height: 1.63em;
        padding-top: .5em;
        margin-bottom: 1.13em;
    }

    /* Make the block quoted text serif with some additional spacing. */
    .document-editor .ck-content blockquote {
        font-family: Georgia, serif;
        margin-left: calc(2 * var(--ck-spacing-large));
        margin-right: calc(2 * var(--ck-spacing-large));
    }
</style>

</html>
