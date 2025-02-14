{{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> --}}
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        var table = $('#myTable').DataTable({
            "ajax": {
                "url": "{{ route('kelas.getall') }}",
                "type": "GET",
                "dataType": "json",
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "dataSrc": function (response) {
                    return response.status === 200 ? response.kelas.map((item, index) => {
                        item.iteration = index + 1;
                        return item;
                    }) : [];
                }
            },
            "columns": [{
                    "data": "iteration",
                    "className": "text-center"
                },
                {
                    "data": "nama_kelas",
                    "render": function(data, type, row) {
                        return row.nama_kelas ? row.nama_kelas : 'Tidak ada kelas';
                    }
                },
                {
                    "data": null,
                    "render": function (data, type, row) {
                        return '<a href="#" class="btn btn-sm btn-primary edit-btn" data-id="' + data.id + '" data-nama_kelas="' + data.nama_kelas + '"><i class="bi bi-pencil-fill"></i></a> ' +
                            '<a href="#" class="btn btn-sm btn-danger delete-btn" data-id="' + data.id + '"><i class="bi bi-trash"></i></a> ' +
                            '<button data-bs-toggle="modal" data-bs-target="#modalDetailKelas" data-kelas-id="' + data.id + '" data-nama-kelas="' + data.nama_kelas + '" class="btn btn-sm btn-info"><i class="bi bi-eye-fill"></i> All in </button>' +
                            '<button data-bs-toggle="modal" data-bs-target="#modalDetailKelasSiswa" data-kelas-id="' + data.id + '" data-nama-kelas="' + data.nama_kelas + '" class="btn btn-sm btn-info"><i class="bi bi-eye-fill"></i> Siswa aja </button>' +
                            '<button data-bs-toggle="modal" data-bs-target="#modalDetailKelasGuru" data-kelas-id="' + data.id + '" data-nama-kelas="' + data.nama_kelas + '" class="btn btn-sm btn-info"><i class="bi bi-eye-fill"></i> Guru aja </button>';
                    }
                }
            ]
        });
   
        // Handle edit button click
        $('#myTable tbody').on('click', '.edit-btn', function () {
            var id = $(this).data('id');
            var nama_kelas = $(this).data('nama_kelas');

            $('#edit-id').val(id);
            $('#edit-nama_kelas').val(nama_kelas);
            
            $('#editModal').modal('show');
        });

        // Handle detail button click
        $('#modalDetailKelas').on('show.bs.modal', function(event) {
            let button = $(event.relatedTarget);
            let kelasId = button.data('kelas-id');
            let namaKelas = button.data('nama-kelas');

            $('#namaKelas').text(`Kelas: ${namaKelas}`);
            
            if ($.fn.DataTable.isDataTable('#tableSiswa')) {
                $('#tableSiswa').DataTable().destroy();
            }
            if ($.fn.DataTable.isDataTable('#tableGuru')) {
                $('#tableGuru').DataTable().destroy();
            }

            // Ambil data siswa
            $('#tableSiswa').DataTable({
                processing: true,
                serverSide: false,
                ajax: `/kelas/getSiswa/${kelasId}`,
                columns: [
                    { data: null, render: (data, type, row, meta) => meta.row + 1 },
                    { data: 'nama_siswa' }
                ],
                language: {
                    emptyTable: "Tidak ada siswa"
                }
            });

            // Ambil data guru
            $('#tableGuru').DataTable({
                processing: true,
                serverSide: false,
                ajax: `/kelas/getGuru/${kelasId}`,
                columns: [
                    { data: null, render: (data, type, row, meta) => meta.row + 1 },
                    { data: 'nama_guru' }
                ],
                language: {
                    emptyTable: "Tidak ada guru"
                }
            });
        });

        // Handle detailKelasSiswa button click
        $('#modalDetailKelasSiswa').on('show.bs.modal', function(event) {
            let button = $(event.relatedTarget);
            if (!button.length) return;

            let kelasId = button.data('kelas-id');
            let namaKelas = button.data('nama-kelas');

            $('#namaKelasSiswa').text(`Kelas: ${namaKelas}`);
            
            if ($.fn.DataTable.isDataTable('#tableSiswaAja')) {
                $('#tableSiswaAja').DataTable().destroy();
            }

            // Ambil data siswa
            $('#tableSiswaAja').DataTable({
                processing: true,
                serverSide: false,
                ajax: `/kelas/getSiswa/${kelasId}`,
                columns: [
                    { data: null, render: (data, type, row, meta) => meta.row + 1 },
                    { data: 'nama_siswa' }
                ],
                language: {
                    emptyTable: "Tidak ada siswa"
                }
            });
        });

        // Handle detailKelasGuru button click
        $('#modalDetailKelasGuru').on('show.bs.modal', function(event) {
            let button = $(event.relatedTarget);
            if (!button.length) return;

            let kelasId = button.data('kelas-id');
            let namaKelas = button.data('nama-kelas');

            $('#namaKelasGuru').text(`Kelas: ${namaKelas}`);
            
            if ($.fn.DataTable.isDataTable('#tableGuruAja')) {
                $('#tableGuruAja').DataTable().destroy();
            }

            // Ambil data Guru
            $('#tableGuruAja').DataTable({
                processing: true,
                serverSide: false,
                ajax: `/kelas/getGuru/${kelasId}`,
                columns: [
                    { data: null, render: (data, type, row, meta) => meta.row + 1 },
                    { data: 'nama_guru' }
                ],
                language: {
                    emptyTable: "Tidak ada guru"
                }
            });
        });

        // handle add & edit
        $('#kelas-form, #edit-form').submit(function(e) {
            e.preventDefault();
            let form = $(this);
            let isEdit = form.attr('id') === 'edit-form';
            let url = isEdit ? '{{ route("kelas.update") }}' : '{{ route("kelas.store") }}';

            $.ajax({
                url: url,
                method: 'POST',
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    if (response.status === 200) {
                        Swal.fire({ title: "Berhasil!", text: response.message, icon: "success", timer: 2000, showConfirmButton: false });
                        form[0].reset();
                        let modalId = isEdit ? '#editModal' : '#createModal';

                        // Menutup modal dengan benar
                        $(modalId).modal('hide'); 
                        $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open').css('overflow', 'auto');
                        $('html').css('overflow', 'auto');
                        $(modalId).attr('aria-hidden', 'false');

                        table.ajax.reload();
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON?.errors;
                    if (xhr.status === 422 && errors?.nama_kelas) {
                        $('#edit-nama_kelas').addClass('is-invalid');
                        $('#error-edit-nama_kelas').text(errors.nama_kelas[0]);
                    } else {
                        Swal.fire({ icon: 'error', title: 'Oops...', text: 'Terjadi kesalahan! Silakan coba lagi.' });
                    }
                }
            });
        });
    });


    // Handle delete button click
    $(document).on('click', '.delete-btn', function () {
        var id = $(this).data('id');
        
        Swal.fire({
            title: "Apakah kamu yakin?",
            text: "Data ini akan dihapus permanen!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, hapus!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ url("kelas/delete") }}/' + id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status === 200) {
                            Swal.fire("Terhapus!", response.message, "success");
                            $('#myTable').DataTable().ajax.reload();
                        } else {
                            Swal.fire("Gagal!", response.message, "error");
                        }
                    },
                    error: function () {
                        Swal.fire("Error!", "Terjadi kesalahan.", "error");
                    }
                });
            }
        });
    });

</script>