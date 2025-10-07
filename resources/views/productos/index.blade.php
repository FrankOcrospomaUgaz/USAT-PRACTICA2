@extends('layouts.admin')
@section('title', 'Productos')
@section('page_title', 'Gestión de Productos')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header d-flex align-items-center justify-content-between flex-wrap">
            <div class="flex-grow-1">
                <form class="form-inline">
                    <input name="q" value="{{ $q }}" class="form-control form-control-sm mr-2"
                        placeholder="Buscar producto...">
                    <select id="filtro_familia" name="familia_id" class="form-control form-control-sm mr-2">
                        <option value="">Todas las familias</option>
                        @foreach($familias as $f)
                            <option value="{{ $f->id }}" @selected($familia_id == $f->id)>{{ $f->nombre }}</option>
                        @endforeach
                    </select>
                    <select id="filtro_categoria" name="categoria_id" class="form-control form-control-sm mr-2">
                        <option value="">Todas las categorías</option>
                        @foreach($categorias as $c)
                            <option value="{{ $c->id }}" @selected($categoria_id == $c->id)>{{ $c->nombre }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-sm btn-primary"><i class="fas fa-search"></i> Buscar</button>
                </form>
            </div>

            <div class="ml-auto">
                <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalCreate">
                    <i class="fas fa-plus"></i> Nuevo Producto
                </button>
            </div>
        </div>


        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Familia/Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th class="text-right" width="180">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($productos as $p)
                        <tr>
                            <td>{{ $p->id }}</td>
                            <td style="width:80px">
                                @if($p->imagen_perfil_url)
                                    <img src="{{ $p->imagen_perfil_url }}" class="img-thumbnail" style="max-height:60px">
                                @else
                                    <span class="text-muted">Sin imagen</span>
                                @endif
                            </td>
                            <td>{{ $p->nombre }}</td>
                            <td>{{ $p->familia->nombre }} / {{ $p->categoria->nombre }}</td>
                            <td>S/ {{ number_format($p->precio, 2) }}</td>
                            <td>{{ $p->stock }}</td>
                            <td class="text-right">
                                <button class="btn btn-sm btn-secondary" data-toggle="modal"
                                    data-target="#modalGallery{{ $p->id }}">
                                    <i class="fas fa-images"></i>
                                </button>
                                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalEdit{{ $p->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form class="d-inline form-eliminar" method="POST"
                                    action="{{ route('productos.destroy', $p) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i
                                            class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-3">No hay productos registrados</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white d-flex justify-content-end">
            {{ $productos->links('pagination::bootstrap-4') }}
        </div>
    </div>

    {{-- ===========================
    MODAL CREAR PRODUCTO
    =========================== --}}
    <div class="modal fade" id="modalCreate">
        <div class="modal-dialog modal-lg">
            <form class="modal-content" method="POST" action="{{ route('productos.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Nuevo Producto</h5>
                    <button class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Familia</label>
                            <select id="familiaCreate" name="familia_id" class="form-control form-control-sm" required>
                                <option value="">Seleccione...</option>
                                @foreach($familias as $f)
                                    <option value="{{ $f->id }}">{{ $f->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Categoría</label>
                            <select id="categoriaCreate" name="categoria_id" class="form-control form-control-sm"
                                required></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nombre del producto</label>
                        <input name="nombre" class="form-control form-control-sm" required>
                    </div>
                    <div class="form-group">
                        <label>Descripción</label>
                        <textarea name="descripcion" class="form-control form-control-sm" rows="2"></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Precio (S/)</label>
                            <input type="number" step="0.01" min="0" name="precio" class="form-control form-control-sm"
                                required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Stock</label>
                            <input type="number" min="0" name="stock" class="form-control form-control-sm" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Imagen de perfil</label>
                        <input type="file" name="imagen_perfil" class="form-control-file" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label>Galería de imágenes (múltiples)</label>
                        <input type="file" name="galeria[]" class="form-control-file" accept="image/*" multiple>
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
    MODALES EDITAR / GALERÍA
    =========================== --}}
    @foreach($productos as $p)
        {{-- Modal Editar --}}
        <div class="modal fade" id="modalEdit{{ $p->id }}">
            <div class="modal-dialog modal-lg">
                <form class="modal-content" method="POST" action="{{ route('productos.update', $p) }}"
                    enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title"><i class="fas fa-edit"></i> Editar Producto</h5>
                        <button class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Familia</label>
                                <select class="form-control form-control-sm familia-select" name="familia_id"
                                    data-target="#catEdit{{ $p->id }}" required>
                                    @foreach($familias as $f)
                                        <option value="{{ $f->id }}" @selected($p->familia_id == $f->id)>{{ $f->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Categoría</label>
                                <select id="catEdit{{ $p->id }}" name="categoria_id" class="form-control form-control-sm"
                                    required>
                                    <option value="{{ $p->categoria_id }}">{{ $p->categoria->nombre }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nombre</label>
                            <input name="nombre" value="{{ $p->nombre }}" class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group">
                            <label>Descripción</label>
                            <textarea name="descripcion" class="form-control form-control-sm"
                                rows="2">{{ $p->descripcion }}</textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Precio (S/)</label>
                                <input type="number" step="0.01" min="0" name="precio" value="{{ $p->precio }}"
                                    class="form-control form-control-sm" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Stock</label>
                                <input type="number" min="0" name="stock" value="{{ $p->stock }}"
                                    class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Imagen de perfil (opcional)</label>
                            <input type="file" name="imagen_perfil" class="form-control-file" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label>Agregar imágenes a galería</label>
                            <input type="file" name="galeria[]" class="form-control-file" accept="image/*" multiple>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button class="btn btn-info">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal Galería --}}
        <div class="modal fade" id="modalGallery{{ $p->id }}">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-secondary text-white">
                        <h5 class="modal-title"><i class="fas fa-images"></i> Galería de {{ $p->nombre }}</h5>
                        <button class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        {{-- Imagen principal --}}
                        @if($p->imagen_perfil_url)
                            <div class="text-center mb-4">
                                <img src="{{ $p->imagen_perfil_url }}" class="img-fluid rounded shadow-sm" style="max-height:250px">
                                <p class="mt-2 text-muted small mb-0">Imagen principal</p>
                            </div>
                            <hr>
                        @endif

                        {{-- Galería adicional --}}
                        <div class="row">
                            @forelse($p->images as $img)
                                <div class="col-md-3 text-center mb-3">
                                    <img src="{{ Storage::url($img->path) }}" class="img-fluid rounded mb-2 shadow-sm">
                                    <form class="form-eliminar" method="POST" action="{{ route('productos.image.delete', $img) }}">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            @empty
                                <div class="col-12 text-center text-muted py-3">
                                    No hay imágenes adicionales en la galería
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('scripts')
    {{-- SweetAlert2 CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function cargarCategorias(familiaId, $select) {
            $select.html('<option value="">Cargando...</option>');
            if (!familiaId) { $select.html('<option value="">-- Categoría --</option>'); return; }
            $.get('/ajax/categorias/by-familia/' + familiaId, function (list) {
                let html = '<option value="">-- Seleccione --</option>';
                list.forEach(function (c) { html += `<option value="${c.id}">${c.nombre}</option>`; });
                $select.html(html);
            });
        }

        // Dependientes dinámicos
        $('#filtro_familia').on('change', function () { cargarCategorias($(this).val(), $('#filtro_categoria')); });
        $('#familiaCreate').on('change', function () { cargarCategorias($(this).val(), $('#categoriaCreate')); });
        $('.familia-select').on('change', function () { cargarCategorias($(this).val(), $($(this).data('target'))); });

        // Confirmación SweetAlert2 para eliminar producto o imagen
        $(document).on('submit', '.form-eliminar', function (e) {
            e.preventDefault();
            const form = this;
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });

        // Mostrar notificaciones SweetAlert2 desde Laravel (flash)
        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Éxito', text: '{{ session('success') }}', timer: 2500, showConfirmButton: false });
        @endif

        @if(session('danger'))
            Swal.fire({ icon: 'error', title: 'Error', text: '{{ session('danger') }}', timer: 2500, showConfirmButton: false });
        @endif
    </script>

    <style>
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }

        .modal-content {
            border-radius: 8px;
        }

        .modal-header h5 {
            font-weight: 600;
        }

        .btn-sm i {
            margin-right: 3px;
        }

        .card {
            border-radius: 10px;
        }

        .card-header {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
    </style>
@endpush