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
    <tbody id="rsBody">
        @foreach($rumahSakit as $rs)
        <tr id="row-{{ $rs->id }}">
            <td>{{ $rs->id }}</td>
            <td class="rs-nama">{{ $rs->nama_rumah_sakit }}</td>
            <td class="rs-alamat">{{ $rs->alamat }}</td>
            <td class="rs-email">{{ $rs->email }}</td>
            <td class="rs-telepon">{{ $rs->telepon }}</td>
            <td>
                <button class="btn btn-sm btn-warning btn-edit" data-id="{{ $rs->id }}" data-bs-toggle="modal" data-bs-target="#editModal{{ $rs->id }}">Edit</button>
                <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $rs->id }}">Hapus</button>
            </td>
        </tr>

        <div class="modal fade" id="editModal{{ $rs->id }}">
            <div class="modal-dialog">
                <form class="editForm" data-id="{{ $rs->id }}">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header"><h5>Edit Rumah Sakit</h5></div>
                        <div class="modal-body">
                            <div class="mb-2">
                                <label>Nama</label>
                                <input type="text" name="nama_rumah_sakit" value="{{ $rs->nama_rumah_sakit }}" class="form-control">
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
        <form id="addForm">
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

$('#addForm').submit(function(e){
    e.preventDefault();
    let data = $(this).serialize();
    $.post("{{ route('rumah_sakit.store') }}", data, function(res){
        let newRow = `<tr id="row-${res.id}">
            <td>${res.id}</td>
            <td class="rs-nama">${res.nama_rumah_sakit}</td>
            <td class="rs-alamat">${res.alamat}</td>
            <td class="rs-email">${res.email}</td>
            <td class="rs-telepon">${res.telepon}</td>
            <td>
                <button class="btn btn-sm btn-warning btn-edit" data-id="${res.id}" data-bs-toggle="modal" data-bs-target="#editModal${res.id}">Edit</button>
                <button class="btn btn-sm btn-danger btn-delete" data-id="${res.id}">Hapus</button>
            </td>
        </tr>`;
        $('#rsBody').append(newRow);
        $('#addModal').modal('hide');
        $('#addForm')[0].reset();
    });
});

$('.editForm').submit(function(e){
    e.preventDefault();
    let id = $(this).data('id');
    let data = $(this).serialize();
    $.ajax({
        url: "/rumah_sakit/"+id,
        type: "POST",
        data: data,
        success: function(res){
            let row = $("#row-"+id);
            row.find('.rs-nama').text(res.nama_rumah_sakit);
            row.find('.rs-alamat').text(res.alamat);
            row.find('.rs-email').text(res.email);
            row.find('.rs-telepon').text(res.telepon);
            $('#editModal'+id).modal('hide');
        }
    });
});

$(document).on('click', '.btn-delete', function() {
    let id = $(this).data('id');
    if(confirm("Yakin hapus data?")) {
        $.ajax({
            url: "/rumah_sakit/" + id,
            type: "DELETE",
            data: {_token: "{{ csrf_token() }}"},
            success: function() {
                $("#row-" + id).remove();
            }
        });
    }
});
</script>
@endpush
