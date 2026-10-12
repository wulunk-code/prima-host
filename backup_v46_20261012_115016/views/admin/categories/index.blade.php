@extends('layouts.app')

@section('content')

<div class="container">

    <h3>📂 Data Kategori</h3>

    <a href="{{ route('categories.create') }}"
       class="btn btn-success mb-3">
        + Tambah Kategori
    </a>

    <table class="table table-bordered table-striped">

        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Kategori</th>
                <th>Slug</th>
                <th>Status</th>
                <th width="120">Aksi</th>
            </tr>
        </thead>

        <tbody>

        @forelse($categories as $category)

            <tr>

                <td>{{ $category->id }}</td>

                <td>{{ $category->name }}</td>

                <td>{{ $category->slug }}</td>

                <td>
                    @if($category->is_active)
                        <span class="badge bg-success">
                            Aktif
                        </span>
                    @else
                        <span class="badge bg-danger">
                            Nonaktif
                        </span>
                    @endif
                </td>

                <td>

                    <a href="{{ route('categories.delete',$category->id) }}"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Hapus kategori ini?')">
                        Hapus
                    </a>

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="5" class="text-center">
                    Belum ada kategori
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection