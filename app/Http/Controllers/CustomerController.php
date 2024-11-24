<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function showCustomer(){
        $customers = DB::table('t_customer')->get();
        return view('masterCustomer', ['customers'=> $customers]);
    }

    public function addCustomer(Request $request){
        $validatedRequest = $request->validate([
            'kodeCustomer'=> 'required|max:4',
            'namaCustomer'=> 'required|max:40'
        ]);

        try{
            DB::table('t_customer')->insert([
                // nama kolom -> name input
                'Kode_Customer' => $validatedRequest['kodeCustomer'],
                'Nama_Customer' => $validatedRequest['namaCustomer']
            ]);
        }
        catch(\Exception $er){
            \Log::error($er->getMessage());
            return redirect()->route('showCustomer')->with('error', 'Data Customer gagal ditambahkan');
        }
        

        return redirect()->route('showCustomer')->with('success', 'Data Customer Berhasil ditambahkan');
    }

    public function updateCustomer(Request $request){
        $validatedRequest = $request->validate([
            'kodeCustomer'=> 'required|max:4',
            'namaCustomer'=> 'required|max:40'
        ]);

        try{
            DB::table('t_customer')->where('Kode_Customer', $validatedRequest['kodeCustomer'])->update([
                // nama kolom -> name input
                'Nama_Customer' => $validatedRequest['namaCustomer']
            ]);
        }
        catch(\Exception $er){
            \Log::error($er->getMessage());
            return redirect()->route('showCustomer')->with('error', 'Data Customer gagal diubah');
        }
        

        return redirect()->route('showCustomer')->with('success', 'Data Customer Berhasil diubah');
    }

    public function deleteCustomer(Request $request){
        $validatedRequest = $request->validate([
            'kodeCustomer'=> 'required|max:4'
        ]);

        try{
            DB::table('t_customer')->where('Kode_Customer', $validatedRequest['kodeCustomer'])->delete();
        }
        catch(\Exception $er){
            \Log::error($er->getMessage());
            return redirect()->route('showCustomer')->with('error', 'Data Customer gagal dihapus');
        }
        

        return redirect()->route('showCustomer')->with('success', 'Data Customer Berhasil dihapus');
    }
}
