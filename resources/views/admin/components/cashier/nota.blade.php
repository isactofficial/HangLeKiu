{{-- AREA KHUSUS CETAK NOTA (Sembunyi di layar, muncul saat di-print) --}}
<div id="nota-cetak" class="hidden">
    <div style="width: 100%; padding: 15px; font-family: 'Arial', sans-serif; color: #000; background: #fff; line-height: 1.2; max-width: 100%; box-sizing: border-box;">
        
        <!-- HEADER -->
        <table style="width: 100%; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 15px;">
            <tr>
                <td style="width: 70px;">
                    <img src="{{ asset('images/logo-hds.png') }}" alt="Logo HDS" style="width: 65px; height: auto;">
                </td>
                <td style="padding-left: 15px;">
                    <h1 style="margin: 0; font-size: 15px; font-weight: bold; text-transform: uppercase; color: #3498db;">HANGLEKIU DENTAL SPECIALIST</h1>
                    <p style="margin: 2px 0; font-size: 9px; line-height: 1.4;">
                        8, Jl. Hang Lekiu V No.8, RT.6/RW.4, Gunung, Kec. Kby. Baru,<br>
                        Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12120
                    </p>
                    <p style="margin: 2px 0; font-size: 9px; font-weight: bold;">Telepon: 0852-1188-8621</p>
                </td>
            </tr>
        </table>

        <!-- JUDUL -->
        <div style="text-align: center; margin-bottom: 15px;">
            <h2 style="margin: 0; font-size: 13px; text-decoration: underline; letter-spacing: 1px; text-transform: uppercase;">Invoice Pembayaran</h2>
        </div>

        <!-- INFO PASIEN & INVOICE -->
        <table style="width: 100%; font-size: 10px; margin-bottom: 10px;">
            <tr>
                <td style="width: 90px; padding: 2px 0;">Cashier</td>
                <td>: <span id="print-cashier" style="font-weight: bold;">Sonia Novitasari</span></td>
                <td style="width: 90px; text-align: right; padding: 2px 0;">No. Invoice</td>
                <td style="width: 120px;">: <span id="print-invoice" style="font-weight: bold;">INV000322</span></td>
            </tr>
            <tr>
                <td style="padding: 2px 0;">Nama Pasien</td>
                <td>: <span id="print-nama" style="font-weight: bold;">Rafif Putra Utama (Laki - Laki 18 tahun 249 hari)</span></td>
                <td style="text-align: right; padding: 2px 0;">No. Kwitansi</td>
                <td style="width: 120px;">: <span id="print-kwitansi" style="font-weight: bold;">KWI00000298</span></td>
            </tr>
            <tr>
                <td style="padding: 2px 0;">Tgl. Appointment</td>
                <td>: <span id="print-tanggal-appointment">30-03-2026 13:00</span></td>
                <td style="text-align: right; padding: 2px 0;">Tgl. Bayar</td>
                <td style="width: 120px;">: <span id="print-tanggal-bayar">{{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}</span></td>
            </tr>
        </table>

        <!-- GARIS PEMBATAS -->
        <div style="border-top: 1px dashed #000; margin-bottom: 8px;"></div>

        <!-- JUDUL KWITANSI -->
        <div style="text-align: center; margin-bottom: 8px;">
            <strong style="font-size: 12px;">Kwitansi</strong>
        </div>

        <!-- TABEL TINDAKAN -->
        <table style="width: 100%; border-collapse: collapse; font-size: 10px; border: 1px solid #000;">
            <thead>
                <tr style="background-color: #f2f2f2; font-weight: bold; text-align: center; text-transform: uppercase;">
                    <td style="border: 1px solid #000; padding: 6px;">Jenis Perawatan / Tindakan</td>
                    <td style="border: 1px solid #000; padding: 6px; width: 80px;">No. Gigi</td>
                    <td style="border: 1px solid #000; padding: 6px; width: 35px;">Qty</td>
                    <td style="border: 1px solid #000; padding: 6px; width: 90px;">Harga Satuan</td>
                    <td style="border: 1px solid #000; padding: 6px; width: 80px;">Diskon</td>
                    <td style="border: 1px solid #000; padding: 6px; width: 90px;">Total</td>
                </tr>
            </thead>
            <tbody id="print-items-list">
                {{-- Data ini akan diisi oleh JavaScript saat proses bayar --}}
                {{-- Jika kamu ingin memunculkan data bawaan (dummy) untuk tes print, biarkan tag <tr> di bawah ini --}}
                <tr>
                    <td style="border: 1px solid #000; padding: 6px; vertical-align: middle;">
                        Restorasi Komposit Posterior Kecil<br>
                        <span style="color: #888; font-size: 9px;">Disc: 100%</span>
                    </td>
                    <td style="border: 1px solid #000; padding: 6px; text-align: center; vertical-align: middle;">11, 12, 13</td>
                    <td style="border: 1px solid #000; padding: 6px; text-align: center; vertical-align: middle;">x3</td>
                    <td style="border: 1px solid #000; padding: 6px; text-align: right; vertical-align: middle;">Rp600.000</td>
                    <td style="border: 1px solid #000; padding: 6px; text-align: right; vertical-align: middle;">Rp600.000</td>
                    <td style="border: 1px solid #000; padding: 6px; text-align: right; font-weight: bold; vertical-align: middle;">Rp0</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" style="border: 1px solid #000; padding: 6px; text-align: right;">Harga</td>
                    <td style="border: 1px solid #000; padding: 6px; text-align: right;" id="print-harga-awal">Rp0</td>
                </tr>
                <tr>
                    <td colspan="5" style="border: 1px solid #000; padding: 6px; text-align: right;">Pembulatan</td>
                    <td style="border: 1px solid #000; padding: 6px; text-align: right;">Rp0</td>
                </tr>
                <tr>
                    <td colspan="5" style="border: 1px solid #000; padding: 6px; text-align: right;">Diskon</td>
                    <td style="border: 1px solid #000; padding: 6px; text-align: right;" id="print-diskon">Rp0</td>
                </tr>
                <tr style="background-color: #f2f2f2;">
                    <td colspan="5" style="border: 1px solid #000; padding: 6px; text-align: right; font-weight: bold; text-transform: uppercase;">Total</td>
                    <td style="border: 1px solid #000; padding: 6px; text-align: right; font-weight: bold; font-size: 11px; color: #3498db;" id="print-total">Rp0</td>
                </tr>
                <tr>
                    <td colspan="5" style="border: 1px solid #000; padding: 6px; text-align: right;" id="print-label-transfer">Transfer</td>
                    <td style="border: 1px solid #000; padding: 6px; text-align: right;" id="print-transfer">Rp0</td>
                </tr>
                <tr>
                    <td colspan="5" style="border: 1px solid #000; padding: 6px; text-align: right;">Kembali</td>
                    <td style="border: 1px solid #000; padding: 6px; text-align: right;">Rp0</td>
                </tr>
            </tfoot>
        </table>

        <!-- CATATAN -->
        <div style="margin-top: 8px; font-size: 10px;">
            <span>Catatan : </span><span id="print-catatan">-</span>
        </div>

        <!-- FOOTER -->
        <div style="margin-top: 15px; display: flex; justify-content: space-between; align-items: flex-end;">
            <div style="font-size: 8px; font-style: italic; color: #666; max-width: 60%;">
                * Terima kasih atas kunjungan Anda.<br>
                * Dokumen ini adalah bukti pembayaran sah Hanglekiu Dental Specialist.
            </div>
            <div style="text-align: center; width: 130px;">
                <p style="font-size: 10px; margin-bottom: 35px;">Petugas Kasir,</p>
                <p style="font-size: 10px; font-weight: bold; border-top: 1px solid #000; padding-top: 3px; margin: 0;">( Admin Kasir )</p>
            </div>
        </div>

        <!-- TERIMA KASIH -->
        <div style="text-align: center; margin-top: 15px; border-top: 1px dashed #000; padding-top: 10px;">
            <p style="font-size: 10px; margin: 0;">Terima Kasih</p>
            <p style="font-size: 10px; margin: 0;">Semoga Lekas Sembuh</p>
        </div>

    </div>
</div>