
{{-- ========================================================= --}}
<div id="nota-cetak">
    <div style="width: 100%; padding: 15px; font-family: 'Arial', sans-serif; color: #000; background: #fff; line-height: 1.2; max-width: 100%; box-sizing: border-box;">
        
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

        <div style="text-align: center; margin-bottom: 15px;">
            <h2 style="margin: 0; font-size: 13px; text-decoration: underline; letter-spacing: 1px; text-transform: uppercase;">Invoice Pembayaran</h2>
        </div>

        <table style="width: 100%; font-size: 10px; margin-bottom: 10px; border-collapse: collapse;">
            <tr>
                <td style="width: 65px; padding: 2px 0;">Cashier</td>
                <td style="width: 5px;">:</td>
                <td style="width: 270px;"><span id="print-cashier" style="font-weight: bold;">Sonia Novitasari</span></td>

                <td style="width: 75px; padding: 2px 0;">No. Invoice</td>
                <td style="width: 5px;">:</td>
                <td><span id="print-invoice" style="font-weight: bold;">-</span></td>
            </tr>
            <tr>
                <td style="padding: 2px 0;">Nama Pasien</td>
                <td>:</td>
                <td><span id="print-nama" style="font-weight: bold;">-</span></td>

                <td style="padding: 2px 0;">No. Kwitansi</td>
                <td>:</td>
                <td><span id="print-kwitansi" style="font-weight: bold;">-</span></td>
            </tr>
            <tr>
                <td style="padding: 2px 0;">Dokter</td>
                <td>:</td>
                <td><span id="print-dokter" style="font-weight: bold;">-</span></td>

                <td style="padding: 2px 0;">Metode Bayar</td>
                <td>:</td>
                <td><span id="print-metode-atas" style="font-weight: bold; text-transform: uppercase;">-</span></td>
            </tr>
            <tr>
                <td style="padding: 2px 0;">Tgl. Appt</td>
                <td>:</td>
                <td><span id="print-tanggal-appointment">-</span></td>

                <td style="padding: 2px 0;">Tgl. Bayar</td>
                <td>:</td>
                <td><span id="print-tanggal-bayar">{{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}</span></td>
            </tr>
        </table>

        <div style="border-top: 1px dashed #000; margin-bottom: 8px;"></div>

        <div style="text-align: center; margin-bottom: 8px;">
            <strong style="font-size: 12px;">Kwitansi</strong>
        </div>

        <table style="width: 100%; border-collapse: collapse; font-size: 10px; border: 1px solid #000;">
            <thead>
                <tr style="background-color: #f2f2f2; font-weight: bold; text-align: center; text-transform: uppercase;">
                    <td style="border: 1px solid #000; padding: 6px;">Jenis Perawatan / Tindakan</td>
                    <td style="border: 1px solid #000; padding: 6px; width: 60px;">No. Gigi</td>
                    <td style="border: 1px solid #000; padding: 6px; width: 35px;">Qty</td>
                    <td style="border: 1px solid #000; padding: 6px; width: 90px;">Harga Satuan</td>
                    <td style="border: 1px solid #000; padding: 6px; width: 80px;">Diskon</td>
                    <td style="border: 1px solid #000; padding: 6px; width: 90px;">Total</td>
                </tr>
            </thead>
            <tbody id="print-items-list">
                {{-- Diisi via JS --}}
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" style="border: 1px solid #000; padding: 6px; text-align: right;">Harga</td>
                    <td style="border: 1px solid #000; padding: 6px; text-align: right;" id="print-harga-awal">Rp0</td>
                </tr>
                <tr>
                    <td colspan="5" style="border: 1px solid #000; padding: 6px; text-align: right;">Diskon</td>
                    <td style="border: 1px solid #000; padding: 6px; text-align: right;" id="print-diskon">Rp0</td>
                </tr>
                <tr style="background-color: #f2f2f2;">
                    <td colspan="5" style="border: 1px solid #000; padding: 6px; text-align: right; font-weight: bold; text-transform: uppercase;">Total Tagihan</td>
                    <td style="border: 1px solid #000; padding: 6px; text-align: right; font-weight: bold; font-size: 11px; color: #3498db;" id="print-total">Rp0</td>
                </tr>
                <tr>
                    <td colspan="5" style="border: 1px solid #000; padding: 6px; text-align: right; font-weight: bold;" id="print-label-transfer">Dibayar (Transfer)</td>
                    <td style="border: 1px solid #000; padding: 6px; text-align: right; font-weight: bold;" id="print-dibayar">Rp0</td>
                </tr>
                <tr>
                    <td colspan="5" style="border: 1px solid #000; padding: 6px; text-align: right;">Kembali</td>
                    <td style="border: 1px solid #000; padding: 6px; text-align: right;" id="print-kembali">Rp0</td>
                </tr>
                <tr id="row-print-hutang" style="display: none; background-color: #fef2f2;">
                    <td colspan="5" style="border: 1px solid #000; padding: 6px; text-align: right; color: #b91c1c; font-weight: bold;">Kekurangan / Hutang</td>
                    <td style="border: 1px solid #000; padding: 6px; text-align: right; color: #b91c1c; font-weight: bold;" id="print-hutang">Rp0</td>
                </tr>
            </tfoot>
        </table>

        <div style="margin-top: 8px; font-size: 10px;">
            <span>Catatan : </span><span id="print-catatan">-</span>
        </div>

        <div style="margin-top: 15px; display: flex; justify-content: space-between; align-items: flex-end;">
            <div style="font-size: 8px; font-style: italic; color: #666; max-width: 60%;">
                * Terima kasih atas kunjungan Anda.<br>
                * Dokumen ini adalah bukti pembayaran sah Hanglekiu Dental Specialist.
            </div>
            <div style="text-align: center; width: 130px;">
                <p style="font-size: 10px; margin-bottom: 35px;">Petugas Kasir,</p>
                <p style="font-size: 10px; font-weight: bold; border-top: 1px solid #000; padding-top: 3px; margin: 0;">( Sonia Novitasari )</p>
            </div>
        </div>

        <div style="text-align: center; margin-top: 15px; border-top: 1px dashed #000; padding-top: 10px;">
            <p style="font-size: 10px; margin: 0;">Terima Kasih</p>
            <p style="font-size: 10px; margin: 0;">Semoga Lekas Sembuh</p>
        </div>

    </div>
</div>
{{-- ========================================================= --}}