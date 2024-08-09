<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penandatangan;
use Illuminate\Support\Facades\Storage;

class PenandatanganController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'perusahaan_id' => 'required|exists:perusahaan,id',
            'nama_penandatangan' => 'required|string|max:255',
            'signature' => 'required|string',
        ]);
    
        $penandatangan = new Penandatangan();
        $penandatangan->perusahaan_id = $request->perusahaan_id;
        $penandatangan->nama_penandatangan = $request->nama_penandatangan;
    
        // Extract base64 data and convert it to a file
        $signature = $request->input('signature');
        $signature = str_replace('data:image/png;base64,', '', $signature);
        $signature = str_replace(' ', '+', $signature);
        $signatureData = base64_decode($signature);
    
        // Generate a filename for the signature image
        $fileName = 'signature_' . time() . '.png';
    
        // Save the file in the public directory
        $filePath = public_path('signatures/' . $fileName);
        file_put_contents($filePath, $signatureData);
    
        // Save the file name to the database
        $penandatangan->signature = $fileName;
    
        $penandatangan->save();
    
        return redirect()->route('home')->with('success', 'Penandatangan berhasil ditambahkan.');
    }
    
}
