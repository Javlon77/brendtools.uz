<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="token" content="Bearer {{ auth()->user()->api_token }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    @yield('css')
    <link href="/css/main.css?v=1.0" rel="stylesheet">
    <title>@yield('title')</title>
</head>
<body>
<!-- navbar -->
<nav class="navbar navbar-expand navbar-dark">
  <div class="container">
   <div class="page-lists">
   <a class="navbar-brand" href="/">
    <img src="/images/logo_round.webp" alt="">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#"  role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Qo'shish +
          </a>
          <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-tr">
            <li><a class="dropdown-item" href="/client-base/create">+ Mijoz</a></li>
            <li><a class="dropdown-item" href="/funnel/create">+ Sotuv voronkasi</a></li>
            <li><a class="dropdown-item" href="/sales/create">+ Sotuv</a></li>
            <li><a class="dropdown-item" href="/products/create">+ Mahsulot</a></li>
            <li><a class="dropdown-item" href="/categories/create">+ Mahsulot kategoryasi</a></li>
            <li><a class="dropdown-item" href="/brands/create">+ Brend</a></li>
            <li><a class="dropdown-item" href="/masters-base/create">+ Usta</a></li>
            <li><a class="dropdown-item" href="/companies-base/create">+ Kompaniya</a></li>
            <li><a class="dropdown-item" href="/costs/create">+ Xarajat</a></li>
            <li><a class="dropdown-item" href="/cost-categories/create">+ Xarajat kategoryasi</a></li>
          </ul>
        </li>
      </ul>
    </div>

    <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#"  role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Sahifalar
          </a>
          <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-tr">
            <li><a class="dropdown-item" href="/client-base">Mijoz</a></li>
            <li><a class="dropdown-item" href="/funnel">Sotuv voronkasi</a></li>
            <li><a class="dropdown-item" href="/sales">Sotuv</a></li>
            <li><a class="dropdown-item" href="/products">Mahsulot</a></li>
            <li><a class="dropdown-item" href="/categories">Mahsulot Kategoryasi</a></li>
            <li><a class="dropdown-item" href="/brands">Brend</a></li>
            <li><a class="dropdown-item" href="/masters-base">Usta</a></li>
            <li><a class="dropdown-item" href="/companies-base">Kompaniya</a></li>
            <li><a class="dropdown-item" href="/costs">Xarajat</a></li>
            <li><a class="dropdown-item" href="/cost-categories">Xarajat kategoryasi</a></li>
          </ul>
        </li>
      </ul>
    </div>

    <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#"  role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Vazifa (<text class="number-seperato">{{ App\Models\Task::where('user_id', Auth::user() -> id) -> where('status', 0) -> count() ?? '' }}</text>)
          </a>
          <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-tr">
            <li><a class="dropdown-item" href="/tasks">Asosiy sahifa</a></li>
            <li><a class="dropdown-item" href="/tasks/profile">Mening profilim</a></li>
          </ul>
        </li>
      </ul>
    </div>
    
    <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#"  role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Kurs (<text class="number-seperator">{{ App\Models\Currency::latest()->first()->currency ?? '0' }}</text>)
          </a>
          <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-tr">
            <li><a class="dropdown-item" href="/currency">Kurs</a></li>
          </ul>
        </li>
      </ul>
    </div>

    <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#"  role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Tahlillar
          </a>
          <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-tr">
            <li><a class="dropdown-item" href="/analytics">Tahlillar</a></li>
            <li><a class="dropdown-item" href="/analytics/funnel">Sotuv voronkasi</a></li>
          </ul>
        </li>
      </ul>
    </div>

    <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#"  role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Moliya
          </a>
          <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-tr">
            <li><a class="dropdown-item" href="/finance">Moliya</a></li>
            <li><a class="dropdown-item" href="/finance/plan">Plan</a></li>
            <li><a class="dropdown-item" href="/finance/annual">Yillik</a></li>
          </ul>
        </li>
      </ul>
    </div>
  
  </div>

  

  <!-- Profile navbar -->
  
  <div class="collapse navbar-collapse custom-nav" id="navbarNavDarkDropdown">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#"  role="button" data-bs-toggle="dropdown" aria-expanded="false">
          {{Auth::user()->name}}
          </a>
          <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-tr">
            <li>
              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Chiqish
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
                </form>
              </a>
            </li>
          </ul>
        </li>
      </ul>
      <div id="MyClockDisplay" class="clock" onload="showTime()"></div>
    </div>
  
</nav>
<!-- end of navbar menu -->

<!-- header -->
  <div class="container">
  <h2 class="custom-header">@yield('header-text')</h2>
  </div>
<!-- end of header -->
@yield('content')
    <script src="/js/jQuery.min.js" type="text/javascript"></script>
    <script src="/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/js/main.js" type="text/javascript"></script>
    @yield('script')
</body>
</html>