# HDS — Hanglekiu Dental Specialist API

Dokumentasi API Backend untuk sistem pendaftaran rawat jalan klinik gigi **Hanglekiu Dental Specialist**.

---

## 📋 Daftar Isi

- [Teknologi](#teknologi)
- [Instalasi](#instalasi)
- [Autentikasi](#autentikasi)
- [Endpoint](#endpoint)
  - [Auth](#auth)
  - [Pendaftaran Rawat Jalan](#pendaftaran-rawat-jalan)
  - [Obat & Stok](#obat--stok)

---

## Teknologi

- **Laravel** (PHP 8.2)
- **MySQL** (via XAMPP)
- **JWT Auth** (tymon/jwt-auth)
- **Mailtrap** (email verifikasi)

---

## Instalasi

```bash
# 1. Clone repo
git clone https://github.com/isactofficial/HangLeKiu.git
cd HangLeKiu

# 2. Install dependencies
composer install

# 3. Copy .env
cp .env.example .env
php artisan key:generate

# 4. Setting database di .env
DB_DATABASE=hanglekiudental
DB_USERNAME=root
DB_PASSWORD=

# 5. Migrasi & seeder
php artisan migrate
php artisan db:seed --class=MasterDataSeeder
php artisan db:seed --class=DoctorSeeder

# 6. Generate JWT secret
php artisan jwt:secret

# 7. Jalankan server
php artisan serve
```

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
      "id": "d385af01-...",
      "name": "admin",
      "email": "admin@gmail.com",
      "role": "ADM"
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
    { "id": "uuid", "name": "Poli Gigi Umum" },
    { "id": "uuid", "name": "Poli Orthodonti" }
  ],
  "guarantor_type": [
    { "id": "uuid", "name": "Umum" },
    { "id": "uuid", "name": "BPJS" }
  ],
  "payment_method": [
    { "id": "uuid", "name": "Tunai" },
    { "id": "uuid", "name": "QRIS" }
  ],
  "visit_type": [
    { "id": "uuid", "name": "Kunjungan Baru" },
    { "id": "uuid", "name": "Kontrol" }
  ],
  "care_type": [
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
    "id": "972b4627-...",
    "full_name": "drg. Ahmad Fauzi, Sp.BM",
    "specialization": "Bedah Mulut",
    "title_prefix": "drg.",
    "schedules": [
      {
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
Ambil slot waktu yang belum dibooked untuk dokter pada tanggal tertentu. Slot dibagi per **15 menit**.

```
GET /api/registration/slots?doctor_id={uuid}&date=2026-03-26
```

**Query Params:**
| Param | Tipe | Keterangan |
|-------|------|------------|
| doctor_id | uuid | ID dokter |
| date | date | Tanggal kunjungan (YYYY-MM-DD) |

**Response:**
```json
{
  "slots": [
    { "time": "13:00", "available": true },
    { "time": "13:15", "available": true },
    { "time": "13:30", "available": false }
  ]
}
```

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
    "id": "46db7139-...",
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
Simpan pendaftaran rawat jalan baru. Mendukung pasien lama dan pasien baru.

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
  "poli_id": "8dd95299-...",
  "guarantor_type_id": "6a70c1ef-...",
  "payment_method_id": "c3813cb8-...",
  "visit_type_id": "84fca838-...",
  "care_type_id": "45cc7f87-...",
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
  "doctor_id": "972b4627-...",
  "patient_type": "existing",
  "patient_id": "46db7139-...",
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
    "id": "0f6e3150-...",
    "patient_id": "46db7139-...",
    "doctor_id": "972b4627-...",
    "registration_date": "2026-03-26",
    "appointment_datetime": "2026-03-26T14:00:00",
    "status": "pending",
    "patient": { ... },
    "doctor": { ... }
  }
}
```

> **Catatan:** Untuk pasien baru, nomor MR akan di-generate otomatis (contoh: `MR2026000001`).

---

## Obat & Stok

### 1. List Semua Obat
```
GET /api/medicine?search=paracetamol
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
    "id": "1f0927e4-...",
    "medicine_name": "Paracetamol",
    "current_stock": 100
  }
}
```

---

### 3. Detail Obat
```
GET /api/medicine/{id}
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

---

## 📌 Catatan

- Semua `id` menggunakan format **UUID**
- Token JWT berlaku selama **1 jam**
- Slot waktu dibagi per **15 menit**
- Nomor MR pasien baru di-generate otomatis: `MR{tahun}{6digit}`

---

*Dibuat oleh Yusmia — Backend Developer HDS*