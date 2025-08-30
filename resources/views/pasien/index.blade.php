@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Data Pasien</h3>
    <div>
        <select id="filterRS" class="form-select d-inline-block" style="width:auto" onchange="filterRS(this.value)">
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
    <tbody>
        @foreach($pasien as $p)
        <tr id="row-{{ $p->id }}">
            <td>{{ $p->id }}</td>
            <td>{{ $p->nama_pasien }}</td>
            <td>{{ $p->alamat }}</td>
            <td>{{ $p->no_telpon }}</td>
            <td>{{ $p->rumahSakit->nama_rumah_sakit }}</td>
            <td>
                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $p->id }}">Edit</button>
                <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $p->id }}">Hapus</button>
            </td>
        </tr>

        <div class="modal fade" id="editModal{{ $p->id }}">
            <div class="modal-dialog">
                <form action="{{ route('pasien.update', $p->id) }}" method="POST">
                    @csrf @method('PUT')
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

<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <form action="{{ route('pasien.store') }}" method="POST">
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
$(document).on('click', '.btn-delete', function() {
    let id = $(this).data('id');
    if(confirm("Yakin hapus data?")) {
        $.ajax({
            url: "/pasien/" + id,
            type: "DELETE",
            data: {_token: "{{ csrf_token() }}"},
            success: function() {
                $("#row-" + id).remove();
            },
            error: function() {
                alert("Gagal menghapus data.");
            }
        });
    }
});

function filterRS(id){
    window.location.href = id == 'all' ? "{{ route('pasien.index') }}" : "/pasien/filter/"+id;
}
</script>
@endpush
