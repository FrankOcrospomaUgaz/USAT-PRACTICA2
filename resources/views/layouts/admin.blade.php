<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>@yield('title','Panel')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  {{-- AdminLTE + Bootstrap 4 + FontAwesome (CDN) --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">

  @livewireStyles
  @stack('styles')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  {{-- Navbar superior --}}
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="btn btn-sm btn-outline-danger">Salir</button>
        </form>
      </li>
    </ul>
  </nav>

  {{-- Sidebar --}}
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('dashboard') }}" class="brand-link">
      <span class="brand-text font-weight-light">USAT – Práctica 02</span>
    </a>

    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-accordion="false">
          <li class="nav-item">
            <a href="{{ route('familias.index') }}" class="nav-link {{ request()->routeIs('familias.*')?'active':'' }}">
              <i class="nav-icon fas fa-stream"></i>
              <p>Familias</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('categorias.index') }}" class="nav-link {{ request()->routeIs('categorias.*')?'active':'' }}">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>Categorías</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('productos.index') }}" class="nav-link {{ request()->routeIs('productos.*')?'active':'' }}">
              <i class="nav-icon fas fa-boxes"></i>
              <p>Productos</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  {{-- Content --}}
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <h1>@yield('page_title','Panel')</h1>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        

        @yield('content')
      </div>
    </section>
  </div>

  <footer class="main-footer small text-muted">
    <strong>Práctica 02</strong>
  </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.7/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

@livewireScripts
@stack('scripts')
</body>
</html>
