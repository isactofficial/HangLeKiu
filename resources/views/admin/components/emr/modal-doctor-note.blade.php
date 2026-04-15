<style>
#modalDoctorNoteOverlay > div { width: min(100%, 760px); }

@media (max-width: 768px) {
    #modalDoctorNoteOverlay > div > div:first-child h3 {
        font-size: 20px !important;
    }
    #modalDoctorNoteOverlay > div > div:first-child,
    #modalDoctorNoteOverlay > div > div:nth-child(2) {
        padding-left: 14px !important;
        padding-right: 14px !important;
    }
    #modalDoctorNoteOverlay > div > div:last-child {
        padding: 10px 14px 16px !important;
    }
    /* Collapse 2-col patient info to 1-col */
    #modalDoctorNoteOverlay .grid[style*="grid-template-columns:repeat(2"] {
        grid-template-columns: 1fr !important;
    }
}
</style>
<div id="modalDoctorNoteOverlay" class="hidden" style="position:fixed; inset:0; background:rgba(15, 23, 42, 0.55); z-index:9999; align-items:center; justify-content:center; padding:20px;">
    <div style="background:#fff; width:100%; max-width:760px; border-radius:16px; box-shadow:0 24px 55px rgba(0,0,0,0.22); overflow:hidden; border:1px solid #f0e7dc;">
        <div style="display:flex; justify-content:space-between; align-items:center; padding:18px 22px; border-bottom:1px solid #eadfd3; background:linear-gradient(180deg, #fdf7f1 0%, #fff 100%);">
            <div>
                <h3 style="margin:0; font-size:30px; font-weight:800; color:#3b331e;">Tambah Catatan Dokter</h3>
            </div>
            <button type="button" onclick="toggleDoctorNoteModal(false)" style="width:30px; height:30px; border:1px solid #eadfd3; border-radius:8px; background:#fff; font-size:18px; color:#8e6a45; cursor:pointer; line-height:1;">&times;</button>
        </div>

        <div style="padding:20px 22px; display:grid; gap:14px;">
            <input type="hidden" id="doctorNoteRegistrationId" value="">

            <div style="display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:10px 12px; background:#fdfaf8; border:1px solid #eadfd3; border-radius:12px; padding:14px;">
                <div><div style="font-size:11px; color:#6b4b2f; font-weight:800; text-transform:uppercase;">Nama Pasien</div><div id="doctorNotePatientName" style="font-size:13px; color:#8e6a45; font-weight:700;">-</div></div>
                <div><div style="font-size:11px; color:#6b4b2f; font-weight:800; text-transform:uppercase;">No RM</div><div id="doctorNotePatientRm" style="font-size:13px; color:#8e6a45; font-weight:700;">-</div></div>
                <div><div style="font-size:11px; color:#6b4b2f; font-weight:800; text-transform:uppercase;">Dokter</div><div id="doctorNoteDoctorName" style="font-size:13px; color:#8e6a45; font-weight:700;">-</div></div>
                <div><div style="font-size:11px; color:#6b4b2f; font-weight:800; text-transform:uppercase;">TANGGAL LAHIR / UMUR</div><div id="doctorNotePatientDemography" style="font-size:13px; color:#8e6a45; font-weight:700;">-</div></div>
            </div>

            <div>
                <label for="doctorNoteSubjective" style="display:flex; align-items:center; gap:6px; font-size:12px; font-weight:800; color:#7a5536; margin-bottom:6px;">Subjectives <span style="font-size:11px; color:#9ca3af;"> </span></label>
                <textarea id="doctorNoteSubjective" rows="3" placeholder="Keluhan subjektif pasien..." style="width:100%; border:1px solid #d8c7b2; border-radius:10px; padding:10px 12px; font-size:13px; color:#5d3f28; outline:none; resize:vertical; min-height:84px; background:#fffdfb;"></textarea>
            </div>

            <div>
                <label for="doctorNoteObjective" style="display:flex; align-items:center; gap:6px; font-size:12px; font-weight:800; color:#7a5536; margin-bottom:6px;">Objectives <span style="font-size:11px; color:#9ca3af;"> </span></label>
                <textarea id="doctorNoteObjective" rows="3" placeholder="Temuan objektif hasil pemeriksaan..." style="width:100%; border:1px solid #d8c7b2; border-radius:10px; padding:10px 12px; font-size:13px; color:#5d3f28; outline:none; resize:vertical; min-height:84px; background:#fffdfb;"></textarea>
            </div>

            <div>
                <label for="doctorNotePlan" style="display:flex; align-items:center; gap:6px; font-size:12px; font-weight:800; color:#7a5536; margin-bottom:6px;">Plans <span style="font-size:11px; color:#9ca3af;"> </span></label>
                <textarea id="doctorNotePlan" rows="3" placeholder="Rencana terapi/tindak lanjut..." style="width:100%; border:1px solid #d8c7b2; border-radius:10px; padding:10px 12px; font-size:13px; color:#5d3f28; outline:none; resize:vertical; min-height:84px; background:#fffdfb;"></textarea>
            </div>
        </div>

        <div style="display:flex; justify-content:flex-end; gap:10px; padding:14px 22px 20px; border-top:1px solid #eadfd3;">
            <button type="button" onclick="toggleDoctorNoteModal(false)" style="padding:10px 16px; border:1px solid #d8c7b2; border-radius:9px; background:#fff; color:#6b4b2f; font-weight:700; cursor:pointer;">Batal</button>
            <button type="button" id="doctorNoteSaveBtn" onclick="submitDoctorNote()" style="padding:10px 18px; border:none; border-radius:9px; background:#A67C52; color:#fff; font-weight:700; cursor:pointer; box-shadow:0 6px 16px rgba(166,124,82,0.28);">Simpan Catatan</button>
        </div>
    </div>
</div>