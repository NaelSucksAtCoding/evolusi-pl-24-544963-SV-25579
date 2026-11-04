@extends('layouts.app')

@section('title', 'Edit Item')

@section('content')
    <div class="card">
        <form action="{{ route('items.update', $item) }}" method="POST">
            @csrf
            @method('PUT')
            <label for="name">Nama</label>
            <input type="text" id="name" name="name" value="{{ old('name', $item->name) }}" required>

            <label for="description">Deskripsi</label>
            <textarea id="description" name="description" rows="2">{{ old('description', $item->description) }}</textarea>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('items.index') }}" class="btn btn-muted">Batal</a>
        </form>
    </div>
@endsection
