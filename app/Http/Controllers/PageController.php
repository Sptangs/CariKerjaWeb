<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Ini buat tempat controller kayka nyimoen penghubung route dan view pokoe ngono
class PageController extends Controller
{
    public function index() {
        return view('home');
    }

    public function about() {
        return view('about');
    }

    public function service() {
        return view('service');
    }

    // 4311
    public function pendaftar() {
    // 1. Membuat data dummy array multidimensi
    $paraPendaftar = [
        ['id' => 'P01', 'nama' => 'Adit', 'status' => 'Sudah Bekerja'],
        ['id' => 'P02', 'nama' => 'Budit', 'status' => 'Sudah Bekerja'],
        ['id' => 'P03', 'nama' => 'Cudit', 'status' => 'Belum Bekerja'],
    ];

    // 2. Mengirim data ke View 'schedule.blade.php' menggunakan compact
    return view('pendaftar', compact('paraPendaftar'));
    }

    public function pendaftar_master()
    {
        $title = 'Daftar Pendaftar';
        $paraPendaftar = [
            ['id' => 'P01', 'nama' => 'Adit', 'status' => 'Sudah Bekerja'],
            ['id' => 'P02', 'nama' => 'Budit', 'status' => 'Sudah Bekerja'],
            ['id' => 'P03', 'nama' => 'Cudit', 'status' => 'Belum Bekerja'],
        ];
        $content = view('pendaftar', compact('paraPendaftar'))->render();

        return view('layouts.master', compact('title', 'content'));
    }

    public function pendaftar2(){
    $title = "Daftar Pendaftar 2";

    // Array multidimensi dengan nested array (fasilitas)
    $paraPendaftar2 = [
        [
            'id' => 'P01',
            'nama' => 'Adit',
            'status' => 'Bekerja',
            'keahlian' => ['Service', 'Oprek', 'Programming']
        ],
        [
            'id' => 'P02',
            'nama' => 'Budit',
            'status' => 'Bekerja',
            'keahlian' => ['Design', 'Marketing']
        ],
        [
            'id' => 'P03',
            'nama' => 'Cudit',
            'status' => 'Belum Bekerja',
            'keahlian' => ['Sales', 'Support']
        ],
    ];

    // Mengirim multiple data ke View
    return view('pendaftar2', compact('paraPendaftar2', 'title'));
}
}