<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
  public function index()
  {
    return view('home');
  }
  public function about()
  {
    return view('about');
  }
  public function services()
  {
    return view('service');
  }

  public function schedule()
  {
    $jadwalBus = [
      ['id' => 'B01', 'rute' => 'Gedung Rektorat -  Fakultas Teknik', 'status' => 'Beroprasi'],
      ['id' => 'B02', 'rute' => 'Asrama Mahasiswa - Perpustakaan', 'status' => 'Beroprasi'],
      ['id' => 'B03', 'rute' => 'Stasiun MRT - Gerbang Utama', 'status' => 'Beroprasi'],
    ];
    return view('schedule', compact('jadwalBus'));
  }

  public function schedule_master()
  {
    $title = 'Jadwal Bus Kampus';
    $jadwalBus = [
      ['id' => 'B01', 'rute' => 'Gedung Rektorat - Fakultas Teknik', 'status' => 'Beroperasi'],
      ['id' => 'B02', 'rute' => 'Asrama Mahasiswa - Perpustakaan', 'status' => 'Maintenance'],
      ['id' => 'B03', 'rute' => 'Stasiun MRT - Gerbang Utama', 'status' => 'Beroperasi'],
    ];
    $content = view('schedule', compact('jadwalBus'))->render();

    return view('layouts.master', compact('title', 'content'));
  }
public function schedule2(){
    $title = "Jadwal Transportasi Kampus";

    $jadwalBus = [
        [
            'id' => 'B01',
            'rute' => 'Rektorat - Fakultas Teknik',
            'status' => 'Beroperasi',
            'fasilitas' => ['AC', 'WiFi', 'CCTV']
        ],
        [
            'id' => 'B02',
            'rute' => 'Asrama - Perpustakaan',
            'status' => 'Maintenance',
            'fasilitas' => ['AC']
        ],
        [
            'id' => 'B03',
            'rute' => 'Stasiun MRT - Gerbang Utama',
            'status' => 'Rusak',
            'fasilitas' => ['AC', 'Kursi Roda']
        ],
    ];

    return view('layouts.schedule2', compact('jadwalBus', 'title'));
}
}
