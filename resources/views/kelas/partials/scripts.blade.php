<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
                            '<a href="#" class="btn btn-sm btn-danger delete-btn" data-id="' + data.id + '"><i class="bi bi-trash"></i></a>';
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
    });

     // Handle add form submission
    $(document).ready(function () {
        $('#save-kelas').click(function (e) {
            e.preventDefault();
            
            let formData = new FormData($('#kelas-form')[0]);
            
            $.ajax({
                url: '{{ route("kelas.store") }}',
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

                        $('#kelas-form')[0].reset();
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
                        if (errors.nama_kelas) {
                            $('#nama_kelas').addClass('is-invalid');
                            $('#error-nama_kelas').text(errors.nama_kelas[0]);
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


    // Handle edit form submission
    $('#edit-form').submit(function (e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: '{{ route("kelas.update") }}',
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
                    Swal.fire("Berhasil!", response.message, "success");
                    $('#edit-form')[0].reset();
                    $('#editModal').modal('hide');
                    table.ajax.reload();
                } else {
                    Swal.fire("Gagal!", response.message, "error");
                }
            },
            error: function () {
                Swal.fire("Error!", "Terjadi kesalahan.", "error");
            }
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


        

    function focusNextInput(event) {
        const inputs = document.querySelectorAll('#petugas-form input');
        let index = Array.prototype.indexOf.call(inputs, event.target);
        if (index > -1 && index < inputs.length - 1) {
            inputs[index + 1].focus();
        }
    }

</script>