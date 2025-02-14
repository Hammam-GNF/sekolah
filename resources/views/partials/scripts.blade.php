<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

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
</script>