<!DOCTYPE html>
<html>

<head>
    <title>Master Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <style>
        .mx-auto {
            width: 1600px;
            margin-top: 60px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary">Master Barang</button>
                <button type="button" class="btn btn-primary">Form Penjualan</button>
            </div>
            <div class="card-body">
                <!-- Card pertama -->
                <div class="card w-100 mb-3">
                    <div class="card-body">
                        @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{session('success')}}
                        </div>
                        @elseif(session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{session('error')}}
                        </div>
                        @elseif($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <form id="customerForm" method="POST" action="{{ route('addCustomer') }}">
                        @csrf
                        <button type="button" class="btn btn-success" onclick="updateForm('POST', '{{ route('addCustomer') }}')">Simpan</button>
                        <button type="button" class="btn btn-primary" onclick="updateForm('PUT', '{{ route('updateCustomer') }}')">Edit</button>
                        <button type="button" class="btn btn-danger" onclick="updateForm('DELETE', '{{ route('deleteCustomer') }}')">Hapus</button>
                
                            <hr>
                
                            <div class="row mb-3">
                                <div class="col-sm-3 d-flex justify-content-center align-items-center">
                                    <div class="w-100">
                                        <label for="inputEmail3" class="col-form-label text-center">Kode Customer</label>
                                        <input type="text" class="form-control" id="kodeCustomerId" name="kodeCustomer">
                                    </div>
                                </div>
                                <div class="col-sm-3 d-flex justify-content-center align-items-center">
                                    <div class="w-100">
                                        <label for="inputEmail3" class="col-form-label text-center">Nama Customer</label>
                                        <input type="text" class="form-control" id="namaCustomerId" name="namaCustomer">
                                    </div>
                                </div>
                                
                            </div>
                        
                        </form>
                    </div>
                </div>
                


                <!-- BAGIAN TABEL -->
                <div class="card w-100 mb-3">
                    <div class="card-body">
                        <div style="max-height: 200px; overflow-y: auto;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>KODE CUSTOMER</th>
                                        <th>NAMA CUSTOMER</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customers as $customer)
                                    <tr ondblclick="populateForm('{{ $customer->Kode_Customer }}', '{{ $customer->Nama_Customer }}')">
                                        <td>{{$customer->Kode_Customer}}</td>
                                        <td>{{$customer->Nama_Customer}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>




        </div>


    </div>
    </div>

</body>

</html>

<script>
    function populateForm(kodeCustomer, namaCustomer) {
        // Set value of the input fields
        document.getElementById('kodeCustomerId').value = kodeCustomer;
        document.getElementById('namaCustomerId').value = namaCustomer;
    }
    function updateForm(method, action) {
        // Update the method and action attributes of the form
        const form = document.getElementById('customerForm');
        
        // Laravel only supports GET and POST in forms, so handle PUT and DELETE with a hidden input
        let hiddenInput = document.querySelector('input[name="_method"]');
        if (!hiddenInput) {
            hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = '_method';
            form.appendChild(hiddenInput);
        }

        if (method === 'POST') {
            hiddenInput.remove(); // Remove hidden input if it's POST
        } else {
            hiddenInput.value = method; // Set method value (PUT or DELETE)
        }

        form.method = 'POST'; // Laravel expects POST with _method for PUT and DELETE
        form.action = action;

        // Automatically submit the form (optional)
        form.submit(); // Uncomment if needed
    }
</script>