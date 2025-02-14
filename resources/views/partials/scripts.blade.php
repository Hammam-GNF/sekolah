<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


<script>
    $(document).ready(function () {
        $.ajax({
            url: "{{ route('kelas.count') }}",
            type: 'GET',
            success: function (response) {
                if (response.status === 200) {
                    $('#total-kelas').text(response.totalKelas);
                } else {
                    $('#total-kelas').text('Error fetching data');
                }
            },
            error: function () {
                $('#total-kelas').text('Error fetching data');
            }
        });
        $.ajax({
            url: "{{ route('guru.count') }}",
            type: 'GET',
            success: function (response) {
                if (response.status === 200) {
                    $('#total-guru').text(response.totalGuru);
                } else {
                    $('#total-guru').text('Error fetching data');
                }
            },
            error: function () {
                $('#total-guru').text('Error fetching data');
            }
        });
        $.ajax({
            url: "{{ route('siswa.count') }}",
            type: 'GET',
            success: function (response) {
                if (response.status === 200) {
                    $('#total-siswa').text(response.totalSiswa);
                } else {
                    $('#total-siswa').text('Error fetching data');
                }
            },
            error: function () {
                $('#total-siswa').text('Error fetching data');
            }
        });
    });



    $(document).ready(function () {
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
            "columns": [
                {
                    "data": "iteration",
                    "className": "text-center"
                },
                {
                    "data": "nama_kelas"
                },
                {
                    "data": null,
                    "defaultContent": "Memuat...",
                    "render": function () {
                        return '<ul class="list-guru"></ul>';
                    }
                },
                {
                    "data": null,
                    "defaultContent": "Memuat...",
                    "render": function () {
                        return '<ul class="list-siswa"></ul>';
                    }
                }
            ],
            "rowCallback": function (row, data) {
                var $guruCell = $(row).find('.list-guru');
                var $siswaCell = $(row).find('.list-siswa');

                $.ajax({
                    "url": "{{ url('/kelas/getGuru') }}/" + data.id,
                    "type": "GET",
                    "success": function (response) {
                        $guruCell.empty();
                        if (response.data.length > 0) {
                            response.data.forEach(function (guru) {
                                $guruCell.append('<li>' + guru.nama_guru + '</li>');
                            });
                        } else {
                            $guruCell.append('<li>Tidak ada guru</li>');
                        }
                    }
                });

                $.ajax({
                    "url": "{{ url('/kelas/getSiswa') }}/" + data.id,
                    "type": "GET",
                    "success": function (response) {
                        $siswaCell.empty();
                        if (response.data.length > 0) {
                            response.data.forEach(function (siswa) {
                                $siswaCell.append('<li>' + siswa.nama_siswa + '</li>');
                            });
                        } else {
                            $siswaCell.append('<li>Tidak ada siswa</li>');
                        }
                    }
                });
            }
        });

        var table = $('#myTable2').DataTable({
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
            "columns": [
                {
                    "data": "iteration",
                    "className": "text-center"
                },
                {
                    "data": "nama_kelas"
                },
                {
                    "data": null,
                    "defaultContent": "Memuat...",
                    "render": function () {
                        return '<ul class="list-siswa"></ul>';
                    }
                }
            ],
            "rowCallback": function (row, data) {
                var $siswaCell = $(row).find('.list-siswa');

                $.ajax({
                    "url": "{{ url('/kelas/getSiswa') }}/" + data.id,
                    "type": "GET",
                    "success": function (response) {
                        $siswaCell.empty();
                        if (response.data.length > 0) {
                            response.data.forEach(function (siswa) {
                                $siswaCell.append('<li>' + siswa.nama_siswa + '</li>');
                            });
                        } else {
                            $siswaCell.append('<li>Tidak ada siswa</li>');
                        }
                    }
                });
            }
        });

        var table = $('#myTable3').DataTable({
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
            "columns": [
                {
                    "data": "iteration",
                    "className": "text-center"
                },
                {
                    "data": "nama_kelas"
                },
                {
                    "data": null,
                    "defaultContent": "Memuat...",
                    "render": function () {
                        return '<ul class="list-guru"></ul>';
                    }
                }
            ],
            "rowCallback": function (row, data) {
                var $guruCell = $(row).find('.list-guru');

                $.ajax({
                    "url": "{{ url('/kelas/getGuru') }}/" + data.id,
                    "type": "GET",
                    "success": function (response) {
                        $guruCell.empty();
                        if (response.data.length > 0) {
                            response.data.forEach(function (guru) {
                                $guruCell.append('<li>' + guru.nama_guru + '</li>');
                            });
                        } else {
                            $guruCell.append('<li>Tidak ada guru</li>');
                        }
                    }
                });
            }
        });
    });


</script>