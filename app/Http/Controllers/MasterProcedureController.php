<?php

namespace App\Http\Controllers;

use App\Models\MasterProcedure;
use App\Models\MasterCareType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class MasterProcedureController extends BaseMasterController
{
    public function __construct()
    {
        parent::__construct(MasterProcedure::class, 'Prosedur');
    }

    public function index(Request $request)
    {
        $query = MasterProcedure::with('careType');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('procedure_name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        if ($request->care_type_id) {
            $query->where('care_type_id', $request->care_type_id);
        }

        $data = $query->orderByRaw('COALESCE(name, procedure_name) asc')->paginate(10);

        return response()->json([
            'success' => true,
            'message' => "Data {$this->resourceName} berhasil diambil",
            'data'    => $data
        ]);
    }

    public function show($id)
    {
        $item = MasterProcedure::with('careType')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $item
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'nullable|string|max:100|required_without:procedure_name',
            'procedure_name' => 'nullable|string|max:150|required_without:name',
            'care_type_id'   => 'nullable|string|exists:master_care_type,id',
            'price'          => 'nullable|numeric|min:0',
            'base_price'     => 'nullable|numeric|min:0',
            'description'    => 'nullable|string|max:255',
            'is_active'      => 'nullable|boolean',
        ]);

        $procedureName = trim((string) ($validated['name'] ?? $validated['procedure_name'] ?? ''));
        $price = $validated['price'] ?? $validated['base_price'] ?? 0;

        $item = MasterProcedure::create([
            'id'             => (string) Str::uuid(),
            'name'           => $procedureName,
            'procedure_name' => $procedureName,
            'care_type_id'   => $validated['care_type_id'] ?? null,
            'price'          => $price,
            'base_price'     => $price,
            'description'    => $validated['description'] ?? '',
            'is_active'      => isset($validated['is_active']) ? (bool) $validated['is_active'] : true,
        ]);

        return response()->json([
            'success' => true,
            'message' => "{$this->resourceName} berhasil ditambahkan",
            'data'    => $item->load('careType')
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $item = MasterProcedure::findOrFail($id);

        $validated = $request->validate([
            'name'           => 'nullable|string|max:100|required_without:procedure_name',
            'procedure_name' => 'nullable|string|max:150|required_without:name',
            'care_type_id'   => 'nullable|string|exists:master_care_type,id',
            'price'          => 'nullable|numeric|min:0',
            'base_price'     => 'nullable|numeric|min:0',
            'description'    => 'nullable|string|max:255',
            'is_active'      => 'nullable|boolean',
        ]);

        $procedureName = trim((string) ($validated['name'] ?? $validated['procedure_name'] ?? $item->name ?? $item->procedure_name ?? ''));
        $price = $validated['price'] ?? $validated['base_price'] ?? $item->price ?? $item->base_price ?? 0;

        $item->update([
            'name'           => $procedureName,
            'procedure_name' => $procedureName,
            'care_type_id'   => $validated['care_type_id'] ?? $item->care_type_id,
            'price'          => $price,
            'base_price'     => $price,
            'description'    => $validated['description'] ?? $item->description,
            'is_active'      => isset($validated['is_active']) ? (bool) $validated['is_active'] : $item->is_active,
        ]);

        return response()->json([
            'success' => true,
            'message' => "{$this->resourceName} berhasil diupdate",
            'data'    => $item->load('careType')
        ]);
    }

    public function destroy($id)
    {
        $item = MasterProcedure::findOrFail($id);

        try {
            $item->delete();
            return response()->json([
                'success' => true,
                'message' => "{$this->resourceName} berhasil dihapus"
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
                return response()->json([
                    'success' => false,
                    'message' => "{$this->resourceName} tidak bisa dihapus karena sudah digunakan di data lain"
                ], 422);
            }
            throw $e;
        }
    }

    // ─── Export & Import ───────────────────────────────────────────────

    private function buildStyledSpreadsheet(array $dataRows, bool $isTemplate = false): Spreadsheet
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle($isTemplate ? 'Template Import' : 'Data Prosedur');

        $title    = $isTemplate ? 'TEMPLATE IMPORT PROSEDUR' : 'MASTER PROSEDUR TREATMENT';
        $subtitle = $isTemplate
            ? 'Isi sesuai panduan di bawah  •  Hapus baris contoh sebelum import'
            : 'Hanglekiu Dental Specialist  •  Data diekspor otomatis dari sistem';

        $cols = ['A', 'B', 'C', 'D', 'E'];

        // ── Baris 1: Judul ──
        $sheet->mergeCells('A1:E1');
        $sheet->setCellValue('A1', $title);
        $sheet->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 14, 'color' => ['rgb' => 'FFFFFF'], 'name' => 'Arial'],
            'fill'      => ['fillType' => 'solid', 'startColor' => ['rgb' => '3E1C00']],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(34);

        // ── Baris 2: Subtitle ──
        $sheet->mergeCells('A2:E2');
        $sheet->setCellValue('A2', $subtitle);
        $sheet->getStyle('A2')->applyFromArray([
            'font'      => ['size' => 9, 'italic' => true, 'color' => ['rgb' => '7A5540'], 'name' => 'Arial'],
            'fill'      => ['fillType' => 'solid', 'startColor' => ['rgb' => 'EFE0D0']],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
        ]);
        $sheet->getRowDimension(2)->setRowHeight(18);

        // ── Baris 3: Header kolom ──
        $headers = $isTemplate
            ? ['procedure_name', 'jenis_perawatan', 'base_price', 'description', 'status']
            : ['Nama Prosedur', 'Jenis Perawatan', 'Harga (IDR)', 'Deskripsi', 'Status'];

        foreach ($headers as $i => $h) {
            $sheet->setCellValue($cols[$i] . '3', $h);
        }
        $sheet->getStyle('A3:E3')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 10, 'color' => ['rgb' => 'FFFFFF'], 'name' => 'Arial'],
            'fill'      => ['fillType' => 'solid', 'startColor' => ['rgb' => '582C0C']],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
            'borders'   => ['allBorders' => ['borderStyle' => 'thin', 'color' => ['rgb' => 'D6C4B0']]],
        ]);
        $sheet->getRowDimension(3)->setRowHeight(22);

        // ── Baris 4: Placeholder (template only) ──
        if ($isTemplate) {
            $placeholders = ['(nama_prosedur)', '(jenis_perawatan)', '(harga)', '(deskripsi)', '(aktif/tidak_aktif)'];
            foreach ($placeholders as $i => $p) {
                $sheet->setCellValue($cols[$i] . '4', $p);
            }
            $sheet->getStyle('A4:E4')->applyFromArray([
                'font'      => ['size' => 9, 'italic' => true, 'color' => ['rgb' => 'B08968'], 'name' => 'Arial'],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['rgb' => 'FFF3E8']],
                'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
                'borders'   => ['allBorders' => ['borderStyle' => 'thin', 'color' => ['rgb' => 'E0C9B0']]],
            ]);
            $sheet->getRowDimension(4)->setRowHeight(18);
        }

        // ── Data rows ──
        $startRow = $isTemplate ? 5 : 4;
        foreach ($dataRows as $i => $row) {
            $r        = $startRow + $i;
            $bg       = $i % 2 === 0 ? 'F5EDE4' : 'FDF7F2';
            $isActive = strtolower($row['status'] ?? 'aktif') === 'aktif';

            // Nama
            $sheet->setCellValue("A{$r}", $row['name']);
            $sheet->getStyle("A{$r}")->applyFromArray([
                'font'      => ['bold' => true, 'size' => 9, 'color' => ['rgb' => '3E1C00'], 'name' => 'Arial'],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['rgb' => $bg]],
                'borders'   => ['allBorders' => ['borderStyle' => 'thin', 'color' => ['rgb' => 'D6C4B0']]],
                'alignment' => ['vertical' => 'center'],
            ]);

            // Jenis Perawatan
            $sheet->setCellValue("B{$r}", $row['care_type']);
            $sheet->getStyle("B{$r}")->applyFromArray([
                'font'      => ['size' => 9, 'color' => ['rgb' => '6B513E'], 'name' => 'Arial'],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['rgb' => $bg]],
                'borders'   => ['allBorders' => ['borderStyle' => 'thin', 'color' => ['rgb' => 'D6C4B0']]],
                'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
            ]);

            // Harga
            $sheet->setCellValue("C{$r}", $row['price']);
            $sheet->getStyle("C{$r}")->applyFromArray([
                'font'      => ['size' => 9, 'color' => ['rgb' => '1565C0'], 'name' => 'Arial'],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['rgb' => $bg]],
                'borders'   => ['allBorders' => ['borderStyle' => 'thin', 'color' => ['rgb' => 'D6C4B0']]],
                'alignment' => ['horizontal' => 'right', 'vertical' => 'center'],
            ]);
            $sheet->getStyle("C{$r}")->getNumberFormat()->setFormatCode('0');

            // Deskripsi
            $sheet->setCellValue("D{$r}", $row['description']);
            $sheet->getStyle("D{$r}")->applyFromArray([
                'font'      => ['size' => 9, 'color' => ['rgb' => '757575'], 'name' => 'Arial'],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['rgb' => $bg]],
                'borders'   => ['allBorders' => ['borderStyle' => 'thin', 'color' => ['rgb' => 'D6C4B0']]],
                'alignment' => ['vertical' => 'center', 'wrapText' => true],
            ]);

            // Status
            $sheet->setCellValue("E{$r}", $isActive ? 'Aktif' : 'Tidak Aktif');
            $sheet->getStyle("E{$r}")->applyFromArray([
                'font'      => ['bold' => true, 'size' => 9, 'name' => 'Arial', 'color' => ['rgb' => $isActive ? '2E7D32' : 'C62828']],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['rgb' => $isActive ? 'E8F5E9' : 'FFEBEE']],
                'borders'   => ['allBorders' => ['borderStyle' => 'thin', 'color' => ['rgb' => 'D6C4B0']]],
                'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
            ]);

            $sheet->getRowDimension($r)->setRowHeight(18);
        }

        // ── Footer total (export only) ──
        if (!$isTemplate) {
            $fr = $startRow + count($dataRows);
            $sheet->mergeCells("A{$fr}:E{$fr}");
            $sheet->setCellValue("A{$fr}", 'Total: ' . count($dataRows) . ' prosedur');
            $sheet->getStyle("A{$fr}")->applyFromArray([
                'font'      => ['bold' => true, 'size' => 9, 'color' => ['rgb' => '582C0C'], 'name' => 'Arial'],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['rgb' => 'EFE0D0']],
                'alignment' => ['horizontal' => 'right', 'vertical' => 'center'],
            ]);
            $sheet->getRowDimension($fr)->setRowHeight(18);
        }

        // ── Panduan (template only) ──
        if ($isTemplate) {
            $panduan = [
                ['text' => 'PANDUAN PENGISIAN', 'title' => true],
                ['text' => 'procedure_name  →  Nama prosedur (wajib diisi)', 'title' => false],
                ['text' => 'jenis_perawatan  →  Harus salah satu: Tindakan / Konsultasi / Rawat Jalan / Rawat Inap', 'title' => false],
                ['text' => 'base_price  →  Angka tanpa titik/koma, contoh: 150000', 'title' => false],
                ['text' => 'description  →  Deskripsi prosedur (boleh dikosongkan)', 'title' => false],
                ['text' => 'status  →  Isi dengan: aktif  atau  tidak_aktif', 'title' => false],
            ];
            $pr = $startRow + count($dataRows) + 2;
            foreach ($panduan as $p) {
                $sheet->mergeCells("A{$pr}:E{$pr}");
                $sheet->setCellValue("A{$pr}", $p['text']);
                $sheet->getStyle("A{$pr}")->applyFromArray([
                    'font'      => $p['title']
                        ? ['bold' => true, 'size' => 10, 'color' => ['rgb' => '582C0C'], 'name' => 'Arial']
                        : ['size' => 9, 'color' => ['rgb' => '4A2D1A'], 'name' => 'Arial'],
                    'fill'      => ['fillType' => 'solid', 'startColor' => ['rgb' => $p['title'] ? 'EFE0D0' : 'FDFAF7']],
                    'alignment' => ['vertical' => 'center'],
                ]);
                $sheet->getRowDimension($pr)->setRowHeight(17);
                $pr++;
            }
        }

        // ── Lebar kolom & freeze ──
        $sheet->getColumnDimension('A')->setWidth(32);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(16);
        $sheet->getColumnDimension('D')->setWidth(45);
        $sheet->getColumnDimension('E')->setWidth(14);
        $sheet->freezePane('A4');

        return $spreadsheet;
    }

    public function exportExcel()
    {
        $procedures = MasterProcedure::with('careType')
            ->orderByRaw('COALESCE(name, procedure_name) asc')
            ->get();

        $dataRows = $procedures->map(fn($p) => [
            'name'        => $p->name ?? $p->procedure_name,
            'care_type'   => $p->careType->name ?? '',
            'price'       => $p->price ?? $p->base_price ?? 0,
            'description' => $p->description ?? '',
            'status'      => $p->is_active ? 'aktif' : 'tidak_aktif',
        ])->toArray();

        $spreadsheet = $this->buildStyledSpreadsheet($dataRows, false);
        $filename    = 'prosedur_' . date('Ymd_His') . '.xlsx';
        $writer      = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    public function exportTemplate()
    {
        $contoh = [
            ['name' => 'Konsultasi Gigi',    'care_type' => 'Konsultasi', 'price' => 150000, 'description' => 'Pemeriksaan awal kondisi gigi',           'status' => 'aktif'],
            ['name' => 'Scaling Ultrasonik', 'care_type' => 'Tindakan',   'price' => 200000, 'description' => 'Pembersihan karang gigi dengan ultrasonik', 'status' => 'aktif'],
            ['name' => 'Cabut Gigi Susu',    'care_type' => 'Tindakan',   'price' => 100000, 'description' => '',                                          'status' => 'aktif'],
            ['name' => 'Rawat Gigi Anak',    'care_type' => 'Rawat Jalan','price' => 80000,  'description' => 'Perawatan gigi anak umum',                  'status' => 'aktif'],
        ];

        $spreadsheet = $this->buildStyledSpreadsheet($contoh, true);
        $writer      = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, 'template_import_prosedur.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:5120',
        ]);

        try {
            $spreadsheet = IOFactory::load($request->file('file')->getPathname());
            $rows = $spreadsheet->getActiveSheet()->toArray();

            $headerRow = 0;
            foreach ($rows as $i => $row) {
                $normalized = array_map(fn($v) => strtolower(trim((string)$v)), $row);
                if (in_array('procedure_name', $normalized)) {
                    $headerRow = $i;
                    break;
                }
            }

            $headers   = array_map(fn($v) => strtolower(trim((string)$v)), $rows[$headerRow]);
            $nameIdx   = array_search('procedure_name', $headers);
            $careIdx   = array_search('jenis_perawatan', $headers);
            $priceIdx  = array_search('base_price', $headers);
            $descIdx   = array_search('description', $headers);
            $statusIdx = array_search('status', $headers);

            if ($nameIdx === false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kolom procedure_name tidak ditemukan. Gunakan template yang benar.',
                ], 422);
            }

            $careMap = MasterCareType::pluck('id', 'name')
                ->mapWithKeys(fn($id, $name) => [strtolower($name) => $id])
                ->toArray();

            $imported = 0;
            $skipped  = 0;
            $errors   = [];

            for ($i = $headerRow + 1; $i < count($rows); $i++) {
                $row  = $rows[$i];
                $name = trim((string)($row[$nameIdx] ?? ''));

                if (!$name) { $skipped++; continue; }

                $careTypeName = strtolower(trim((string)($row[$careIdx] ?? '')));
                $careTypeId   = $careMap[$careTypeName] ?? null;

                if (!$careTypeId) {
                    $errors[] = "Baris " . ($i + 1) . ": jenis perawatan '$careTypeName' tidak ditemukan";
                    $skipped++;
                    continue;
                }

                $price     = is_numeric($row[$priceIdx] ?? null) ? (float)$row[$priceIdx] : 0;
                $desc      = trim((string)($row[$descIdx] ?? ''));
                $statusRaw = strtolower(trim((string)($row[$statusIdx] ?? 'aktif')));
                $isActive  = !in_array($statusRaw, ['tidak_aktif', 'inactive', '0', 'false']);

                MasterProcedure::create([
                    'id'             => (string) Str::uuid(),
                    'name'           => $name,
                    'procedure_name' => $name,
                    'care_type_id'   => $careTypeId,
                    'price'          => $price,
                    'base_price'     => $price,
                    'description'    => $desc,
                    'is_active'      => $isActive,
                ]);

                $imported++;
            }

            return response()->json([
                'success'  => true,
                'imported' => $imported,
                'skipped'  => $skipped,
                'errors'   => $errors,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses file: ' . $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
            ], 500);
        }
    }
}