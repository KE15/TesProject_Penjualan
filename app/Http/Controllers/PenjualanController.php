<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    //
    public function showFormPenjualan($noFaktur = ''){
        $customers = DB::table('t_customer')->get();
        $jenisTransaksi = DB::table('t_jen')->get();
        $barangs = DB::table('t_barang')->get();
        $penjualanDetail = [];

        if($noFaktur != ''){
            $dataFaktur = DB::table('t_jual')->where('No_Faktur', $noFaktur)->get();
            $penjualanDetail = DB::table('t_djual')
            ->join('t_barang', 't_djual.Kode_Barang', '=', 't_barang.Kode_Barang')
            ->select(
                't_djual.No_Faktur',
                't_djual.Kode_Barang',
                't_barang.Nama_Barang',
                't_djual.Harga',
                't_djual.QTY',
                't_djual.Diskon',
                't_djual.Bruto',
                't_djual.Jumlah'
            )
            ->where('No_Faktur', $noFaktur)
            ->get();

            // Inisialisasi variabel total untuk diskon, bruto, dan jumlah
            $tDiskon = 0;
            $tBruto = 0;
            $tJumlah = 0;

            // Loop untuk menghitung total diskon, bruto, dan jumlah
            foreach ($penjualanDetail as $JD) {
                $tDiskon += $JD->Diskon; // Menambahkan diskon
                $tBruto += $JD->Bruto;   // Menambahkan bruto
                $tJumlah += $JD->Jumlah; // Menambahkan jumlah
            }

            return view('formPenjualan', ['customers'=> $customers, 'jenisTransaksi'=>$jenisTransaksi, 'barangs' => $barangs, 'dataFaktur' => $dataFaktur[0], 'penjualanDetail' => $penjualanDetail, 'totalDiskon' => $tDiskon, 'totalBruto' => $tBruto, 'totalJumlah' => $tJumlah]);
        }

        return view('formPenjualan', ['customers'=> $customers, 'jenisTransaksi'=>$jenisTransaksi, 'barangs' => $barangs, 'penjualanDetail' => $penjualanDetail]);
    }

    public function addPenjualan(Request $request){
        $validatedRequest = $request->validate([
            'noFaktur'=> 'required|max:6',
            'dateInput'=> 'required|date',
            'kodeCustomer'=> 'required',
            'jenisTransaksi'=> 'required'

        ]);

        try{
            DB::table('t_jual')->insert([
                // nama kolom -> name input
                'No_Faktur' => $validatedRequest['noFaktur'],
                'Kode_Customer' => $validatedRequest['kodeCustomer'],
                'Kode_Tjen' => $validatedRequest['jenisTransaksi'],
                'Tgl_Faktur' => $validatedRequest['dateInput'],
                'Total_Bruto' => 0,
                'Total_Diskon' => 0,
                'Total_Jumlah' => 0
            ]);
        }
        catch(\Exception $er){
            \Log::error($er->getMessage());
            return redirect()->route('showFormPenjualan')->with('error', 'Data Penjualan Header gagal ditambahkan');
        }
        
        return redirect()->route('showFormPenjualanDetail', ['noFaktur'=>$validatedRequest['noFaktur']])->with('success', 'Data Penjualan Header Berhasil ditambahkan');
    }

    public function addPenjualanDetail(Request $request){
        $validatedRequest = $request->validate([
            'noFaktur'=> 'required',
            'kodeBarang'=> 'required',
            'hargaBarang'=> 'required',
            'qty'=> 'required',
            'diskon'=> 'required',
            'bruto'=> 'required',
            'jumlah'=> 'required',

        ]);

        try{

            // Menghitung nominal diskon (Diskon dalam persen)
            $hargaBarang = $validatedRequest['hargaBarang'];
            $diskonPersen = $validatedRequest['diskon'];

            // Menghitung nominal diskon (berupa uang)
            $nominalDiskon = ($hargaBarang * $diskonPersen) / 100;

            // Menghitung bruto (Harga barang setelah diskon)
            $bruto = $hargaBarang - $nominalDiskon; // atau bisa juga $bruto = $hargaBarang * (1 - $diskonPersen / 100);

            // Mengambil quantity (QTY) dari input
            $qty = $validatedRequest['qty'];

            // Menghitung jumlah (Bruto * QTY)
            $jumlah = $bruto * $qty;

            DB::table('t_djual')->insert([
                'No_Faktur'   => $validatedRequest['noFaktur'],
                'Kode_Barang' => $validatedRequest['kodeBarang'],
                'Harga'       => $hargaBarang,
                'QTY'         => $qty,
                'Diskon'      => $nominalDiskon, // Menyimpan nominal diskon
                'Bruto'       => $bruto,
                'Jumlah'      => $jumlah,
            ]);

            // Menghitung total diskon, bruto, dan jumlah berdasarkan No_Faktur
            $totals = DB::table('t_djual')
            ->where('No_Faktur', $validatedRequest['noFaktur'])
            ->select(
                DB::raw('SUM(Diskon) as totalDiskon'),
                DB::raw('SUM(Bruto) as totalBruto'),
                DB::raw('SUM(Jumlah) as totalJumlah')
            )
            ->first();

             // Memperbarui total di tabel t_jual
            DB::table('t_jual')
            ->where('No_Faktur', $validatedRequest['noFaktur'])
            ->update([
                'Total_Diskon' => $totals->totalDiskon,
                'Total_Bruto'  => $totals->totalBruto,
                'Total_Jumlah' => $totals->totalJumlah,
            ]);

        }
        catch(\Exception $er){
            \Log::error($er->getMessage());
            return redirect()->route('showFormPenjualan')->with('error', 'Data Penjualan Detail gagal ditambahkan');
        }
        

        return redirect()->route('showFormPenjualanDetail',['noFaktur'=>$validatedRequest['noFaktur']])->with('success', 'Data Penjualan Detail Berhasil ditambahkan');
    }

   
}
