<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        var table = $('#myTable').DataTable({
            "ajax": {
                "url": "{{ route('siswa.getall') }}",
                "type": "GET",
                "dataType": "json",
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "dataSrc": function(response) {
                    return response.status === 200 ? response.siswa.map((item, index) => {
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
                    "data": "nama_siswa",
                    "render": function(data, type, row) {
                        return row.nama_siswa ? row.nama_siswa : 'Tidak ada siswa';
                    }
                },
                {
                    "data": "ortu_id",
                    "render": function(data, type, row) {
                        return row.ortu ? row.ortu.nama_ortu : 'Tidak ada ortu';
                    }
                },
                {
                    "data": "kelas_id",
                    "render": function(data, type, row) {
                        return row.kelas ? row.kelas.nama_kelas : 'Tidak ada kelas';
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        return '<a href="#" class="btn btn-sm btn-primary edit-btn" data-id="' + data.id + '" data-nama_siswa="' + data.nama_siswa + '" data-kelas_id="' + data.kelas_id + '" data-ortu_id="' + data.ortu_id + '"><i class="bi bi-pencil-fill"></i></a> ' +
                            '<a href="#" class="btn btn-sm btn-danger delete-btn" data-id="' + data.id + '"><i class="bi bi-trash"></i></a>';
                    }
                }
            ]
        });
    });
   
    // Handle edit button click
    $(document).on('click', '.edit-btn', function () {
        var id = $(this).data('id');
        var nama_siswa = $(this).data('nama_siswa');
        var kelas_id = $(this).data('kelas_id');
        var ortu_id = $(this).data('ortu_id');

        $('#edit-id').val(id);
        $('#edit-nama_siswa').val(nama_siswa);
        $('#edit-nama_kelas').val(kelas_id);
        $('#edit-nama_ortu').val(ortu_id);

        $.ajax({
            url: "{{ route('kelas.getall') }}",
            type: "GET",
            dataType: "json",
            success: function (response) {
                let kelasDropdown = $('#edit-nama_kelas');

                kelasDropdown.empty();
                kelasDropdown.append('<option value="">---Pilih Kelas---</option>');

                $.each(response.kelas, function (index, kelas) {
                    kelasDropdown.append('<option value="' + kelas.id + '">' + kelas.nama_kelas + '</option>');
                });

                if (kelas_id) {
                    kelasDropdown.val(kelas_id);
                }
            },
            error: function () {
                Swal.fire('Error', 'Gagal mengambil data kelas', 'error');
            }
        });

        $.ajax({
            url: "{{ route('ortu.getall') }}",
            type: "GET",
            dataType: "json",
            success: function (response) {
                let ortuDropdown = $('#edit-nama_ortu');

                ortuDropdown.empty();
                ortuDropdown.append('<option value="">---Pilih ortu---</option>');

                $.each(response.ortu, function (index, ortu) {
                    ortuDropdown.append('<option value="' + ortu.id + '">' + ortu.nama_ortu + '</option>');
                });

                if (ortu_id) {
                    ortuDropdown.val(ortu_id);
                }
            },
            error: function () {
                Swal.fire('Error', 'Gagal mengambil data ortu', 'error');
            }
        });

        $('#editModal').modal('show');
    });

    // Handle add & edit form submission
    $(document).ready(function () {
        var table = $("#myTable").DataTable();
        $('#siswa-form, #edit-form').submit(function(e) {
            e.preventDefault();
            let form = $(this);
            let isEdit = form.attr('id') === 'edit-form';
            let url = isEdit ? '{{ route("siswa.update") }}' : '{{ route("siswa.store") }}';

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
                    if (xhr.status === 422 && errors?.nama_kelas.nama_ortu) {
                        $('#edit-nama_kelas', '#edit-nama_ortu').addClass('is-invalid');
                        $('#error-edit-nama_kelas', '#error-edit-nama_ortu').text(errors.nama_kelas[0], errors.nama_ortu[0]);
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
                    url: '{{ url("siswa/delete") }}/' + id,
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

    $(document).ready(function () {
        $('#createModal').on('show.bs.modal', function () {
            $.ajax({
                url: "{{ route('kelas.getall') }}",
                type: "GET",
                dataType: "json",
                success: function (response) {
                    let kelasDropdown = $('#kelas_id');
                    kelasDropdown.empty();
                    kelasDropdown.append('<option value="">---Pilih Kelas---</option>');
                    
                    $.each(response.kelas, function (index, kelas) {
                        kelasDropdown.append('<option value="' + kelas.id + '">' + kelas.nama_kelas + '</option>');
                    });

                    let selectedKelas = $('#edit-nama_kelas').data('selected');
                    if (selectedKelas) {
                        $('#edit-nama_kelas').val(selectedKelas).trigger('change');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'Gagal mengambil data kelas', 'error');
                }
            });
        });
    });

    $(document).ready(function () {
        $('#createModal').on('show.bs.modal', function () {
            $.ajax({
                url: "{{ route('ortu.getall') }}",
                type: "GET",
                dataType: "json",
                success: function (response) {
                    let ortuDropdown = $('#ortu_id');
                    ortuDropdown.empty();
                    ortuDropdown.append('<option value="">---Pilih ortu---</option>');
                    
                    $.each(response.ortu, function (index, ortu) {
                        ortuDropdown.append('<option value="' + ortu.id + '">' + ortu.nama_ortu + '</option>');
                    });

                    let selectedOrtu = $('#edit-nama_ortu').data('selected');
                    if (selectedOrtu) {
                        $('#edit-nama_ortu').val(selectedOrtu).trigger('change');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'Gagal mengambil data kelas', 'error');
                }
            });
        });
    });
        

    function focusNextInput(event) {
        const inputs = document.querySelectorAll('#siswa-form input');
        let index = Array.prototype.indexOf.call(inputs, event.target);
        if (index > -1 && index < inputs.length - 1) {
            inputs[index + 1].focus();
        }
    }

</script>