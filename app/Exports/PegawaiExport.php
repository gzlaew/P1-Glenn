<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PegawaiExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return User::select('name', 'email', 'role', 'phone_number', 'birth_date', 'address')->get();
    }

    public function headings(): array
    {
        return ['Nama', 'Email', 'Role', 'No HP', 'Tanggal Lahir', 'Alamat'];
    }
}
