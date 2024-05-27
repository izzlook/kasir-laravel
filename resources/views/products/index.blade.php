@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Menu</h1>
    <table class="table table-bordered table-striped table-hover table-sm">
        <thead>
            <tr>
                <th class="text-center">Nama Menu</th>
                <th class="text-center">Harga</th>
                <th class="text-center">Gambar</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>Rp. {{ $product->price }}</td>
                <td class="text-center">
                    <img src="{{ asset('img/' . $product->image) }}" alt="{{ $product->name }}" class="img-thumbnail product-image" style="max-width: 100px; max-height: 100px;">
                </td>
                <td class="text-center">
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah yakin ingin menghapus menu?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
