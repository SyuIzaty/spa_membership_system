<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>@yield('title') - Applicant Info</title>
    <link
      rel="stylesheet"
      href="{{asset('css/bulma.min.css')}}"
    />
  </head>

  <body>
    <nav class="navbar" role="navigation" aria-label="main navigation">
      <div class="navbar-brand">
        <a href="{{route('applicant.profile',$applicant)}}" class="navbar-item">
          <img src="{{ asset('img/inteclogo.png') }}" width="80" height="400" />
        </a>
        <a
          role="button"
          class="navbar-burger"
          aria-label="menu"
          aria-expanded="false"
          data-target="navMenu"
        >
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
        </a>
      </div>
      <div id="navMenu" class="navbar-menu">
        <div class="navbar-start">
          <a href="{{route('applicant.profile',$applicant)}}" class="navbar-item">
            Personal Profile
          </a>

          <a href="{{route('applicant.prefprogramme',$applicant)}}" class="navbar-item">
            Preferred Program
          </a>
          <a href="{{route('applicant.createcontact',$applicant)}}" class="navbar-item">
            Contact Information
          </a>
          <a href="" class="navbar-item">
            Academic Qualification
          </a>
          <a href="" class="navbar-item">
            Preview
          </a>
        </div>
        <div class="navbar-end">
          <div class="navbar-item">
            <div class="buttons">
              <a href="{{ route('applicant.create') }}" class="button is-info">
                <strong>New Applicant</strong>
              </a>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <section class="section">
      <div class="container">
        <div class="columns is-centered">
          <div class="column is-8">
            @if (session('notification'))
            <div class="notification is-primary">
              {{ session('notification') }}
            </div>
            @endif @yield('content')
          </div>
        </div>
      </div>
    </section>

    <footer class="footer">
      <div class="content has-text-centered">
        <p>
          <strong>INTEC Application</strong> 
          <!-- <a href="">Steven Cotterill</a> -->
        </p>
      </div>
    </footer>

    <script src="{{ asset('js/nav.js') }}"></script>
  </body>
</html>