<div class="modal fade" id="modalDetailKelasGuru" tabindex="-1" aria-labelledby="modalDetailKelasGuruLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailKelasGuruLabel">Detail Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <h5 id="namaKelasGuru" class="mb-3"></h5>
                <h6>Daftar Guru</h6>
                <div id="loaderGuru" class="text-center text-muted d-none">Memuat data...</div>
                <table id="tableGuruAja" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Guru</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <span id="noGuru" class="text-muted d-none">Tidak ada guru</span>
            </div>
        </div>
    </div>
</div>
