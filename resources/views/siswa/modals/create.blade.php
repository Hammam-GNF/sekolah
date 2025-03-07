<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Tambah Data Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="siswa-form">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_siswa" class="form-label">Nama Siswa</label>
                        <input type="text" name="nama_siswa" id="nama_siswa" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_kelas" class="form-label">Nama Kelas</label>
                        <select name="kelas_id" id="kelas_id" class="form-control" required>
                            <option value="">---Pilih Kelas---</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nama_ortu" class="form-label">Nama Ortu</label>
                        <select name="ortu_id" id="ortu_id" class="form-control" required>
                            <option value="">---Pilih Ortu---</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" form="siswa-form">Simpan</button>
            </div>
        </div>
    </div>
</div>
