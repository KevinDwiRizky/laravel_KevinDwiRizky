@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Data Pasien</h3>
    <div>
        <select id="filterRS" class="form-select d-inline-block" style="width:auto">
            <option value="all">Semua Rumah Sakit</option>
            @foreach($rumahSakit as $rs)
            <option value="{{ $rs->id }}">{{ $rs->nama_rumah_sakit }}</option>
            @endforeach
        </select>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">+ Tambah</button>
    </div>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Pasien</th>
            <th>Alamat</th>
            <th>No Telpon</th>
            <th>Rumah Sakit</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody id="pasienBody">
        @foreach($pasien as $p)
        <tr id="row-{{ $p->id }}">
            <td>{{ $p->id }}</td>
            <td class="p-nama">{{ $p->nama_pasien }}</td>
            <td class="p-alamat">{{ $p->alamat }}</td>
            <td class="p-telp">{{ $p->no_telpon }}</td>
            <td class="p-rs">{{ $p->rumahSakit->nama_rumah_sakit }}</td>
            <td>
                <button class="btn btn-sm btn-warning btn-edit" data-id="{{ $p->id }}" data-bs-toggle="modal" data-bs-target="#editModal{{ $p->id }}">Edit</button>
                <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $p->id }}">Hapus</button>
            </td>
        </tr>

        <!-- Modal Edit -->
        <div class="modal fade" id="editModal{{ $p->id }}">
            <div class="modal-dialog">
                <form class="editForm" data-id="{{ $p->id }}">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header"><h5>Edit Pasien</h5></div>
                        <div class="modal-body">
                            <div class="mb-2">
                                <label>Nama</label>
                                <input type="text" name="nama_pasien" value="{{ $p->nama_pasien }}" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Alamat</label>
                                <textarea name="alamat" class="form-control">{{ $p->alamat }}</textarea>
                            </div>
                            <div class="mb-2">
                                <label>No Telpon</label>
                                <input type="text" name="no_telpon" value="{{ $p->no_telpon }}" class="form-control">
                            </div>
                            <div class="mb-2">
                                <label>Rumah Sakit</label>
                                <select name="rumah_sakit_id" class="form-select">
                                    @foreach($rumahSakit as $rs)
                                    <option value="{{ $rs->id }}" {{ $p->rumah_sakit_id==$rs->id?'selected':'' }}>{{ $rs->nama_rumah_sakit }}</option>
                                    @endforeach
                                </select>
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

<!-- Modal Tambah -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <form id="addForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header"><h5>Tambah Pasien</h5></div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label>Nama</label>
                        <input type="text" name="nama_pasien" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Alamat</label>
                        <textarea name="alamat" class="form-control"></textarea>
                    </div>
                    <div class="mb-2">
                        <label>No Telpon</label>
                        <input type="text" name="no_telpon" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label>Rumah Sakit</label>
                        <select name="rumah_sakit_id" class="form-select">
                            @foreach($rumahSakit as $rs)
                            <option value="{{ $rs->id }}">{{ $rs->nama_rumah_sakit }}</option>
                            @endforeach
                        </select>
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
    $.post("{{ route('pasien.store') }}", data, function(res){
        let newRow = `<tr id="row-${res.id}">
            <td>${res.id}</td>
            <td class="p-nama">${res.nama_pasien}</td>
            <td class="p-alamat">${res.alamat}</td>
            <td class="p-telp">${res.no_telpon}</td>
            <td class="p-rs">${$('select[name="rumah_sakit_id"] option[value="'+res.rumah_sakit_id+'"]').text()}</td>
            <td>
                <button class="btn btn-sm btn-warning btn-edit" data-id="${res.id}" data-bs-toggle="modal" data-bs-target="#editModal${res.id}">Edit</button>
                <button class="btn btn-sm btn-danger btn-delete" data-id="${res.id}">Hapus</button>
            </td>
        </tr>`;
        $('#pasienBody').append(newRow);
        $('#addModal').modal('hide');
        $('#addForm')[0].reset();
    });
});

$('.editForm').submit(function(e){
    e.preventDefault();
    let id = $(this).data('id');
    let data = $(this).serialize();
    $.post("/pasien/"+id, data, function(res){
        let row = $("#row-"+id);
        row.find('.p-nama').text(res.nama_pasien);
        row.find('.p-alamat').text(res.alamat);
        row.find('.p-telp').text(res.no_telpon);
        let rsText = $("#editModal"+id+" select[name='rumah_sakit_id'] option:selected").text();
        row.find('.p-rs').text(rsText);
        $('#editModal'+id).modal('hide');
    });
});

$(document).on('click', '.btn-delete', function() {
    let id = $(this).data('id');
    if(confirm("Yakin hapus data?")) {
        $.ajax({
            url: "/pasien/" + id,
            type: "DELETE",
            data: {_token: "{{ csrf_token() }}"},
            success: function() {
                $("#row-" + id).remove();
            }
        });
    }
});

$('#filterRS').change(function(){
    let rs_id = $(this).val();
    $.get("/pasien/filter/"+rs_id, function(res){
        let html = '';
        res.forEach(p=>{
            let rsText = p.rumah_sakit_id ? $('#filterRS option[value="'+p.rumah_sakit_id+'"]').text() : '';
            html += `<tr id="row-${p.id}">
                <td>${p.id}</td>
                <td class="p-nama">${p.nama_pasien}</td>
                <td class="p-alamat">${p.alamat}</td>
                <td class="p-telp">${p.no_telpon}</td>
                <td class="p-rs">${rsText}</td>
                <td>
                    <button class="btn btn-sm btn-warning btn-edit" data-id="${p.id}" data-bs-toggle="modal" data-bs-target="#editModal${p.id}">Edit</button>
                    <button class="btn btn-sm btn-danger btn-delete" data-id="${p.id}">Hapus</button>
                </td>
            </tr>`;
        });
        $('#pasienBody').html(html);
    });
});
</script>
@endpush
