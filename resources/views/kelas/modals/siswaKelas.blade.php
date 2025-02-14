<div class="modal fade" id="modalDetailKelasSiswa" tabindex="-1" aria-labelledby="modalDetailKelasSiswaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailKelasSiswaLabel">Detail Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <h5 id="namaKelasSiswa" class="mb-3"></h5>
                <h6>Daftar Siswa</h6>
                <div id="loaderSiswa" class="text-center text-muted d-none">Memuat data...</div>
                <table id="tableSiswaAja" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Siswa</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <span id="noSiswa" class="text-muted d-none">Tidak ada siswa</span>
            </div>
        </div>
    </div>
</div>
