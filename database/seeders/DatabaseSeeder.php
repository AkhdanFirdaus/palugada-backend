<?php

namespace Database\Seeders;

use App\Models\Narasumber;
use App\Models\PendaftarWebinar;
use App\Models\User;
use App\Models\Webinar;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $dataPendaftar = ["Akhdan", "Audi", "Nita", "Raihan", "Shinta", "Ghilba", "Irfan", "Ilham", "Winda"];
        foreach ($dataPendaftar as $data) {
            $pendaftar = new User();
            $pendaftar->name = $data;
            $pendaftar->email = strtolower($data . "@email.com");
            $pendaftar->password = Hash::make("password");
            $pendaftar->nomor_telp = "1234567890";
            $pendaftar->asal = "Bandung";
            $pendaftar->role = 3;
            $pendaftar->save();
        }

        $dataPenyelenggara = ["Kemendikbud", "RS. Bina Medika", "MNC asset management"];
        foreach ($dataPenyelenggara as $data) {
            $penyelenggara = new User();
            $penyelenggara->name = $data;
            $penyelenggara->email = strtolower($data . "@email.com");
            $penyelenggara->password = Hash::make("password");
            $penyelenggara->nomor_telp = "0987654321";
            $penyelenggara->asal = "Bandung";
            $penyelenggara->role = 1;
            $penyelenggara->save();
        }

        $dataNarasumber = [
            "Prof. Ir. Nizam, M.Sc., DIC., Ph.D.",
            "Prof. Dr. Sutrisna Wibawa, M.Pd",
            "dr. Agus Sugiono, Sp. A, M. Kes",
            "Sandy Afriliando Putra"
        ];
        foreach ($dataNarasumber as $index => $data) {
            $narasumber = new User();
            $narasumber->name = $data;
            $narasumber->email = strtolower("narasumber" . $index . "@email.com");
            $narasumber->password = Hash::make("password");
            $narasumber->nomor_telp = "0987654321";
            $narasumber->asal = "Bandung";
            $narasumber->role = 3;
            $narasumber->save();
            $index++;
        }


        $webinar1 = new Webinar();
        $webinar1->nama = "Webinar 5.0 KIP Kuliah";
        $webinar1->deskripsi = "Webinar ini membahas perihal KIP (Kartu Indonesia Pintar) yang merupakan salah satu program kerja dari Kemendikbud untuk Indonesia Emas 2045";
        $webinar1->kuota = 9;
        $webinar1->tanggal = "2021-07-06";
        $webinar1->jam_mulai = "09:00:00";
        $webinar1->jam_selesai = "12:00:00";
        $webinar1->penyelenggara_id = 10;
        $webinar1->link = "http://www.google.com";
        $webinar1->save();

        $webinar2 = new Webinar();
        $webinar2->nama = "Sistem Imun dan Upaya Peningkatan Imunita";
        $webinar2->deskripsi = "Webinar ini merupakan bagaimana cara terhindar dari berbagai penyakit dengan upaya meningkatan imunitas seseorang";
        $webinar2->kuota = 14;
        $webinar2->tanggal = "2021-07-07";
        $webinar2->jam_mulai = "09:00:00";
        $webinar2->jam_selesai = "12:00:00";
        $webinar2->penyelenggara_id = 11;
        $webinar2->link = "http://www.google.com";
        $webinar2->save();

        $webinar3 = new Webinar();
        $webinar3->nama = "Obsesi Saat Reses";
        $webinar3->deskripsi = "Webinar ini merupakan bagaimana menciptakan obsesi baik saat resesi maupun keadaan apapun";
        $webinar3->kuota = 20;
        $webinar3->tanggal = "2021-07-10";
        $webinar3->jam_mulai = "09:00:00";
        $webinar3->jam_selesai = "12:00:00";
        $webinar3->penyelenggara_id = 12;
        $webinar3->link = "http://www.google.com";
        $webinar3->save();

        $narasumber1Webinar1 = new Narasumber();
        $narasumber1Webinar1->user_id = 13;
        $narasumber1Webinar1->webinar_id = 1;
        $narasumber1Webinar1->save();

        $narasumber2Webinar1 = new Narasumber();
        $narasumber2Webinar1->user_id = 14;
        $narasumber2Webinar1->webinar_id = 1;
        $narasumber2Webinar1->save();

        $narasumberWebinar2 = new Narasumber();
        $narasumberWebinar2->user_id = 15;
        $narasumberWebinar2->webinar_id = 2;
        $narasumberWebinar2->save();

        $narasumberWebinar3 = new Narasumber();
        $narasumberWebinar3->user_id = 16;
        $narasumberWebinar3->webinar_id = 3;
        $narasumberWebinar3->save();

        for ($i = 1; $i <= 9; $i++) {
            $pendaftarWebinar1 = new PendaftarWebinar();
            $pendaftarWebinar1->user_id = $i;
            $pendaftarWebinar1->webinar_id = 1;
            $pendaftarWebinar1->save();
        }

        for ($i = 1; $i <= 4; $i++) {
            $pendaftarWebinar2 = new PendaftarWebinar();
            $pendaftarWebinar2->user_id = $i;
            $pendaftarWebinar2->webinar_id = 2;
            $pendaftarWebinar2->save();
        }

        for ($i = 4; $i <= 9; $i++) {
            $pendaftarWebinar3 = new PendaftarWebinar();
            $pendaftarWebinar3->user_id = $i;
            $pendaftarWebinar3->webinar_id = 3;
            $pendaftarWebinar3->save();
        }

        // \App\Models\User::factory(10)->create();
    }
}
