<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\staff;
use App\Models\present;
use App\Models\Time;
use App\Models\Description;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Time::create([
            'in' => '08:00:00',
            'out' => '16:00:00',
            'shiff' => '0',
            'commant' => 'Normal'
        ]);
        Time::create([
            'in' => '08:00:00',
            'out' => '16:00:00',
            'shiff' => '1',
            'commant' => 'Satpam Pagi'
        ]);
        Time::create([
            'in' => '16:00:00',
            'out' => '08:00:00',
            'shiff' => '1',
            'commant' => 'Satpam Malam'
        ]);

        staff::create([
            'name' => 'DENI SLAMET SUPRAPTO',
            'pin' => '1',
            'position' => 'Penjaga Gedung Bid Perikanan',
            'id_times' => '2'
        ]);
        staff::create([
            'name' => 'BAMBANG SETIYAWAN',
            'pin' => '2',
            'position' => 'Penjaga Gedung BPP Lowokwaru',
            'id_times' => '2'
        ]);
        staff::create([
            'name' => 'AGUS CAHYANA',
            'pin' => '3',
            'position' => 'Petugas Kebersihan Gedung Dinas Pertanian',
            'id_times' => '1'
        ]);
        staff::create([
            'name' => 'IKA ADI PUTRA',
            'pin' => '4',
            'position' => 'Petugas Kebersihan Gedung Bid Perikanan',
            'id_times' => '1'
        ]);
        staff::create([
            'name' => 'MUJI SLAMET',
            'pin' => '5',
            'position' => 'Driver',
            'id_times' => '1'
        ]);
        staff::create([
            'name' => 'SUWANDI',
            'pin' => '6',
            'position' => 'Petugas Kebersihan Gedung BPP Sukun Klojen',
            'id_times' => '2'
        ]);
        staff::create([
            'name' => 'MUAMAR',
            'pin' => '7',
            'position' => 'Penjaga Gedung Dinas Pertanian',
            'id_times' => '1'
        ]);
        staff::create([
            'name' => 'SAMSUL ARIFIN',
            'pin' => '8',
            'position' => 'Petugas Kebersihan Gedung Bidang Peternakan dan Kesehatan Hewan',
            'id_times' => '1'
        ]);
        staff::create([
            'name' => 'SATRIA BANGKIT SANJAYA',
            'pin' => '9',
            'position' => 'Penjaga Gedung Bidang Peternakan dan Kesehatan Hewan',
            'id_times' => '1'
        ]);
        staff::create([
            'name' => 'KHOIRUN NISAK WAHYUNINGSIH, S.Pi',
            'pin' => '10',
            'position' => 'Administrasi di Sekretariat Dinas',
            'id_times' => '1'
        ]);
        staff::create([
            'name' => 'PURWANDOYO',
            'pin' => '11',
            'position' => 'Tenaga Teknis Pembinaan dan Pemanfaatan Pekarangan di Bid Penganekaragaan Konsumsi dan Keamanan Pangan',
            'id_times' => '1'
        ]);
        staff::create([
            'name' => 'RENY KURNIA INDARTI, SP',
            'pin' => '12',
            'position' => 'Tenaga Teknis Pembinaan dan Pemanfaatan Pekarangan di Bid Penganekaragaan Konsumsi dan Keamanan Pangan',
            'id_times' => '1'
        ]);
        staff::create([
            'name' => 'AHMAD MAFROHUL FAIZIN',
            'pin' => '13',
            'position' => 'Tenaga Teknis Perbenihan Ikan di BBI Tlogowaru',
            'id_times' => '1'
        ]);
        staff::create([
            'name' => 'THORIQIL HUDA',
            'pin' => '14',
            'position' => 'Tenaga Teknis Perbenihan Ikan di BBI Tlogowaru',
            'id_times' => '1'
        ]);
        staff::create([
            'name' => 'RISMA SUGANDA',
            'pin' => '15',
            'position' => 'Tenaga Teknis Perbenihan Ikan di BBI Tlogowaru',
            'id_times' => '1'
        ]);
        staff::create([
            'name' => 'YASEMAT',
            'pin' => '16',
            'position' => 'Tenaga Teknis Perbenihan Ikan di BBI Tlogowaru',
            'id_times' => '1'
        ]);
        staff::create([
            'name' => 'M. SYAIFUDIN ZUHRI',
            'pin' => '17',
            'position' => 'Tenaga Teknis Perbenihan Ikan di BBI Tlogowaru',
            'id_times' => '1'
        ]);
        staff::create([
            'name' => 'MUCHAMMAD ALI IMRON, S.M',
            'pin' => '18',
            'position' => 'Tenaga Administrasi di BII Tlogowaru',
            'id_times' => '1'
        ]);
        staff::create([
            'name' => 'GUNARDI',
            'pin' => '19',
            'position' => 'Petugas Kebersihan BBI Tlogowaru atau Wonokoyo',
            'id_times' => '1'
        ]);
        staff::create([
            'name' => 'MUHAMAD NYARI',
            'pin' => '20',
            'position' => 'Petugas Kebersihan BBI Tlogowaru atau Wonokoyo',
            'id_times' => '1'
        ]);
        staff::create([
            'name' => 'NUR CHOLID',
            'pin' => '21',
            'position' => 'Penjaga Gedung BBI Wonokoyo',
            'id_times' => '1'
        ]);
        staff::create([
            'name' => 'LELY SUTRISNO',
            'pin' => '22',
            'position' => 'Penjaga Gedung BBI Wonokoyo',
            'id_times' => '1'
        ]);
        staff::create([
            'name' => 'MARTONO',
            'pin' => '23',
            'position' => 'Penjaga Gedung BBI Tlogowaru',
            'id_times' => '1'
        ]);
        staff::create([
            'name' => 'SUJARWO',
            'pin' => '24',
            'position' => 'Penjaga Gedung BBI Tlogowaru',
            'id_times' => '1'
        ]);
        staff::create([
            'name' => 'MUHAMMAD SYAFII',
            'pin' => '25',
            'position' => 'Tenaga Admiistrasi di Swalayan Ikan',
            'id_times' => '1'
        ]);
        staff::create([
            'name' => 'Drh. ALDILIA FARRA HAPSARI',
            'pin' => '26',
            'position' => 'Tenaga Teknis Pengadaan Sarana dan Prasarana Teknologi Peternakan Tepat Guna Bid Peternakan dan Kesehatan Hewan',
            'id_times' => '1'
        ]);
        staff::create([
            'name' => 'FARADILA RACHMAWATI SUMARIADI, S. Pt',
            'pin' => '27',
            'position' => 'Tenaga Teknis Pengembangan Agribisnis Peternakan Bid Peternakan dan Kesehatan Hewan',
            'id_times' => '1'
        ]);
        staff::create([
            'name' => 'ROSY ADI CANDRA, S. Pi',
            'pin' => '28',
            'position' => 'Tenaga Teknis Pengembangan Teknologi Peternakan Tepat Guna Bid Peternakan dan Kesehatan Hewan',
            'id_times' => '1'
        ]);
        staff::create([
            'name' => 'PONIMAN',
            'pin' => '29',
            'position' => 'Penjaga Malam Gedung Kantor BPP Sukun Klojen',
            'id_times' => '1'
        ]);
        staff::create([
            'name' => 'DYANTA PUTRI PERMATASARI, S. Pi',
            'pin' => '30',
            'position' => 'Tenaga Administrasi di Swalayan Ikan',
            'id_times' => '1'
        ]);
        staff::create([
            'name' => 'Testing',
            'pin' => '3244',
            'position' => 'Tenaga Administrasi di Swalayan Ikan',
            'id_times' => '1'
        ]);
    }
}
