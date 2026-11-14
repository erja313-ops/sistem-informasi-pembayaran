<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TagihanGeneratorService;

class GenerateTagihanBulanan extends Command
{
    protected $signature = 'tagihan:generate {bulan} {tahun}';

    protected $description = 'Membuat tagihan bulanan untuk semua santri aktif';

    public function handle(
        TagihanGeneratorService $generator
    ): int {

        $bulan = (int) $this->argument('bulan');
        $tahun = (int) $this->argument('tahun');

        if ($bulan < 1 || $bulan > 12) {
            $this->error('Bulan harus antara 1 sampai 12.');

            return self::FAILURE;
        }

        $jumlah = $generator->generateUntukSemuaSantri(
            $bulan,
            $tahun
        );

        $this->info(
            "Berhasil membuat/memeriksa tagihan {$bulan}/{$tahun} untuk {$jumlah} santri."
        );

        return self::SUCCESS;
    }
}