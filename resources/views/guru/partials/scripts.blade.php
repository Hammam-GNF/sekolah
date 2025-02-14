<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        var table = $('#myTable').DataTable({
            "ajax": {
                "url": "{{ route('guru.getall') }}",
                "type": "GET",
                "dataType": "json",
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "dataSrc": function(response) {
                    return response.status === 200 ? response.guru : [];
                }
            },
            "columns": [{
                    "data": "id",
                    "className": "text-center"
                },
                {
                    "data": "nama_guru",
                    "render": function(data, type, row) {
                        return row.nama_guru ? row.nama_guru : 'Tidak ada guru';
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
                        return '<a href="#" class="btn btn-sm btn-primary edit-btn" data-id="' + data.id + '" data-nama_guru="' + data.nama_guru + '" data-kelas_id="' + data.kelas_id + '"><i class="bi bi-pencil-fill"></i></a> ' +
                            '<a href="#" class="btn btn-sm btn-danger delete-btn" data-id="' + data.id + '"><i class="bi bi-trash"></i></a>';
                    }
                }
            ]
        });
    });
   
    // Handle edit button click
    $(document).on('click', '.edit-btn', function () {
        var id = $(this).data('id');
        var nama_guru = $(this).data('nama_guru');
        var kelas_id = $(this).data('kelas_id');

        $('#edit-id').val(id);
        $('#edit-nama_guru').val(nama_guru);

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

        $('#editModal').modal('show');
    });

     // Handle add form submission
    $(document).ready(function () {
        $('#save-guru').click(function (e) {
            e.preventDefault();
            
            let formData = new FormData($('#guru-form')[0]);
            
            $.ajax({
                url: '{{ route("guru.store") }}',
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status === 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        });

                        $('#guru-form')[0].reset();
                        $('#createModal').modal('hide');
                        $('#createModal').on('hidden.bs.modal', function () {
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();
                        });
                        $('#myTable').DataTable().ajax.reload();
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        if (errors.nama_guru) {
                            $('#nama_guru').addClass('is-invalid');
                            $('#error-nama_guru').text(errors.nama_guru[0]);
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Terjadi kesalahan! Silakan coba lagi.',
                        });
                    }
                }
            });
        });

        // Handle edit form submission
        $('#edit-form').submit(function (e) {
            e.preventDefault();
        
            let formData = new FormData($('#edit-form')[0]);

            $.ajax({
                url: '{{ route("guru.update") }}',
                method: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status === 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        });

                        $('#edit-form')[0].reset();
                        $('#editModal').modal('hide');
                        $('#editModal').on('hidden.bs.modal', function () {
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();
                        });
                        $('#myTable').DataTable().ajax.reload();
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        if (errors.nama_guru) {
                            $('#edit-nama_guru').addClass('is-invalid');
                            $('#error-edit-nama_guru').text(errors.nama_guru[0]);
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Terjadi kesalahan! Silakan coba lagi.',
                        });
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
                    url: '{{ url("guru/delete") }}/' + id,
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

    //
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

        

    function focusNextInput(event) {
        const inputs = document.querySelectorAll('#petugas-form input');
        let index = Array.prototype.indexOf.call(inputs, event.target);
        if (index > -1 && index < inputs.length - 1) {
            inputs[index + 1].focus();
        }
    }

</script>