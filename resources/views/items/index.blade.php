@extends('layouts.app')

@section('content')
    <div class="card">
        <form action="{{ route('items.store') }}" method="POST">
            @csrf
            <label for="name">Nama</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>

            <label for="description">Deskripsi</label>
            <textarea id="description" name="description" rows="2">{{ old('description') }}</textarea>

            <button type="submit" class="btn btn-primary">Tambah</button>
        </form>
    </div>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->description }}</td>
                        <td class="actions">
                            <a href="{{ route('items.edit', $item) }}" class="btn btn-edit">Edit</a>
                            <form action="{{ route('items.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus item ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="empty">Belum ada item.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
