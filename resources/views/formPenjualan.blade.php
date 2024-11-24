<!DOCTYPE html>
<html>

<head>
    <title>Form Penjualan</title>
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
                <button type="button" class="btn btn-primary">Master Customer</button>
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
                        <form id="penjualanForm" method="POST" action="{{ route('addPenjualan') }}">
                        @csrf
                            <button type="button" class="btn btn-info">Input</button>
                            <button type="button" class="btn btn-danger">Hapus</button>
                            <button type="button" class="btn btn-primary">Edit</button>
                            <button type="button" class="btn btn-success" onclick="updateForm('POST', '{{ route('addPenjualan') }}')">Simpan</button>

                            <hr>

                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">NO FAKTUR</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="noFakturId" name="noFaktur" value="{{ isset($dataFaktur) ? $dataFaktur->No_Faktur : '' }}" {{ isset($dataFaktur) ? 'readonly' : ''}}>
                                </div>
                                <label for="inputDate3" class="col-sm-2 col-form-label">TANGGAL</label>
                                <div class="col-sm-3">
                                    <input type="date" class="form-control" id="dateInputId" name="dateInput" value="{{ isset($dataFaktur) ? $dataFaktur->Tgl_Faktur : '' }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">KODE CUSTOMER</label>
                                <div class="col-sm-5">
                                    <select id="inputState" class="form-select" id="kodeCustomerId" name="kodeCustomer">
                                        <option selected>Choose...</option>
                                        @foreach($customers as $customer)
                                        <option value ="{{$customer->Kode_Customer}}" {{ isset($dataFaktur) && $dataFaktur->Kode_Customer == $customer->Kode_Customer ? 'selected' : '' }}> {{$customer->Kode_Customer}} - {{$customer->Nama_Customer}} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="inputPassword3" class="col-sm-2 col-form-label">JENIS TRANSAKSI</label>
                                <div class="col-sm-3">
                                    <select id="inputState" class="form-select" id="jenisTransaksiId" name="jenisTransaksi">
                                        <option selected>Choose...</option>
                                        @foreach($jenisTransaksi as $jensT)
                                        <option value ="{{$jensT->Kode_Tjen}}" {{ isset($dataFaktur) && $dataFaktur->Kode_Tjen == $jensT->Kode_Tjen ? 'selected' : '' }}> {{$jensT->Kode_Tjen}} - {{$jensT->Nama_Tjen}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>

                        <!-- Tambahkan container untuk memposisikan tombol -->
                        <div class="d-flex justify-content-end">
                            <a href="#" class="btn btn-secondary">DETAIL</a>
                        </div>

                    </div>
                </div>

                <!-- BAGIAN DETAIL -->
                <div class="card w-100 mb-3">
                    <div class="card-body">
                        <form id="penjualanDetailForm" method="POST" action="{{ route('addPenjualanDetail') }}">
                            @csrf
                            <button type="button" class="btn btn-info">Input</button>
                            <button type="button" class="btn btn-danger">Hapus</button>
                            <button type="button" class="btn btn-success" onclick="updateFormDetail('POST', '{{ route('addPenjualanDetail') }}')">Simpan</button>
                            <button type="button" class="btn btn-warning">Batal</button>
                            <button type="button" class="btn btn-dark">Header</button>

                            <hr>

                            <div class="row mb-3">
                                
                                <input type="hidden" class="form-control" id="noFakturDetailId" name="noFaktur" value="{{ isset($dataFaktur) ? $dataFaktur->No_Faktur : '' }}">
                                
                                <div class="col-sm-2">
                                    <label for="kodeBarangId" class="col-form-label">Kode Barang</label>
                                    <select class="form-select" id="kodeBarangId" name="kodeBarang">
                                        <option selected>Choose...</option>
                                        @foreach($barangs as $barang)
                                        <option value ="{{$barang->Kode_Barang}}" 
                                            data-nama-barang="{{$barang->Nama_Barang}}"
                                            data-harga-barang="{{$barang->Harga_Barang}}">  
                                            {{$barang->Kode_Barang}} - {{$barang->Nama_Barang}} 
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-3">
                                    <label for="namaBarangId" class="col-form-label">Nama Barang</label>
                                    <input type="text" class="form-control" id="namaBarangId" name="namaBarang" readonly>
                                </div>

                                <div class="col-sm-2">
                                    <label for="hargaBarangId" class="col-form-label">harga Barang</label>
                                    <input type="text" class="form-control" id="hargaBarangId" name="hargaBarang" readonly>
                                </div>
                                <div class="col-sm-1">
                                    <label for="qtyId" class="col-form-label">QTY</label>
                                    <input type="number" class="form-control" id="qtyId" name="qty" value = 0>
                                </div>

                                <div class="col-sm-1">
                                    <label for="diskonId" class="col-form-label">Diskon %</label>
                                    <input type="number" class="form-control" id="diskonId" name="diskon" value = 0>
                                </div>

                                <div class="col-sm-1">
                                    <label for="brutoId" class="col-form-label">Bruto</label>
                                    <input type="text" class="form-control" id="brutoId" name="bruto"  value = 0 readonly>
                                </div>

                                <div class="col-sm-2">
                                    <label for="jumlahId" class="col-form-label">Jumlah</label>
                                    <input type="text" class="form-control" id="jumlahId" name="jumlah" value = 0 readonly>
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
                                        <th>NO FAKTUR</th>
                                        <th>KODE BARANG</th>
                                        <th>NAMA BARANG</th>
                                        <th>HARGA</th>
                                        <th>QTY</th>
                                        <th>DISKON</th>
                                        <th>BRUTO</th>
                                        <th>JUMLAH</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($penjualanDetail as $jualD)
                                    <tr ondblclick="populateForm('{{ $jualD->No_Faktur }}', '{{ $jualD->Kode_Barang }}', '{{ $jualD->Nama_Barang }}', '{{ $jualD->Harga }}' , '{{ $jualD->QTY }}', '{{ $jualD->Diskon }}', '{{ $jualD->Bruto }}', '{{ $jualD->Jumlah }}')">
                                        <td>{{$jualD->No_Faktur}}</td>
                                        <td>{{$jualD->Kode_Barang}}</td>
                                        <td>{{$jualD->Nama_Barang}}</td>
                                        <td>{{$jualD->Harga}}</td>
                                        <td>{{$jualD->QTY}}</td>
                                        <td>{{$jualD->Diskon}}</td>
                                        <td>{{$jualD->Bruto}}</td>
                                        <td>{{$jualD->Jumlah}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN SUBTOTAL -->
                <div class="card w-50 mb-5" style="float: right;">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <label for="inputEmail3" class="col-form-label">TOTAL BRUTO</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="totalBrutoId" name="totalBruto" value="{{ isset($totalBruto) ? $totalBruto : '' }}" readonly>
                            </div>
                        </div>
                
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <label for="inputEmail3" class="col-form-label">TOTAL DISKON</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="totalDiskonId" name="totalDiskon" value="{{ isset($totalDiskon) ? $totalDiskon : '' }}" readonly>
                            </div>
                        </div>
                
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <label for="inputEmail3" class="col-form-label">TOTAL JUMLAH</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="totalJumlahId" name="totalJumlah" value="{{ isset($totalJumlah) ? $totalJumlah : '' }}" readonly>
                            </div>
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

    function populateForm(noFaktur, kodeBarang, namaBarang, harga, qty, diskon, bruto, jumlah) {
        // Set value of the input fields
        document.getElementById('noFakturDetailId').value = noFaktur;
        document.getElementById('kodeBarangId').value = kodeBarang;
        document.getElementById('namaBarangId').value = namaBarang;
        document.getElementById('hargaBarangId').value = harga;
        document.getElementById('qtyId').value = qty;
        document.getElementById('diskonId').value = (diskon / harga) * 100;
        document.getElementById('brutoId').value = bruto;
        document.getElementById('jumlahId').value = jumlah;
        console.log(noFaktur);
        console.log(kodeBarang);
        console.log(namaBarang);
        console.log(harga);
        console.log(qty);
        console.log(diskon);
        console.log(bruto);
        console.log(jumlah);
    }

    function updateForm(method, action) {
        // Update the method and action attributes of the form
        const form = document.getElementById('penjualanForm');
        
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

    function updateFormDetail(method, action) {
        // Update the method and action attributes of the form
        const form = document.getElementById('penjualanDetailForm');
        
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


    document.addEventListener('DOMContentLoaded', function () {
        function updateNamaBarang() {
            const kodeBarangSelect = document.getElementById('kodeBarangId');
            const namaBarangInput = document.getElementById('namaBarangId');
            const hargaBarangInput = document.getElementById('hargaBarangId');

            // Ambil opsi yang dipilih
            const selectedOption = kodeBarangSelect.options[kodeBarangSelect.selectedIndex];

            // Ambil data dari atribut data-nama-barang
            const namaBarang = selectedOption.getAttribute('data-nama-barang');
            const hargaBarang = selectedOption.getAttribute('data-harga-barang');

            // Isi input nama barang dengan data
            namaBarangInput.value = namaBarang || '';
            hargaBarangInput.value = hargaBarang || '';
            console.log(namaBarang); // Untuk debugging
        }

        // Menambahkan event listener untuk onchange
        const kodeBarangSelect = document.getElementById('kodeBarangId');
        kodeBarangSelect.addEventListener('change', updateNamaBarang);
    });

    document.addEventListener('DOMContentLoaded', function () {
    const qtyInput = document.getElementById('qtyId');
    const diskonInput = document.getElementById('diskonId');
    const hargaBarangInput = document.getElementById('hargaBarangId');
    const brutoInput = document.getElementById('brutoId');
    const jumlahInput = document.getElementById('jumlahId');

    function calculateTotals() {
        // Ambil nilai dari input
        const qty = parseFloat(qtyInput.value) || 0;
        const diskon = parseFloat(diskonInput.value) || 0;
        const hargaBarang = parseFloat(hargaBarangInput.value) || 0;

        // Hitung bruto
        const bruto = qty * hargaBarang;
        brutoInput.value = bruto.toFixed(2);

        // Hitung jumlah setelah diskon
        const jumlah = bruto - (bruto * diskon / 100);
        jumlahInput.value = jumlah.toFixed(2);
    }

    // Tambahkan event listener untuk QTY dan Diskon
    qtyInput.addEventListener('input', calculateTotals);
    diskonInput.addEventListener('input', calculateTotals);

    // Event untuk mengupdate harga barang dari dropdown
    const kodeBarangSelect = document.getElementById('kodeBarangId');
    kodeBarangSelect.addEventListener('change', function () {
        const selectedOption = kodeBarangSelect.options[kodeBarangSelect.selectedIndex];
        const hargaBarang = selectedOption.getAttribute('data-harga-barang') || 0;
        hargaBarangInput.value = parseFloat(hargaBarang).toFixed(2);

        // Reset input yang terkait
        qtyInput.value = '';
        diskonInput.value = '';
        brutoInput.value = '';
        jumlahInput.value = '';
    });
    
});


</script>