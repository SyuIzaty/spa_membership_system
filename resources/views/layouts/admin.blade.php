<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Raudhah Serenity') }}</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="Page Title">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="msapplication-tap-highlight" content="no">

        @yield('css')
        <link rel="stylesheet" media="screen, print" href="{{ asset('admin/css/vendors.bundle.css') }}">
        <link rel="stylesheet" media="screen, print" href="{{ asset('admin/css/app.bundle.css') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('admin/img/favicon/apple-touch-icon.jpg') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('admin/img/favicon/favicon-32x32.jpg') }}">
        <link rel="stylesheet" href="{{ asset('admin/css/statistics/chartjs/chartjs.css.map') }}">
        <link rel="stylesheet" href="{{ asset('admin/css/statistics/chartjs/chartjs.css') }}">
        <link rel="mask-icon" href="{{ asset('admin/img/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
        <link rel="stylesheet" media="screen, print" href="{{ asset('admin/css/datagrid/datatables/datatables.bundle.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/css/notifications/sweetalert2/sweetalert2.bundle.css') }}">
        <link rel="stylesheet" media="screen, print" href="{{ asset('admin/css/formplugins/dropzone/dropzone.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/css/formplugins/summernote/summernote-bs4.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/css/indicator.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/css/jquery.fancybox.css') }}" />
        <style>
            .highlight {
                font-weight: bolder;
            }
        </style>
    </head>

    <body class="mod-bg-1 mod-nav-link">
        <div class="page-wrapper">
            <div class="page-inner">
                <aside class="page-sidebar">
                    <div class="page-logo">
                        <a href="#"
                            class="page-logo-link press-scale-down d-flex align-items-center position-relative"
                            data-toggle="modal" data-target="#modal-shortcut">

                            <span class="mr-1 page-logo-text"><b><i class="fal fa-burn"></i> Raudhah Serenity</b></span>
                            <i class="ml-1 fal fa-angle-down d-inline-block fs-lg color-primary-300"></i>
                        </a>
                    </div>
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
                            <img src="{{ asset('admin/img/demo/avatars/avatar-m.png') }}" class="profile-image rounded-circle"
                                alt="Dr. Codex Lantern">
                            <div class="info-card-text">
                                <a href="#" class="text-white d-flex align-items-center">
                                    <span class="text-truncate text-truncate-sm d-inline-block">
                                        {{ \App\Staff::where('user_id', Auth::user()->id)->first()->staff_name }}
                                    </span>
                                </a>
                                <span class="d-inline-block text-truncate text-truncate-sm">{{ \App\Staff::where('user_id', Auth::user()->id)->first()->staff_email }}</span>
                            </div>
                            <img src="{{ asset('admin/img/main_bg.jpg') }}" class="cover" alt="cover" style="width: 100%">
                            <a href="#" onclick="return false;" class="pull-trigger-btn" data-action="toggle"
                                data-class="list-filter-active" data-target=".page-sidebar" data-focus="nav_filter_input">
                                <i class="fal fa-angle-down"></i>
                            </a>
                        </div>
                        <ul id="js-nav-menu" class="nav-menu">
                            <li class="nav-title">Booking Operations</li>
                            <li>
                                <a href="/list-booking" title="Booking Management" data-filter-tags="booking management">
                                    <i class="fal fa-calendar-alt"></i>
                                    <span class="nav-link-text" data-i18n="nav.booking_management">Booking Management</span>
                                </a>
                            </li>

                            <li class="nav-title">Customer Management</li>
                            <li>
                                <a href="/list-member" title="Members Management" data-filter-tags="members management">
                                    <i class="fal fa-user"></i>
                                    <span class="nav-link-text" data-i18n="nav.members_management">Customer Management</span>
                                </a>
                            </li>

                            <li class="nav-title">Services & Plans</li>
                            <li>
                                <a href="/list-service" title="Service Management" data-filter-tags="service management">
                                    <i class="fal fa-burn"></i>
                                    <span class="nav-link-text" data-i18n="nav.service_management">Service Management</span>
                                </a>
                            </li>
                            <li>
                                <a href="/list-discount" title="Discount Management" data-filter-tags="discount management">
                                    <i class="fal fa-tags"></i>
                                    <span class="nav-link-text" data-i18n="nav.discount_management">Discount Management</span>
                                </a>
                            </li>
                            <li>
                                <a href="/list-membership" title="Membership Plan" data-filter-tags="membership plan">
                                    <i class="fal fa-id-card"></i>
                                    <span class="nav-link-text" data-i18n="nav.membership_plan">Membership Plan </span>
                                </a>
                            </li>

                            <li class="nav-title">Staff Administration</li>
                            <li>
                                <a href="/list-staff" title="Staff Management" data-filter-tags="service management">
                                    <i class="fal fa-users"></i>
                                    <span class="nav-link-text" data-i18n="nav.service_management">Staff Management</span>
                                </a>
                            </li>
                        </ul>
                        <div class="filter-message js-filter-message bg-success-600"></div>
                    </nav>
                </aside>
                <div class="page-content-wrapper">
                    <header class="page-header" role="banner">
                        <div class="page-logo">
                            <a href="#"
                                class="page-logo-link press-scale-down d-flex align-items-center position-relative"
                                data-toggle="modal" data-target="#modal-shortcut">
                                <img src="{{ asset('admin/img/logo.png') }}" alt="WebApp"
                                    aria-roledescription="logo">
                                <span class="mr-1 page-logo-text"><b>Raudhah Serenity Spa</b> Management System</span>
                                <span
                                    class="mr-2 text-white opacity-50 position-absolute small pos-top pos-right mt-n2">SeedProject</span>
                                <i class="ml-1 fal fa-angle-down d-inline-block fs-lg color-primary-300"></i>
                            </a>
                        </div>
                        <div class="hidden-lg-up">
                            <a href="#" class="header-btn btn press-scale-down" data-action="toggle"
                                data-class="mobile-nav-on">
                                <i class="ni ni-menu"></i>
                            </a>
                        </div>
                        <div class="ml-auto d-flex">
                            <div>
                                <a href="#" data-toggle="dropdown" title="drlantern@gotbootstrap.com"
                                    class="ml-2 header-icon d-flex align-items-center justify-content-center">
                                    <img style="cursor:pointer;" src="{{ asset('admin/img/demo/avatars/avatar-m.png') }}"
                                        class="profile-image rounded-circle" alt="">
                                </a>
                                <div class="dropdown-menu dropdown-menu-animated dropdown-lg">
                                    <div class="flex-row py-4 dropdown-header bg-trans-gradient d-flex rounded-top">
                                        <div class="flex-row mt-1 mb-1 d-flex align-items-center color-white">
                                            <span class="mr-2">
                                                <img src="{{ asset('admin/img/demo/avatars/avatar-m.png') }}"
                                                    class="rounded-circle profile-image" alt="Dr. Codex Lantern">
                                            </span>
                                            <div class="info-card-text">
                                                <div class="fs-lg text-truncate text-truncate-lg">
                                                    {{ \App\Staff::where('user_id', Auth::user()->id)->first()->staff_name }}
                                                </div>
                                                <span
                                                    class="text-truncate text-truncate-md opacity-80">{{ \App\Staff::where('user_id', Auth::user()->id)->first()->staff_email }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-0 dropdown-divider"></div>
                                    <a class="pt-3 pb-3 dropdown-item fw-500" href="">
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">Log Out</button>
                                        </form>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </header>

                    @yield('content')
                    <router-view></router-view>

                    <div class="page-content-overlay" data-action="toggle" data-class="mobile-nav-on"></div>
                    <footer class="page-footer" role="contentinfo">
                        <div class="flex-1 d-flex align-items-center text-muted">
                            <span class="hidden-md-down fw-700">{{ \Carbon\Carbon::now()->format('Y') }} </span>© Raudhah Serenity Spa
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </body>

    <link rel="stylesheet" media="screen, print" href="{{ asset('admin/css/formplugins/select2/select2.bundle.css') }}">
    <script src="{{ asset('admin/js/vendors.bundle.js') }}"></script>
    <script src="{{ asset('admin/js/app.bundle.js') }}"></script>
    <script src="{{ asset('admin/js/datagrid/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('admin/js/notifications/sweetalert2/sweetalert2.bundle.js') }}"></script>
    <script src="{{ asset('admin/js/sweetalert.min.js') }} "></script>
    <script src="{{ asset('admin/js/statistics/chartjs/chartjs.bundle.js') }}"></script>
    <script src="{{ asset('admin/js/statistics/easypiechart/easypiechart.bundle.js') }}"></script>
    <script src="{{ asset('admin/js/formplugins/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset('admin/js/formplugins/select2/select2.bundle.js') }}"></script>
    <script src="{{ asset('admin/js/formplugins/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('admin/js/jquery.tabledit.min.js') }}"></script>
    <script src="{{ asset('admin/js/jquery.fancybox.js') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/29.1.0/classic/ckeditor.js"></script>

    @yield('script')
    <script>
        'use strict';
        var classHolder = document.getElementsByTagName("BODY")[0],
            themeSettings = (localStorage.getItem('themeSettings')) ? JSON.parse(localStorage.getItem('themeSettings')) :
            {},
            themeURL = themeSettings.themeURL || '',
            themeOptions = themeSettings.themeOptions || '';
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
        var saveSettings = function() {
            themeSettings.themeOptions = String(classHolder.className).split(/[^\w-]+/).filter(function(item) {
                return /^(nav|header|mod|display)-/i.test(item);
            }).join(' ');
            if (document.getElementById('mytheme')) {
                themeSettings.themeURL = document.getElementById('mytheme').getAttribute("href");
            };
            localStorage.setItem('themeSettings', JSON.stringify(themeSettings));
        }
        var resetSettings = function() {
            localStorage.setItem("themeSettings", "");
        }
    </script>
    <script>
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
        .ck-editor__editable_inline {
            min-height: 250px;
        }
        .document-editor {
            border: 1px solid var(--ck-color-base-border);
            border-radius: var(--ck-border-radius);
            max-height: 700px;
            display: flex;
            flex-flow: column nowrap;
        }

        .document-editor__toolbar {
            z-index: 1;
            box-shadow: 0 0 5px hsla(0, 0%, 0%, .2);
            border-bottom: 1px solid var(--ck-color-toolbar-border);
        }

        .document-editor__toolbar .ck-toolbar {
            border: 0;
            border-radius: 0;
        }

        .document-editor__editable-container {
            padding: calc(2 * var(--ck-spacing-large));
            background: var(--ck-color-base-foreground);
            overflow-y: scroll;
        }

        .document-editor__editable-container .ck-editor__editable {
            width: 15.8cm;
            min-height: 21cm;
            padding: 1cm 2cm 2cm;
            border: 1px hsl(0, 0%, 82.7%) solid;
            border-radius: var(--ck-border-radius);
            background: white;
            box-shadow: 0 0 5px hsla(0, 0%, 0%, .1);
            margin: 0 auto;
        }

        .document-editor .ck-content,
        .document-editor .ck-heading-dropdown .ck-list .ck-button__label {
            font: 16px/1.6 "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

        .document-editor .ck-heading-dropdown .ck-list .ck-button__label {
            line-height: calc(1.7 * var(--ck-line-height-base) * var(--ck-font-size-base));
            min-width: 6em;
        }

        .document-editor .ck-heading-dropdown .ck-list .ck-button:not(.ck-heading_paragraph) .ck-button__label {
            transform: scale(0.8);
            transform-origin: left;
        }

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

        .document-editor .ck-content h3,
        .document-editor .ck-heading-dropdown .ck-heading_heading2 .ck-button__label {
            font-size: 1.75em;
            font-weight: normal;
            color: hsl(203, 100%, 50%);
        }

        .document-editor .ck-heading-dropdown .ck-heading_heading2.ck-on .ck-button__label {
            color: var(--ck-color-list-button-on-text);
        }

        .document-editor .ck-content h3 {
            line-height: 1.86em;
            padding-top: .171em;
            margin-bottom: .357em;
        }

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

        .document-editor .ck-content p {
            font-size: 1em;
            line-height: 1.63em;
            padding-top: .5em;
            margin-bottom: 1.13em;
        }

        .document-editor .ck-content blockquote {
            font-family: Georgia, serif;
            margin-left: calc(2 * var(--ck-spacing-large));
            margin-right: calc(2 * var(--ck-spacing-large));
        }
    </style>
</html>
