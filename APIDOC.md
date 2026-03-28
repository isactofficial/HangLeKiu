# HDS — Hanglekiu Dental Specialist API

Dokumentasi API Backend untuk sistem manajemen klinik gigi **Hanglekiu Dental Specialist**.

---

## 📋 Daftar Isi

- [Autentikasi](#autentikasi)
- [Endpoint](#endpoint)
  - [Auth](#auth)
  - [Pendaftaran Rawat Jalan](#pendaftaran-rawat-jalan)
  - [Obat & Stok](#obat--stok)
  - [Odontogram](#odontogram)
  - [Master Procedure](#master-procedure)
  - [Procedure Medicine](#procedure-medicine)

---

## Autentikasi

API menggunakan **JWT Bearer Token**.

1. Login via `POST /api/auth/login`
2. Salin token dari response
3. Tambahkan di setiap request pada header:

```
Authorization: Bearer {token}
```

---

## Endpoint

### Base URL
```
http://127.0.0.1:8000
```

**Format:** JSON  
**Token berlaku:** 1 jam (3600 detik)

---

## Auth

### Register
```
POST /api/auth/register
```

**Body:**
```json
{
  "name": "Yusmia",
  "email": "saniyusmia@gmail.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Registrasi berhasil. Silakan cek email untuk verifikasi."
}
```

---

### Login
```
POST /api/auth/login
```

**Body:**
```json
{
  "email": "admin@gmail.com",
  "password": "12345678"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Login berhasil.",
  "data": {
    "token": "eyJ0eXAiOiJKV1QiLCJhbGci...",
    "token_type": "bearer",
    "expires_in": 3600,
    "user": {
      "id": "d385af01-607a-46ed-8050-e08648b18fbe",
      "name": "admin",
      "email": "admin@gmail.com",
      "role": "ADM",
      "role_name": "admin",
      "avatar_url": null,
      "is_verified": true,
      "last_login_at": "2026-03-25T20:33:48.000000Z"
    }
  }
}
```

---

## Pendaftaran Rawat Jalan

> Semua endpoint di bawah memerlukan **Authorization: Bearer {token}**

---

### 1. Master Data
Ambil semua data dropdown untuk form pendaftaran.

```
GET /api/registration/master-data
```

**Response:**
```json
{
  "poli": [
    { "id": "uuid", "name": "Poli Anak" },
    { "id": "uuid", "name": "Poli Bedah Mulut" },
    { "id": "uuid", "name": "Poli Gigi Umum" },
    { "id": "uuid", "name": "Poli Orthodonti" },
    { "id": "uuid", "name": "Poli Periodonti" }
  ],
  "guarantor_type": [
    { "id": "uuid", "name": "Asuransi Swasta" },
    { "id": "uuid", "name": "BPJS" },
    { "id": "uuid", "name": "Perusahaan" },
    { "id": "uuid", "name": "Umum" }
  ],
  "payment_method": [
    { "id": "uuid", "name": "Kartu Debit" },
    { "id": "uuid", "name": "Kartu Kredit" },
    { "id": "uuid", "name": "QRIS" },
    { "id": "uuid", "name": "Transfer Bank" },
    { "id": "uuid", "name": "Tunai" }
  ],
  "visit_type": [
    { "id": "uuid", "name": "Emergency" },
    { "id": "uuid", "name": "Kontrol" },
    { "id": "uuid", "name": "Kunjungan Baru" },
    { "id": "uuid", "name": "Kunjungan Lama" }
  ],
  "care_type": [
    { "id": "uuid", "name": "Konsultasi" },
    { "id": "uuid", "name": "Rawat Inap" },
    { "id": "uuid", "name": "Rawat Jalan" },
    { "id": "uuid", "name": "Tindakan" }
  ]
}
```

---

### 2. Dokter Aktif per Tanggal
Ambil daftar dokter yang praktik pada tanggal tertentu.

```
GET /api/registration/doctors?date=2026-03-26
```

**Query Params:**
| Param | Tipe | Keterangan |
|-------|------|------------|
| date | date | Tanggal kunjungan (YYYY-MM-DD) |

**Response:**
```json
[
  {
    "id": "972b4627-f1a8-46b3-ae5e-56b4291e313c",
    "full_name": "drg. Ahmad Fauzi, Sp.BM",
    "specialization": "Bedah Mulut",
    "title_prefix": "drg.",
    "schedules": [
      {
        "id": "0072608d-a878-4d7d-8235-e9f44d349296",
        "doctor_id": "972b4627-...",
        "day": "thursday",
        "start_time": "13:00:00",
        "end_time": "17:00:00",
        "is_active": true
      }
    ]
  }
]
```

---

### 3. Slot Waktu Tersedia
Ambil slot waktu yang belum dibooked untuk dokter pada tanggal tertentu.

```
GET /api/registration/slots?doctor_id={uuid}&date=2026-03-26
```

**Query Params:**
| Param | Tipe | Keterangan |
|-------|------|------------|
| doctor_id | uuid | ID dokter |
| date | date | Tanggal kunjungan (YYYY-MM-DD) |

---

### 4. Cari Pasien
Cari pasien lama berdasarkan nama atau nomor MR (minimal 2 karakter).

```
GET /api/registration/search-patient?q=Budi
```

**Query Params:**
| Param | Tipe | Keterangan |
|-------|------|------------|
| q | string | Nama pasien atau nomor MR (min. 2 karakter) |

**Response:**
```json
[
  {
    "id": "46db7139-a692-429c-888a-cce13a00f591",
    "full_name": "Budi",
    "medical_record_no": "MR2026000001",
    "date_of_birth": "2000-01-01",
    "gender": "Male",
    "email": null,
    "address": "Surabaya",
    "phone_number": null
  }
]
```

---

### 5. Buat Pendaftaran
Simpan pendaftaran rawat jalan baru. Mendukung pasien baru dan pasien lama.

```
POST /api/registration
```

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
Accept: application/json
```

**Body — Pasien Baru:**
```json
{
  "doctor_id": "972b4627-f1a8-46b3-ae5e-56b4291e313c",
  "poli_id": "8dd95299-5e3a-495d-b102-eb76a06a210b",
  "guarantor_type_id": "6a70c1ef-2df1-431f-b3b8-bfd0bdd38d5b",
  "payment_method_id": "c3813cb8-b0d7-45cf-86d2-faa509a36b9f",
  "visit_type_id": "84fca838-082b-4921-aa9f-4f44d7399feb",
  "care_type_id": "45cc7f87-402c-4dc7-bf41-124d236d16b3",
  "patient_type": "new",
  "date": "2026-03-26",
  "time": "14:00",
  "complaint": "Sakit gigi",
  "full_name": "Budi Santoso",
  "date_of_birth": "2000-01-01",
  "gender": "Male",
  "phone_number": "08123456789",
  "address": "Surabaya"
}
```

**Body — Pasien Lama:**
```json
{
  "doctor_id": "972b4627-f1a8-46b3-ae5e-56b4291e313c",
  "patient_type": "existing",
  "patient_id": "46db7139-a692-429c-888a-cce13a00f591",
  "date": "2026-03-26",
  "time": "14:00",
  "complaint": "Kontrol gigi"
}
```

**Response (201):**
```json
{
  "message": "Pendaftaran berhasil.",
  "data": {
    "id": "0f6e3150-8c38-46d3-9799-691d1032a74d",
    "patient_id": "46db7139-...",
    "doctor_id": "972b4627-...",
    "registration_date": "2026-03-26",
    "appointment_datetime": "2026-03-26T14:00:00",
    "status": "pending",
    "patient": { "..." },
    "doctor": { "..." }
  }
}
```

> **Catatan:** Untuk pasien baru, nomor MR akan di-generate otomatis (contoh: `MR2026000001`).

---

## Obat & Stok

### 1. List Semua Obat
```
GET /api/medicine
```

**Query Params (opsional):**
| Param | Keterangan |
|-------|------------|
| search | Filter berdasarkan nama obat |

---

### 2. Tambah Obat
```
POST /api/medicine
```

**Body:**
```json
{
  "medicine_name": "Paracetamol",
  "category": "Analgesik",
  "unit": "Tablet",
  "current_stock": 100,
  "minimum_stock": 20,
  "notes": "Obat demam"
}
```

**Response:**
```json
{
  "message": "Data obat berhasil ditambahkan",
  "data": {
    "id": "1f0927e4-ac53-4b8e-aec4-c32f59b8e37a",
    "medicine_name": "Paracetamol",
    "category": "Analgesik",
    "unit": "Tablet",
    "current_stock": 100,
    "minimum_stock": 20,
    "notes": "Obat demam",
    "created_at": "2026-03-25T23:34:04.000000Z",
    "updated_at": "2026-03-25T23:34:04.000000Z"
  }
}
```

---

### 3. Detail Obat
```
GET /api/medicine/{id}
```

**Response:**
```json
{
  "id": "1f0927e4-ac53-4b8e-aec4-c32f59b8e37a",
  "medicine_name": "Paracetamol",
  "category": "Analgesik",
  "unit": "Tablet",
  "current_stock": 100,
  "minimum_stock": 20,
  "notes": "Obat demam",
  "created_at": "2026-03-25T23:34:04.000000Z",
  "updated_at": "2026-03-25T23:34:04.000000Z"
}
```

---

### 4. Update Obat
```
PUT /api/medicine/{id}
```

**Body:** sama seperti tambah obat.

---

### 5. Hapus Obat
```
DELETE /api/medicine/{id}
```

---

### 6. Stok Masuk
```
POST /api/medicine/{id}/stock-in
```

**Body:**
```json
{
  "qty": 50,
  "note": "Pembelian supplier"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Stok berhasil ditambahkan",
  "current_stock": 90
}
```

---

### 7. Stok Keluar
```
POST /api/medicine/{id}/stock-out
```

**Body:**
```json
{
  "qty": 10,
  "note": "Dipakai pasien"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Stok berhasil dikurangi",
  "current_stock": 40
}
```

---

### 8. Riwayat Stok
```
GET /api/medicine/{id}/stock-history
```

---

## Odontogram

### 1. Tambah Kondisi Gigi
Menambahkan kondisi gigi ke dalam record odontogram pasien.

```
POST /api/odontogram/{odontogram_record_id}/teeth
```

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Body:**
```json
{
  "tooth_number": 16,
  "surfaces": "M,O",
  "condition_code": "CAR",
  "condition_label": "Karies",
  "color_code": "#ef4444"
}
```

**Field:**
| Field | Tipe | Keterangan |
|-------|------|------------|
| tooth_number | integer | Nomor gigi (sistem FDI) |
| surfaces | string | Permukaan gigi (M, O, D, B, L), bisa `null` |
| condition_code | string | Kode kondisi: `CAR` (Karies), `MIS` (Missing), dll |
| condition_label | string | Label kondisi dalam bahasa Indonesia |
| color_code | string | Hex color untuk visualisasi |

**Response (201):**
```json
{
  "status": "success",
  "data": {
    "odontogram_record_id": "905c6bc2-e123-4ae4-b1f5-da10ca6ce58b",
    "tooth_number": 16,
    "surfaces": "M,O",
    "condition_code": "CAR",
    "condition_label": "Karies",
    "color_code": "#ef4444",
    "id": "e4619fb9-90df-4142-891d-098709b75c75",
    "created_at": "2026-03-26T16:12:13.000000Z"
  }
}
```

---

### 2. Get Record Odontogram
```
GET /api/odontogram/{odontogram_record_id}
```

**Response:**
```json
{
  "status": "success",
  "data": {
    "record": {
      "id": "905c6bc2-e123-4ae4-b1f5-da10ca6ce58b",
      "patient_id": "46db7139-a692-429c-888a-cce13a00f591",
      "visit_id": null,
      "examined_by": "drg. Test",
      "notes": "Pemeriksaan awal",
      "examined_at": "2026-03-26T16:05:23.000000Z",
      "teeth": [
        {
          "id": "e4619fb9-90df-4142-891d-098709b75c75",
          "tooth_number": 16,
          "surfaces": "M,O",
          "condition_code": "CAR",
          "condition_label": "Karies",
          "color_code": "#ef4444",
          "notes": null,
          "created_at": "2026-03-26T16:12:13.000000Z"
        }
      ]
    },
    "tooth_map": {
      "16": [ { "..." } ]
    }
  }
}
```

---

## Master Procedure

### 1. Get Semua Master Procedure
```
GET /api/master-procedure
```

**Headers:**
```
Accept: application/json
```

**Response:**
```json
{
  "success": true,
  "message": "Data master prosedur berhasil diambil",
  "data": {
    "current_page": 1,
    "data": [],
    "per_page": 10,
    "total": 0
  }
}
```

> Response mendukung **pagination** dengan parameter `?page={n}`.

---

### 2. Tambah Master Procedure
```
POST /api/master-procedure
```

**Headers:**
```
Accept: application/json
Content-Type: application/json
```

**Body:**
```json
{
  "procedure_name": "Konsultasi Umum",
  "base_price": 150000,
  "is_active": true
}
```

---

### 3. Detail Master Procedure
```
GET /api/master-procedure/{id}
```

---

### 4. Update Master Procedure
```
PUT /api/master-procedure/{id}
```

**Body:**
```json
{
  "procedure_name": "Konsultasi Umum Update",
  "base_price": 175000,
  "is_active": true
}
```

---

### 5. Hapus Master Procedure
```
DELETE /api/master-procedure/{id}
```

**Response:**
```json
{
  "success": true,
  "message": "Master prosedur berhasil dihapus"
}
```

---

## Procedure Medicine

Mengelola relasi antara prosedur medis dan obat yang digunakan.

### 1. Get Semua Procedure Medicine
```
GET /api/procedure-medicine
```

**Response:**
```json
{
  "success": true,
  "message": "Data obat prosedur berhasil diambil",
  "data": [
    {
      "id": "d7938820-6771-4f1c-88de-5f16b8eabb22",
      "procedure_id": "b737ce65-29f7-11f1-9f68-1c4d706f730d",
      "medicine_id": "1f0927e4-ac53-4b8e-aec4-c32f59b8e37a",
      "quantity_used": 2,
      "created_at": "2026-03-27 23:12:35",
      "medicine": {
        "id": "1f0927e4-ac53-4b8e-aec4-c32f59b8e37a",
        "medicine_name": "Paracetamol",
        "category": "Analgesik",
        "unit": "Tablet",
        "current_stock": 68,
        "minimum_stock": 20,
        "notes": "Obat demam"
      }
    }
  ]
}
```

---

### 2. Tambah Procedure Medicine
```
POST /api/procedure-medicine
```

**Headers:**
```
Accept: application/json
Content-Type: application/json
```

**Body:**
```json
{
  "procedure_id": "b737ce65-29f7-11f1-9f68-1c4d706f730d",
  "medicine_id": "1f0927e4-ac53-4b8e-aec4-c32f59b8e37a",
  "quantity_used": 2
}
```

**Response (201):**
```json
{
  "success": true,
  "message": "Obat prosedur berhasil ditambahkan",
  "data": {
    "id": "d7938820-6771-4f1c-88de-5f16b8eabb22",
    "procedure_id": "b737ce65-...",
    "medicine_id": "1f0927e4-...",
    "quantity_used": 2,
    "medicine": {
      "medicine_name": "Paracetamol",
      "category": "Analgesik",
      "unit": "Tablet",
      "current_stock": 68
    }
  }
}
```

---

### 3. Detail Procedure Medicine
```
GET /api/procedure-medicine/{id}
```

**Response:**
```json
{
  "success": true,
  "data": {
    "id": "d7938820-6771-4f1c-88de-5f16b8eabb22",
    "procedure_id": "b737ce65-...",
    "medicine_id": "1f0927e4-...",
    "quantity_used": 2,
    "created_at": "2026-03-27 23:12:35",
    "medicine": {
      "medicine_name": "Paracetamol",
      "category": "Analgesik",
      "unit": "Tablet",
      "current_stock": 68
    }
  }
}
```

---

### 4. Hapus Procedure Medicine
```
DELETE /api/procedure-medicine/{id}
```

---

## 🗃️ Tabel Database yang Digunakan

| Tabel | Keterangan |
|-------|------------|
| `user` | Data user & admin |
| `doctor` | Data dokter |
| `doctor_schedule` | Jadwal praktik dokter |
| `patient` | Data pasien |
| `registration` | Data pendaftaran appointment |
| `master_poli` | Master data poli |
| `master_guarantor_type` | Master jenis penjamin |
| `master_payment_method` | Master metode pembayaran |
| `master_visit_type` | Master jenis kunjungan |
| `master_care_type` | Master jenis perawatan |
| `medicine` | Data obat |
| `medicine_stock_log` | Riwayat mutasi stok obat |
| `odontogram_record` | Record pemeriksaan odontogram |
| `odontogram_tooth` | Detail kondisi gigi per record |
| `master_procedure` | Master data prosedur tindakan |
| `procedure_medicine` | Relasi prosedur dan obat yang digunakan |
| `medical_procedure` | Data tindakan medis per pasien |

---

## 📌 Catatan

- Semua `id` menggunakan format **UUID**
- Token JWT berlaku selama **1 jam**
- Slot waktu dibagi per **15 menit**
- Nomor MR pasien baru di-generate otomatis: `MR{tahun}{6digit}`

---

*Dibuat oleh Yusmia — Backend Developer HDS*