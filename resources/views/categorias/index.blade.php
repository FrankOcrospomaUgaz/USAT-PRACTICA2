@extends('layouts.admin')
@section('title','Categorías')
@section('page_title','Gestión de Categorías')

@section('content')
<div class="card shadow-sm">
  <div class="card-header d-flex justify-content-between align-items-center">
    {{-- Formulario de búsqueda --}}
    <form class="form-inline flex-grow-1">
      <input name="q" value="{{ $q }}" class="form-control form-control-sm mr-2" placeholder="Buscar categoría...">
      <select name="familia_id" class="form-control form-control-sm mr-2">
        <option value="">Todas las familias</option>
        @foreach($familias as $f)
          <option value="{{ $f->id }}" @selected($familia_id==$f->id)>{{ $f->nombre }}</option>
        @endforeach
      </select>
      <button class="btn btn-sm btn-primary"><i class="fas fa-search"></i> Buscar</button>
    </form>

    {{-- Botón Nueva Categoría --}}
    <button class="btn btn-sm btn-success ml-2" data-toggle="modal" data-target="#modalCreate">
      <i class="fas fa-plus"></i> Nueva Categoría
    </button>
  </div>

  <div class="card-body p-0">
    <table class="table table-hover mb-0 align-middle">
      <thead class="bg-light">
        <tr>
          <th style="width:60px;">ID</th>
          <th>Familia</th>
          <th>Nombre</th>
          <th style="width:160px;" class="text-right">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($categorias as $c)
          <tr>
            <td>{{ $c->id }}</td>
            <td>{{ $c->familia->nombre }}</td>
            <td>{{ $c->nombre }}</td>
            <td class="text-right">
              <button class="btn btn-sm btn-info mr-1" data-toggle="modal" data-target="#editModal{{ $c->id }}">
                <i class="fas fa-edit"></i>
              </button>
              <form class="d-inline form-eliminar" method="POST" action="{{ route('categorias.destroy',$c) }}">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">
                  <i class="fas fa-trash-alt"></i>
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="4" class="text-center text-muted py-3">No se encontraron resultados</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="card-footer bg-white d-flex justify-content-end">
   {{ $categorias->links('pagination::bootstrap-4') }}

  </div>
</div>

{{-- ===========================
  MODAL CREAR
=========================== --}}
<div class="modal fade" id="modalCreate">
  <div class="modal-dialog modal-md">
    <form class="modal-content" method="POST" action="{{ route('categorias.store') }}">
      @csrf
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Nueva Categoría</h5>
        <button class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="form-group mb-3">
          <label>Familia</label>
          <select name="familia_id" class="form-control form-control-sm" required>
            <option value="">Seleccione</option>
            @foreach($familias as $f)
              <option value="{{ $f->id }}">{{ $f->nombre }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group mb-3">
          <label>Nombre de categoría</label>
          <input name="nombre" class="form-control form-control-sm" required>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button class="btn btn-success">Guardar</button>
      </div>
    </form>
  </div>
</div>

{{-- ===========================
  MODALES EDITAR
=========================== --}}
@foreach($categorias as $c)
<div class="modal fade" id="editModal{{ $c->id }}">
  <div class="modal-dialog modal-md">
    <form class="modal-content" method="POST" action="{{ route('categorias.update',$c) }}">
      @csrf @method('PUT')
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title"><i class="fas fa-edit"></i> Editar Categoría</h5>
        <button class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="form-group mb-3">
          <label>Familia</label>
          <select name="familia_id" class="form-control form-control-sm" required>
            @foreach($familias as $f)
              <option value="{{ $f->id }}" @selected($c->familia_id==$f->id)>{{ $f->nombre }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group mb-3">
          <label>Nombre de categoría</label>
          <input name="nombre" value="{{ $c->nombre }}" class="form-control form-control-sm" required>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button class="btn btn-info">Actualizar</button>
      </div>
    </form>
  </div>
</div>
@endforeach
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Confirmación con SweetAlert2 al eliminar
$(document).on('submit', '.form-eliminar', function(e) {
  e.preventDefault();
  const form = this;

  Swal.fire({
    title: '¿Estás seguro?',
    text: 'La categoría será eliminada permanentemente.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      // Enviar el formulario solo si el usuario confirma
      form.submit();
    }
  });
});

// Mostrar mensajes SweetAlert2 desde Laravel (flash)
@if(session('success'))
  Swal.fire({
    icon: 'success',
    title: 'Éxito',
    text: '{{ session('success') }}',
    showConfirmButton: false,
    timer: 2500
  });
@endif

@if(session('danger'))
  Swal.fire({
    icon: 'error',
    title: 'No se puede eliminar',
    text: '{{ session('danger') }}',
    showConfirmButton: true,
    confirmButtonText: 'Entendido'
  });
@endif
</script>



<style>
.table-hover tbody tr:hover { background-color: #f8f9fa; }
.modal-content { border-radius: 8px; }
.modal-header h5 { font-weight: 600; }
.btn-sm i { margin-right: 3px; }
.card { border-radius: 10px; }
.card-header {
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.btn-info, .btn-success, .btn-danger { min-width: 36px; }
</style>
@endpush
