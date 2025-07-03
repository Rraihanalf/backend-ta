<?php

namespace Database\Seeders;

use App\Models\CalonSiswa;
use App\Models\Guru;
use App\Models\GuruPengampu;
use App\Models\JadwalPelajaran;
use App\Models\Mapel;
use App\Models\RuangKelas;
use App\Models\Siswa;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name'     => 'Admin Satu',
            'email'    => 'admin1@example.com',
            'role'     => 'admin',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name'     => 'Guest Satu',
            'email'    => 'guest1@example.com',
            'role'     => 'guru',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name'     => 'Guest Dua',
            'email'    => 'guest2@example.com',
            'role'     => 'wali',
            'password' => Hash::make('password123'),
        ]);

        $agamaList = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu'];
        $statusList = ['Accepted', 'Waiting', 'Rejected'];

        for ($i = 1; $i <= 20; $i++) {
            CalonSiswa::create([
                'nama_lengkap' => fake()->name(),
                'jenis_kelamin' => fake()->randomElement(['Laki-Laki', 'Perempuan']),
                'tempat_lahir' => fake()->city(),
                'tanggal_lahir' => fake()->date('Y-m-d', '-10 years'),
                'alamat' => fake()->address(),
                'nama_ortu' => fake()->name(),
                'email_ortu' => fake()->email(),
                'no_handphone' => fake()->phoneNumber(),
                'kartu_keluarga' => null, 
                'akta_lahir' => null, 
                'pas_foto' => null, 
                'Status' => fake()->randomElement($statusList),
                'user_id' => null, 
            ]);
        }

        $golDarahList = ['A', 'B', 'AB', 'O'];
        $statusNikahList = ['Menikah', 'Belum Menikah', 'Cerai'];

        for ($i = 1; $i <= 10; $i++) {
            Guru::create([
                'nama_lengkap' => fake()->name(),
                'nip' => '1985' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'jenis_kelamin' => fake()->randomElement(['Laki-Laki', 'Perempuan']),
                'agama' => fake()->randomElement($agamaList),
                'tempat_lahir' => fake()->city(),
                'tanggal_lahir' => fake()->date('Y-m-d', '-25 years'),
                'alamat' => fake()->address(),
                'golongan_darah' => fake()->randomElement($golDarahList),
                'status_nikah' => fake()->randomElement($statusNikahList),
                'no_rekening' => fake()->bankAccountNumber(),
                'nama_bank' => fake()->randomElement(['BNI', 'BCA', 'Mandiri', 'BRI']),
                'transportasi' => fake()->randomElement(['Motor', 'Mobil', 'Jalan Kaki']),
                'no_handphone' => fake()->phoneNumber(),
                'user_id' => null 
            ]);
        }

        for ($i = 1; $i <= 20; $i++) {
            Siswa::create([
                'nama_lengkap' => fake()->name(),
                'nis' => '2024' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'jenis_kelamin' => fake()->randomElement(['Laki-Laki', 'Perempuan']),
                'agama' => fake()->randomElement($agamaList),
                'tempat_lahir' => fake()->city(),
                'tanggal_lahir' => fake()->date('Y-m-d', '-12 years'),
                'alamat' => fake()->address(),
                'nama_ayah' => fake()->name('male'),
                'nama_ibu' => fake()->name('female'),
                'rt' => fake()->numberBetween(1, 10),
                'rw' => fake()->numberBetween(1, 10),
                'kelurahan' => fake()->streetName(),
                'kecamatan' => fake()->city(),
                'kota' => fake()->city(),
                'provinsi' => fake()->state(),
                'kode_pos' => fake()->postcode(),
                'no_handphone' => fake()->phoneNumber(),
                'user_id' => null, 
                'kelas_id' => null 
            ]);
        }

        $tahunAjar = '2024/2025';

        $kelasList = [
            '1A', '1B',
            '2A', '2B',
            '3A', '3B',
            '4A', '4B',
            '5A', '5B',
        ];

        foreach ($kelasList as $kelas) {
            RuangKelas::create([
                'tahun_ajar' => $tahunAjar,
                'nama_kelas' => $kelas,
                'guru_id'    => null
            ]);
        }

        $mapels = [
            'Matematika',
            'Bahasa Indonesia',
            'Ilmu Pengetahuan Alam',
            'Pendidikan Jasmani',
            'Bahasa Inggris',
        ];

        foreach ($mapels as $mapel) {
            Mapel::create([
                'nama_mapel' => $mapel,
                'kelas' => 1,
                'tahun_ajar' => $tahunAjar
            ]);
        }

        $tahunAjar = '2024/2025';
        $gurus = Guru::all();
        $mapels = Mapel::all();

        foreach ($gurus as $guru) {
            $mapelPilihan = $mapels->random(rand(1, 2));

            foreach ($mapelPilihan as $mapel) {
                GuruPengampu::create([
                    'tahun_ajar' => $tahunAjar,
                    'guru_id'    => $guru->id,
                    'mapel_id'   => $mapel->id,
                ]);
            }
        }


        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $jamList = [
            ['08:00', '08:40'],
            ['08:40', '09:20'],
            ['09:20', '10:00'],
            ['10:15', '10:55'],
            ['10:55', '11:35'],
            ['11:35', '12:15'],
            ['13:00', '13:40'],
            ['13:40', '14:20'],
            ['14:20', '15:00'],
            ['15:00', '15:40'],
        ];

        $kelasList = RuangKelas::all();
        $mapelList = Mapel::all();
        $guruList = Guru::all();

        foreach ($kelasList as $kelas) {
            foreach ($hariList as $hari) {
                // Ambil 2–3 jam acak per hari
                $jadwalHarian = Arr::random($jamList, rand(2, 3));

                foreach ($jadwalHarian as $jam) {
                    $guru = $guruList->random();
                    $mapel = $mapelList->random();

                    JadwalPelajaran::create([
                        'kelas_id'    => $kelas->id,
                        'mapel_id'    => $mapel->id,
                        'guru_id'     => $guru->id,
                        'hari'        => $hari,
                        'jam_mulai'   => $jam[0],
                        'jam_selesai' => $jam[1],
                    ]);
                }
            }
        }
        
        $faker = Faker::create('id_ID');
        
        $semesters = ['Ganjil', 'Genap'];
        $tahunAjar = ['2023/2024', '2024/2025'];
        
        $siswaIds = DB::table('siswas')->pluck('id')->toArray();
        $mapelIds = DB::table('mapels')->pluck('id')->toArray();
        
        if (count($siswaIds) < 20) {
            $this->command->error('Tidak cukup data siswa. Pastikan ada minimal 20 siswa di tabel siswas.');
            return;
        }
        
        if (count($mapelIds) < 5) {
            $this->command->error('Tidak cukup data mapel. Pastikan ada minimal 5 mapel di tabel mapels.');
            return;
        }
        
        $nilaiData = [];
        
        $selectedSiswaIds = array_slice($siswaIds, 0, 20);
        
        foreach ($selectedSiswaIds as $siswaId) {
            $selectedMapelIds = $faker->randomElements($mapelIds, 5);
            
            foreach ($selectedMapelIds as $mapelId) {
                $semester = $faker->randomElement($semesters);
                $tahun = $faker->randomElement($tahunAjar);
                
                $nilaiData[] = [
                    'mapel_id' => $mapelId,
                    'siswa_id' => $siswaId,
                    'nilai' => $faker->numberBetween(60, 100), // Nilai antara 60-100
                    'semester' => $semester,
                    'tahun_ajar' => $tahun,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        DB::table('nilai_siswas')->insert($nilaiData);        


        $faker = Faker::create('id_ID');
        
        $statusAbsensi = ['Hadir', 'Izin', 'Sakit', 'Alfa'];
        
        $jadwalIds = [1, 2];
        
        $siswaIds = DB::table('siswas')->pluck('id')->toArray();
        
        if (count($siswaIds) < 20) {
            $this->command->error('Tidak cukup data siswa. Pastikan ada minimal 20 siswa di tabel siswas.');
            return;
        }
        
        $existingJadwalIds = DB::table('jadwal_pelajarans')->whereIn('id', $jadwalIds)->pluck('id')->toArray();
        if (count($existingJadwalIds) < 2) {
            $this->command->error('Jadwal dengan ID 1 dan/atau 2 tidak ditemukan di tabel jadwal_pelajarans.');
            return;
        }
        
        $absensiData = [];
        
        $selectedSiswaIds = array_slice($siswaIds, 0, 20);
        
        foreach ($selectedSiswaIds as $siswaId) {
            foreach ($jadwalIds as $jadwalId) {
                $absensiData[] = [
                    'jadwal_id' => $jadwalId,
                    'siswa_id' => $siswaId,
                    'tanggal' => fake()->date('Y-m-d'),
                    'status' => $faker->randomElement($statusAbsensi),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        // Insert data dalam batch untuk efisiensi
        DB::table('absensis')->insert($absensiData);
    }
}
