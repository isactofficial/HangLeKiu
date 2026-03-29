<div id="nota-cetak" class="hidden">
    <div style="width: 100%; padding: 15px; font-family: 'Arial', sans-serif; color: #000; background: #fff; line-height: 1.2;">
        
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

        <!-- INFO NOTA -->
        <div style="text-align: center; margin-bottom: 15px;">
            <h2 style="margin: 0; font-size: 13px; text-decoration: underline; letter-spacing: 1px; text-transform: uppercase;">Invoice Pembayaran</h2>
        </div>

        <table style="width: 100%; font-size: 10px; margin-bottom: 10px;">
            <tr>
                <td style="width: 80px; padding: 2px 0;">Nama Pasien</td>
                <td>: <span id="print-nama" style="font-weight: bold;">-</span></td>
                <td style="width: 80px; text-align: right; padding: 2px 0;">No. Invoice</td>
                <td style="width: 110px;">: <span id="print-invoice" style="font-weight: bold;">INV000316</span></td>
            </tr>
            <tr>
                <td style="padding: 2px 0;">Tanggal Periksa</td>
                <td>: <span id="print-tanggal">{{ date('d F Y') }}</span></td>
                <td style="text-align: right; padding: 2px 0;">Metode Bayar</td>
                <td>: <span id="print-metode">Langsung</span></td>
            </tr>
        </table>

        <!-- TABEL TINDAKAN (Per Prosedur) -->
        <table style="width: 100%; border-collapse: collapse; font-size: 10px; border: 1px solid #000;">
            <thead>
                <tr style="background-color: #f2f2f2; font-weight: bold; text-align: center; text-transform: uppercase;">
                    <td style="border: 1px solid #000; padding: 6px;">Jenis Perawatan / Tindakan</td>
                    <td style="border: 1px solid #000; padding: 6px; width: 40px;">Qty</td>
                    <td style="border: 1px solid #000; padding: 6px; width: 90px;">Harga Satuan</td>
                    <td style="border: 1px solid #000; padding: 6px; width: 80px;">Diskon</td>
                    <td style="border: 1px solid #000; padding: 6px; width: 90px;">Total</td>
                </tr>
            </thead>
            <tbody id="print-items-list">
                <!-- Row ini akan diisi lewat JavaScript saat klik Done -->
                <tr>
                    <td style="border: 1px solid #000; padding: 6px; height: 40px; vertical-align: middle;">Restorasi Komposit Posterior Kecil</td>
                    <td style="border: 1px solid #000; padding: 6px; text-align: center;">1</td>
                    <td style="border: 1px solid #000; padding: 6px; text-align: right;">600.000</td>
                    <td style="border: 1px solid #000; padding: 6px; text-align: right;">0</td>
                    <td style="border: 1px solid #000; padding: 6px; text-align: right; font-weight: bold;">600.000</td>
                </tr>
            </tbody>
            <tfoot>
                <tr style="background-color: #f2f2f2;">
                    <td colspan="4" style="border: 1px solid #000; padding: 6px; text-align: right; font-weight: bold; text-transform: uppercase;">Grand Total Pembayaran</td>
                    <td style="border: 1px solid #000; padding: 6px; text-align: right; font-weight: bold; font-size: 11px; color: #3498db;" id="print-total">600.000</td>
                </tr>
            </tfoot>
        </table>

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
    </div>
</div>