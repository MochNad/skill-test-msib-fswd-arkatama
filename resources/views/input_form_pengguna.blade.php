<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Form Pengguna</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

    <div class="container mt-5">
        <form id="dataForm">
            @csrf
            <div class="form-group">
                <label for="data">Masukkan data (NAMA USIA KOTA): </label>
                <input type="text" class="form-control" name="data" required placeholder="CUT MINI 28 BANDA ACEH">
            </div>
            <button type="button" class="btn btn-primary" onclick="postData()">Proses</button>
        </form>

        <div class="modal" id="resultModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalHeader">Data Pengguna</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Nama: <span id="modalNama"></span></p>
                        <p>Usia: <span id="modalUsia"></span></p>
                        <p>Kota: <span id="modalKota"></span></p>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <script>
            function postData() {
                var formData = new FormData(document.getElementById('dataForm'));

                fetch("{{ url('/process-input-pengguna') }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        var modalHeader = document.getElementById('modalHeader');
                        var modalNama = document.getElementById('modalNama');
                        var modalUsia = document.getElementById('modalUsia');
                        var modalKota = document.getElementById('modalKota');

                        if (data.status === 'success') {
                            modalHeader.innerText = 'Success';
                            modalNama.innerText = data.data.nama;
                            modalUsia.innerText = data.data.usia;
                            modalKota.innerText = data.data.kota;
                        } else {
                            modalHeader.innerText = 'Failed';
                            modalNama.innerText = '';
                            modalUsia.innerText = '';
                            modalKota.innerText = '';

                            console.error('Error:', data.message);
                        }

                        $('#resultModal').modal('show');
                    })
                    .catch(error => console.error('Error:', error));
            }
        </script>
</body>

</html>
