@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Data Rumah Sakit</h3>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">+ Tambah</button>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Rumah Sakit</th>
            <th>Alamat</th>
            <th>Email</th>
            <th>Telepon</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rumahSakit as $rs)
        <tr>
            <td>{{ $rs->id }}</td>
            <td>{{ $rs->nama_rumah_sakit }}</td>
            <td>{{ $rs->alamat }}</td>
            <td>{{ $rs->email }}</td>
            <td>{{ $rs->telepon }}</td>
            <td>
                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $rs->id }}">Edit</button>
                <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $rs->id }}">Hapus</button>
            </td>
        </tr>

        <div class="modal fade" id="editModal{{ $rs->id }}">
            <div class="modal-dialog">
                <form action="{{ route('rumah_sakit.ajaxUpdate', $rs->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header"><h5>Edit Rumah Sakit</h5></div>
                        <div class="modal-body">
                            <div class="mb-2">
                                <label>Nama</label>
                                <input type="text" name="nama_rumah_sakit" value="{{ $rs->nama_rumah_sakit }}" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Alamat</label>
                                <textarea name="alamat" class="form-control">{{ $rs->alamat }}</textarea>
                            </div>
                            <div class="mb-2">
                                <label>Email</label>
                                <input type="email" name="email" value="{{ $rs->email }}" class="form-control">
                            </div>
                            <div class="mb-2">
                                <label>Telepon</label>
                                <input type="text" name="telepon" value="{{ $rs->telepon }}" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" type="submit">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endforeach
    </tbody>
</table>

<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <form action="{{ route('rumah_sakit.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header"><h5>Tambah Rumah Sakit</h5></div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label>Nama</label>
                        <input type="text" name="nama_rumah_sakit" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Alamat</label>
                        <textarea name="alamat" class="form-control"></textarea>
                    </div>
                    <div class="mb-2">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label>Telepon</label>
                        <input type="text" name="telepon" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$.ajaxSetup({ headers:{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});

$(document).on('click', '.btn-delete', function() {
    let id = $(this).data('id');
    if(confirm("Yakin hapus data?")) {
        $.ajax({
            url: "/rumah_sakit/" + id,
            type: "DELETE",
            data: {_token: "{{ csrf_token() }}"},
            success: function() {
                alert('Data berhasil dihapus');
                location.reload();
            }
        });
    }
});
</script>
@endpush
