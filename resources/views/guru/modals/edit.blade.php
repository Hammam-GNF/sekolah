<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Perbaharui Data Guru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit-form" method="post">
                    @csrf
                    <input type="hidden" id="edit-id" name="id">
                    <div class="row">
                        <div class="col-lg">
                            <label>Nama Guru</label>
                            <input type="text" id="edit-nama_guru" name="nama_guru" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg">
                            <label>Nama Kelas</label>
                            <select id="edit-nama_kelas" name="kelas_id" class="form-control">
                                <option value="">--- Pilih Kelas ---</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" form="edit-form">Simpan</button>
            </div>
        </div>
    </div>
</div>