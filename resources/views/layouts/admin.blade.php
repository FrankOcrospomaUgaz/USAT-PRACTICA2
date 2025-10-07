<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Panel de Administración') – USAT</title>

  {{-- === Estilos base: AdminLTE + Bootstrap + FontAwesome === --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">

  {{-- === Estilos personalizados globales === --}}
  <style>
    /* Mejor tipografía y espaciado */
    body {
      font-family: 'Source Sans Pro', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
      font-size: 0.9rem;
      background-color: #f4f6f9;
    }

    .brand-link {
      font-weight: 600;
      font-size: 1rem;
      text-align: center;
      background: #343a40;
    }

    .brand-text {
      color: #f8f9fa !important;
    }

    .nav-sidebar .nav-link.active {
      background-color: #007bff !important;
      color: #fff !important;
    }

    .nav-sidebar .nav-link:hover {
      background-color: rgba(0, 123, 255, 0.2);
      color: #007bff;
    }

    .content-header h1 {
      font-weight: 600;
      font-size: 1.3rem;
      color: #343a40;
    }

    footer.main-footer {
      background: #f8f9fa;
      border-top: 1px solid #dee2e6;
      color: #6c757d;
      font-size: 0.85rem;
      text-align: center;
      padding: 10px 0;
    }

    .navbar-white {
      border-bottom: 1px solid #dee2e6;
    }

    .user-name {
      font-weight: 600;
      color: #343a40;
    }
  </style>

  @livewireStyles
  @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    {{-- ===========================================
    NAVBAR SUPERIOR
    ============================================ --}}
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      {{-- Botón colapsar menú lateral --}}
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button">
            <i class="fas fa-bars"></i>
          </a>
        </li>
      </ul>

      {{-- Lado derecho del navbar --}}
      <ul class="navbar-nav ml-auto align-items-center">
        {{-- Usuario autenticado --}}
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#" role="button">
            <i class="fas fa-user-circle mr-1"></i>
            <span class="user-name">{{ Auth::user()->name ?? 'Usuario' }}</span>
            <i class="fas fa-angle-down ml-1"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right shadow-sm">
            <a href="#" class="dropdown-item text-muted disabled">
              <i class="fas fa-envelope mr-2"></i> {{ Auth::user()->email ?? '' }}
            </a>
            <div class="dropdown-divider"></div>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
              @csrf
              <button type="submit" class="dropdown-item text-danger">
                <i class="fas fa-sign-out-alt mr-2"></i> Cerrar sesión
              </button>
            </form>
          </div>
        </li>
      </ul>
    </nav>

    {{-- ===========================================
    SIDEBAR IZQUIERDO
    ============================================ --}}
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      {{-- Logo y título --}}
      <a href="{{ route('dashboard') }}" class="brand-link">
        <span class="brand-text font-weight-light">USAT – Práctica 02</span>
      </a>

      {{-- Menú lateral --}}
      <div class="sidebar">
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
            <li class="nav-header text-uppercase text-muted small mb-2">Gestión de Datos</li>

            <li class="nav-item">
              <a href="{{ route('familias.index') }}"
                class="nav-link {{ request()->routeIs('familias.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-stream"></i>
                <p>Familias</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('categorias.index') }}"
                class="nav-link {{ request()->routeIs('categorias.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-layer-group"></i>
                <p>Categorías</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('productos.index') }}"
                class="nav-link {{ request()->routeIs('productos.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-boxes"></i>
                <p>Productos</p>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </aside>

    {{-- ===========================================
    CONTENIDO PRINCIPAL
    ============================================ --}}
    <div class="content-wrapper">
      <section class="content-header">
        <div class="container-fluid">
          <h1>@yield('page_title', 'Panel de Control')</h1>
        </div>
      </section>

      <section class="content">
        <div class="container-fluid">
          {{-- Contenido dinámico --}}
          @yield('content')
        </div>
      </section>
    </div>

    {{-- ===========================================
    PIE DE PÁGINA
    ============================================ --}}
    <footer class="main-footer small text-muted">
      <strong>© {{ date('Y') }} Universidad Católica Santo Toribio de Mogrovejo</strong>
      <span class="d-none d-sm-inline"> | Proyecto Práctica 02 – Laravel</span>
    </footer>
  </div>

  {{-- ===========================================
  SCRIPTS BASE
  =========================================== --}}
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

  @livewireScripts
  @stack('scripts')
</body>

</html>