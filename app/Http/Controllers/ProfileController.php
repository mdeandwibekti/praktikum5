<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function about()
    {
        $data = [
            'nama' => 'M Dean Dwi Bekti',
            'nim' => '20230140042',
            'prodi' => 'Teknologi Informasi',
            'hobi' => 'Bulutangkis',
        ];
        return view('about', $data);
    }
}