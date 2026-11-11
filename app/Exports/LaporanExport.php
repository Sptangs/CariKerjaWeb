<?php

namespace App\Exports;

use App\Models\Application;
use Illuminate\Support\Enumerable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanExport implements FromCollection, WithHeadings
{
    protected $companyId;

    public function __construct($companyId)
    {
        $this->companyId = $companyId;
    }

    public function collection(): Enumerable
    {
        return Application::with(['user', 'job'])
            ->whereHas('job', function ($query) {
                $query->where('company_id', $this->companyId);
            })
            ->get()
            ->map(function ($application) {
                return [
                    'nama_pelamar' => $application->user->name,
                    'email' => $application->user->email,
                    'posisi' => $application->job->title,
                    'lokasi' => $application->job->location,
                    'status' => $application->status,
                    'tanggal_melamar' => $application->created_at->format('d-m-Y'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nama Pelamar',
            'Email',
            'Posisi Dilamar',
            'Lokasi',
            'Status',
            'Tanggal Melamar',
        ];
    }
}
