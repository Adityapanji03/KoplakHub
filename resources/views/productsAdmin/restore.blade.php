@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <div class="max-w-md mx-auto bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-semibold mb-6">Pulihkan Produk</h1>
        <p class="text-gray-700 mb-4">Apakah Anda yakin ingin memulihkan produk <strong>{{ $product->name }}</strong>?</p>
        <form action="{{ route('productsAdmin.restore', $product->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="flex justify-end">
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-2">
                    Pulihkan
                </button>
                <a href="{{ route('productsAdmin.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
