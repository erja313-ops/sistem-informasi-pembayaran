<?php

namespace App\Services;

use App\Models\Pembayaran;
use App\Models\DetailTagihan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PembayaranService
{
    /**
     * Membuat pembayaran dan mengalokasikan nominal
     * ke beberapa detail tagihan.
     */
    public function buatPembayaran(
        array $detailPembayaran,
        string $metode = 'offline',
        ?string $buktiPembayaran = null
    ): Pembayaran {
        return DB::transaction(function () use (
            $detailPembayaran,
            $metode,
            $buktiPembayaran
        ) {

            /*
             * Hitung total pembayaran.
             */
            $total = collect($detailPembayaran)
                ->sum('nominal');

            if ($total <= 0) {
                throw new \Exception(
                    'Nominal pembayaran harus lebih dari 0.'
                );
            }

            /*
             * Buat kode transaksi.
             */
            $kodeTransaksi =
                'TRX-' .
                now()->format('YmdHis') .
                '-' .
                strtoupper(Str::random(5));

            /*
             * Pembayaran offline langsung diterima.
             * Transfer menunggu verifikasi admin.
             */
            $status = $metode === 'offline'
                ? 'diterima'
                : 'menunggu_verifikasi';

            /*
             * Buat transaksi pembayaran.
             */
            $pembayaran = Pembayaran::create([
                'kode_transaksi' => $kodeTransaksi,
                'metode' => $metode,
                'nominal_tagihan' => $total,
                'total_transfer' => $total,
                'tanggal_bayar' => Carbon::now(),
                'bukti_pembayaran' => $buktiPembayaran,
                'status' => $status,
            ]);

            /*
             * Simpan detail pembayaran.
             */
            foreach ($detailPembayaran as $item) {

                $detail = DetailTagihan::findOrFail(
                    $item['detail_tagihan_id']
                );

                $nominal = (float) $item['nominal'];

                /*
                 * Hitung total yang sudah dibayarkan
                 * pada detail tagihan tersebut.
                 */
                $sudahDibayar = $detail->detailPembayaran()
                    ->whereHas('pembayaran', function ($query) {
                        $query->where('status', 'diterima');
                    })
                    ->sum('nominal');

                $sisa = (float) $detail->nominal - $sudahDibayar;

                /*
                 * Jangan sampai membayar melebihi sisa tagihan.
                 */
                if ($nominal > $sisa) {
                    throw new \Exception(
                        "Nominal pembayaran untuk {$detail->jenisTagihan->nama} " .
                        "melebihi sisa tagihan."
                    );
                }

                $pembayaran->detailPembayaran()->create([
                    'detail_tagihan_id' => $detail->id,
                    'nominal' => $nominal,
                ]);
            }

            /*
             * Jika pembayaran offline langsung diterima,
             * update status detail tagihan.
             */
            if ($status === 'diterima') {
                $this->perbaruiStatusDetail(
                    $pembayaran
                );
            }

            return $pembayaran->load(
                'detailPembayaran.detailTagihan.jenisTagihan'
            );
        });
    }

    /**
     * Memperbarui status detail tagihan setelah pembayaran diterima.
     */
    public function perbaruiStatusDetail(
        Pembayaran $pembayaran
    ): void {
        foreach ($pembayaran->detailPembayaran as $detailPembayaran) {

            $detail = $detailPembayaran->detailTagihan;

            $totalDibayar = $detail->detailPembayaran()
                ->whereHas('pembayaran', function ($query) {
                    $query->where('status', 'diterima');
                })
                ->sum('nominal');

            if ($totalDibayar >= $detail->nominal) {

                $detail->update([
                    'status' => 'lunas',
                ]);

            } elseif ($totalDibayar > 0) {

                $detail->update([
                    'status' => 'sebagian',
                ]);

            } else {

                $detail->update([
                    'status' => 'belum_bayar',
                ]);
            }

            /*
             * Setelah status detail diperbarui,
             * cek status tagihan induknya.
             */
            $this->perbaruiStatusTagihan(
                $detail->tagihan
            );
        }
    }

    /**
     * Memperbarui status tagihan utama.
     */
    public function perbaruiStatusTagihan($tagihan): void
    {
        $jumlahDetail = $tagihan->detailTagihan()->count();

        $jumlahLunas = $tagihan->detailTagihan()
            ->where('status', 'lunas')
            ->count();

        $jumlahSebagian = $tagihan->detailTagihan()
            ->where('status', 'sebagian')
            ->count();

        if ($jumlahDetail > 0 && $jumlahLunas === $jumlahDetail) {

            $tagihan->update([
                'status' => 'lunas',
            ]);

        } elseif ($jumlahLunas > 0 || $jumlahSebagian > 0) {

            $tagihan->update([
                'status' => 'sebagian',
            ]);

        } else {

            $tagihan->update([
                'status' => 'belum_bayar',
            ]);
        }
    }
}