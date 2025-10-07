@extends('layouts.admin')
@section('title', 'Familias')
@section('page_title', 'Familias')

@section('content')
    <div class="card">
        <div class="card-header">
            <form class="form-inline">
                <input name="q" value="{{ $q }}" class="form-control form-control-sm mr-2" placeholder="Buscar">
                <button class="btn btn-sm btn-primary">Filtrar</button>
            </form>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($familias as $f)
                        <tr>
                            <td>{{ $f->id }}</td>
                            <td>{{ $f->nombre }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">{{ $familias->links() }}</div>
    </div>
@endsection