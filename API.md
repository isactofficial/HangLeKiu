# API Pasien Aktif

Base URL:
http://localhost:8000

## 1) Create Pasien

- Method: POST
- Endpoint: /api/patients
- Headers:
  - Content-Type: application/json
  - Accept: application/json

Request body:
```json
{
  "full_name": "Muhammad Farhan",
  "email": "farhan@gmail.com",
  "password": "password123",
  "date_of_birth": "2026-04-12",
  "gender": "Male",
  "blood_type": "O",
  "rhesus": "+",
  "address": "Jl. Bandung No 10",
  "phone_number": "081234567890",
  "city": "Bandung",
  "id_card_number": "362832982308273",
  "allergy_history": "Tidak ada"
}
```

Success response (201):
```json
{
  "success": true,
  "message": "User pasien dan data pasien berhasil dibuat",
  "data": {
    "user": {
      "id": "uuid",
      "role_id": "role-pat-id",
      "name": "Muhammad Farhan",
      "email": "farhan@gmail.com",
      "is_active": true,
      "is_verified": false,
      "created_at": "2026-03-18T10:00:00.000000Z",
      "updated_at": "2026-03-18T10:00:00.000000Z"
    },
    "patient": {
      "id": "uuid",
      "user_id": "uuid",
      "full_name": "Muhammad Farhan",
      "email": "farhan@gmail.com",
      "medical_record_no": "MR202603180001",
      "date_of_birth": "2026-04-12",
      "gender": "Male",
      "blood_type": "O",
      "rhesus": "+",
      "address": "Jl. Bandung No 10",
      "phone_number": "081234567890",
      "city": "Bandung",
      "id_card_number": "087726425124",
      "allergy_history": "Tidak ada",
      "created_at": "2026-03-18T10:00:00.000000Z",
      "updated_at": "2026-03-18T10:00:00.000000Z"
    }
  }
}
```

Validation notes:
- gender harus: Male atau Female.
- email harus unik pada tabel user.
- phone_number opsional, maksimal 20 karakter.
- jika role PAT tidak ada, API mengembalikan 422.

## 2) Read Semua Pasien

- Method: GET
- Endpoint: /api/patients
- Headers:
  - Accept: application/json

Success response (200):
```json
{
  "success": true,
  "message": "Data pasien berhasil diambil",
  "data": [
    {
      "id": "uuid",
      "user_id": "uuid",
      "full_name": "Muhammad Farhan",
      "email": "farhan@gmail.com",
      "medical_record_no": "MR202603180001",
      "date_of_birth": "2026-04-12",
      "gender": "Male",
      "blood_type": "O",
      "rhesus": "+",
      "address": "Jl. Bandung No 10",
      "phone_number": "081234567890",
      "city": "Bandung",
      "id_card_number": "087726425124",
      "allergy_history": "Tidak ada",
      "created_at": "2026-03-18T10:00:00.000000Z",
      "updated_at": "2026-03-18T10:00:00.000000Z"
    }
  ],
  "count": 1
}
```

## 3) Read Pasien by ID

- Method: GET
- Endpoint: /api/patients/{id}
- Headers:
  - Accept: application/json

Contoh:
GET /api/patients/550e8400-e29b-41d4-a716-446655440000

Success response (200):
```json
{
  "success": true,
  "message": "Data pasien berhasil diambil",
  "data": {
    "id": "550e8400-e29b-41d4-a716-446655440000",
    "user_id": "uuid",
    "full_name": "Muhammad Farhan",
    "email": "farhan@gmail.com",
    "medical_record_no": "MR202603180001",
    "date_of_birth": "2026-04-12",
    "gender": "Male",
    "blood_type": "O",
    "rhesus": "+",
    "address": "Jl. Bandung No 10",
    "phone_number": "081234567890",
    "city": "Bandung",
    "id_card_number": "087726425124",
    "allergy_history": "Tidak ada",
    "created_at": "2026-03-18T10:00:00.000000Z",
    "updated_at": "2026-03-18T10:00:00.000000Z"
  }
}
```

Not found response (404):
```json
{
  "success": false,
  "message": "Data pasien tidak ditemukan"
}
```

## 4) Update Pasien (Data Patient + User)

- Method: PUT
- Endpoint: /api/patients/{id}
- Headers:
  - Content-Type: application/json
  - Accept: application/json

Contoh:
PUT /api/patients/550e8400-e29b-41d4-a716-446655440000

Request body (partial update diperbolehkan):
```json
{
  "full_name": "Muhammad Farhan Update",
  "email": "farhan.update@gmail.com",
  "password": "passwordBaru123",
  "phone_number": "081298765432",
  "city": "Jakarta",
  "allergy_history": "Alergi udang"
}
```

Success response (200):
```json
{
  "success": true,
  "message": "Data pasien berhasil diperbarui",
  "data": {
    "user": {
      "id": "uuid",
      "name": "Muhammad Farhan Update",
      "email": "farhan.update@gmail.com"
    },
    "patient": {
      "id": "550e8400-e29b-41d4-a716-446655440000",
      "user_id": "uuid",
      "full_name": "Muhammad Farhan Update",
      "email": "farhan.update@gmail.com",
      "phone_number": "081298765432",
      "city": "Jakarta",
      "allergy_history": "Alergi udang",
      "updated_at": "2026-03-24T10:00:00.000000Z"
    }
  }
}
```

Not found response (404):
```json
{
  "success": false,
  "message": "Data pasien tidak ditemukan"
}
```

Server error response (500):
```json
{
  "success": false,
  "message": "Gagal memperbarui data pasien",
  "error": "..."
}
```

Validation notes:
- Semua field bersifat opsional (partial update).
- Jika mengirim email, email harus unik pada tabel user (kecuali milik user pasien yang sedang diupdate).
- Jika mengirim password, minimal 6 karakter.
- Jika mengirim password kosong/null, password user tidak diubah.
- Jika mengirim phone_number, maksimal 20 karakter.
- Field `medical_record_no` tidak diproses oleh endpoint update.

## 5) Delete Pasien (Soft Delete)

- Method: DELETE
- Endpoint: /api/patients/{id}
- Headers:
  - Accept: application/json

Contoh:
DELETE /api/patients/550e8400-e29b-41d4-a716-446655440000

Success response (200):
```json
{
  "success": true,
  "message": "Data pasien berhasil dihapus (soft delete)"
}
```

Not found response (404):
```json
{
  "success": false,
  "message": "Data pasien tidak ditemukan"
}
```

Server error response (500):
```json
{
  "success": false,
  "message": "Gagal menghapus data pasien",
  "error": "..."
}
```

Catatan:
- Endpoint ini melakukan soft delete pada data patient dan user terkait (jika ada).
- Data tidak hilang permanen dari database, hanya terisi deleted_at.
- Saat ini endpoint belum membatasi role/ownership (authorization) di level controller.

---

# API Master Prosedur

Base URL:
http://localhost:8000

## 1) Create Prosedur

- Method: POST
- Endpoint: /api/procedures
- Headers:
  - Content-Type: application/json
  - Accept: application/json

Request body:
```json
{
  "procedure_name": "Scaling Gigi",
  "base_price": 350000,
  "is_active": true
}
```

Success response (201):
```json
{
  "success": true,
  "message": "Data prosedur berhasil dibuat",
  "data": {
    "id": "uuid",
    "procedure_name": "Scaling Gigi",
    "base_price": "350000.00",
    "is_active": true,
    "created_at": "2026-03-25T10:00:00.000000Z",
    "updated_at": "2026-03-25T10:00:00.000000Z"
  }
}
```

Validation notes:
- `procedure_name` wajib, string, maksimal 150 karakter.
- `base_price` wajib, numeric, minimal 0.
- `is_active` opsional, boolean (default `true`).

## 2) Read Semua Prosedur

- Method: GET
- Endpoint: /api/procedures
- Headers:
  - Accept: application/json

Success response (200):
```json
{
  "success": true,
  "message": "Data prosedur berhasil diambil",
  "data": [
    {
      "id": "uuid",
      "procedure_name": "Scaling Gigi",
      "base_price": "350000.00",
      "is_active": true,
      "created_at": "2026-03-25T10:00:00.000000Z",
      "updated_at": "2026-03-25T10:00:00.000000Z"
    }
  ],
  "count": 1
}
```

## 3) Read Prosedur by ID

- Method: GET
- Endpoint: /api/procedures/{id}
- Headers:
  - Accept: application/json

Contoh:
GET /api/procedures/550e8400-e29b-41d4-a716-446655440000

Success response (200):
```json
{
  "success": true,
  "message": "Data prosedur berhasil diambil",
  "data": {
    "id": "550e8400-e29b-41d4-a716-446655440000",
    "procedure_name": "Scaling Gigi",
    "base_price": "350000.00",
    "is_active": true,
    "created_at": "2026-03-25T10:00:00.000000Z",
    "updated_at": "2026-03-25T10:00:00.000000Z"
  }
}
```

Not found response (404):
```json
{
  "success": false,
  "message": "Data prosedur tidak ditemukan"
}
```

## 4) Update Prosedur by ID

- Method: PUT
- Endpoint: /api/procedures/{id}
- Headers:
  - Content-Type: application/json
  - Accept: application/json

Contoh:
PUT /api/procedures/550e8400-e29b-41d4-a716-446655440000

Request body (partial update diperbolehkan):
```json
{
  "procedure_name": "Scaling + Polishing",
  "base_price": 450000,
  "is_active": true
}
```

Success response (200):
```json
{
  "success": true,
  "message": "Data prosedur berhasil diperbarui",
  "data": {
    "id": "550e8400-e29b-41d4-a716-446655440000",
    "procedure_name": "Scaling + Polishing",
    "base_price": "450000.00",
    "is_active": true,
    "created_at": "2026-03-25T10:00:00.000000Z",
    "updated_at": "2026-03-25T11:00:00.000000Z"
  }
}
```

Not found response (404):
```json
{
  "success": false,
  "message": "Data prosedur tidak ditemukan"
}
```

Validation notes:
- Semua field bersifat opsional (partial update).
- Jika dikirim, `procedure_name` wajib string max 150.
- Jika dikirim, `base_price` wajib numeric minimal 0.
- Jika dikirim, `is_active` wajib boolean.

## 5) Delete Prosedur (Soft Delete)

- Method: DELETE
- Endpoint: /api/procedures/{id}
- Headers:
  - Accept: application/json

Contoh:
DELETE /api/procedures/550e8400-e29b-41d4-a716-446655440000

Success response (200):
```json
{
  "success": true,
  "message": "Data prosedur berhasil dihapus (soft delete)"
}
```

Not found response (404):
```json
{
  "success": false,
  "message": "Data prosedur tidak ditemukan"
}
```

Catatan:
- Endpoint ini melakukan soft delete pada tabel `master_procedure`.
- Data tidak hilang permanen dari database, hanya mengisi kolom `deleted_at`.

---

# API Dokter

Base URL:
http://localhost:8000

## 1) Create Dokter

- Method: POST
- Endpoint: /api/doctors
- Headers:
  - Content-Type: application/json
  - Accept: application/json

Request body:
```json
{
  "full_name": "drg. Jane Doe",
  "email": "jane.doe@klinik.com",
  "password": "password123",
  "phone_number": "081234567890",
  "specialization": "Sp.Ortho",
  "job_title": "Dokter Gigi"
}
```

Success response (201):
```json
{
  "success": true,
  "message": "User dokter dan data dokter berhasil dibuat",
  "data": {
    "user": {
      "id": "uuid",
      "role_id": "role-dct-id",
      "name": "drg. Jane Doe",
      "email": "jane.doe@klinik.com",
      "is_active": true,
      "is_verified": true,
      "created_at": "2026-03-26T10:00:00.000000Z",
      "updated_at": "2026-03-26T10:00:00.000000Z"
    },
    "doctor": {
      "id": "uuid",
      "user_id": "uuid",
      "full_name": "drg. Jane Doe",
      "email": "jane.doe@klinik.com",
      "phone_number": "081234567890",
      "specialization": "Sp.Ortho",
      "job_title": "Dokter Gigi",
      "is_active": true,
      "created_at": "2026-03-26T10:00:00.000000Z",
      "updated_at": "2026-03-26T10:00:00.000000Z"
    }
  }
}
```

Validation notes:
- `full_name`, `email`, `password` wajib.
- `email` harus unik pada tabel `user`.
- Jika role `DCT` tidak ada, API mengembalikan 422.
- Endpoint create dokter hanya bisa diakses admin yang sudah login (session/cookie auth).
- Untuk alur web, pembuatan akun dokter dilakukan dari halaman admin: `/admin/settings?menu=manajemen-staff`.

## 2) Read Semua Dokter

- Method: GET
- Endpoint: /api/doctors
- Headers:
  - Accept: application/json

Success response (200):
```json
{
  "success": true,
  "message": "Data dokter berhasil diambil",
  "data": [
    {
      "id": "uuid",
      "user_id": "uuid",
      "full_name": "drg. Jane Doe",
      "email": "jane.doe@klinik.com",
      "phone_number": "081234567890",
      "specialization": "Sp.Ortho",
      "job_title": "Dokter Gigi",
      "is_active": true,
      "created_at": "2026-03-26T10:00:00.000000Z",
      "updated_at": "2026-03-26T10:00:00.000000Z"
    }
  ],
  "count": 1
}
```

## 3) Read Dokter by ID

- Method: GET
- Endpoint: /api/doctors/{id}
- Headers:
  - Accept: application/json

Contoh:
GET /api/doctors/550e8400-e29b-41d4-a716-446655440000

Success response (200):
```json
{
  "success": true,
  "message": "Data dokter berhasil diambil",
  "data": {
    "id": "550e8400-e29b-41d4-a716-446655440000",
    "user_id": "uuid",
    "full_name": "drg. Jane Doe",
    "email": "jane.doe@klinik.com",
    "phone_number": "081234567890",
    "specialization": "Sp.Ortho",
    "job_title": "Dokter Gigi",
    "is_active": true,
    "created_at": "2026-03-26T10:00:00.000000Z",
    "updated_at": "2026-03-26T10:00:00.000000Z"
  }
}
```

Not found response (404):
```json
{
  "success": false,
  "message": "Data dokter tidak ditemukan"
}
```

## 4) Update Dokter by ID

- Method: PUT
- Endpoint: /api/doctors/{id}
- Headers:
  - Content-Type: application/json
  - Accept: application/json
  - Authorization/Cookie Session login user

Contoh:
PUT /api/doctors/550e8400-e29b-41d4-a716-446655440000

Request body (partial update diperbolehkan):
```json
{
  "full_name": "drg. Jane Doe, M.Kes",
  "email": "jane.new@klinik.com",
  "password": "passwordBaru123",
  "specialization": "Sp.Ortho",
  "is_active": true
}
```

Success response (200):
```json
{
  "success": true,
  "message": "Data dokter berhasil diperbarui",
  "data": {
    "user": {
      "id": "uuid",
      "name": "drg. Jane Doe, M.Kes",
      "email": "jane.new@klinik.com"
    },
    "doctor": {
      "id": "550e8400-e29b-41d4-a716-446655440000",
      "full_name": "drg. Jane Doe, M.Kes",
      "email": "jane.new@klinik.com",
      "specialization": "Sp.Ortho",
      "is_active": true,
      "updated_at": "2026-03-26T11:00:00.000000Z"
    }
  }
}
```

Unauthorized response (401):
```json
{
  "success": false,
  "message": "Unauthenticated"
}
```

Forbidden response (403):
```json
{
  "success": false,
  "message": "Anda tidak memiliki akses untuk mengubah data dokter ini"
}
```

## 5) Delete Dokter by ID

- Method: DELETE
- Endpoint: /api/doctors/{id}
- Headers:
  - Accept: application/json
  - Authorization/Cookie Session login user

Contoh:
DELETE /api/doctors/550e8400-e29b-41d4-a716-446655440000

Success response (200):
```json
{
  "success": true,
  "message": "Data dokter berhasil dihapus"
}
```

Unauthorized response (401):
```json
{
  "success": false,
  "message": "Unauthenticated"
}
```

Forbidden response (403):
```json
{
  "success": false,
  "message": "Anda tidak memiliki akses untuk mengubah data dokter ini"
}
```

Catatan:
- Endpoint delete akan menghapus data dokter dan soft delete user terkait.
- Admin bisa update/delete semua data dokter, dokter hanya bisa update/delete data miliknya sendiri.

---

# API Doctor Note

Base URL:
http://localhost:8000

## 1) Create Doctor Note

- Method: POST
- Endpoint: /api/doctor-notes
- Headers:
  - Content-Type: application/json
  - Accept: application/json

Request body:
```json
{
  "procedure_id": "mp-1",
  "user_id": "user-2",
  "notes": "Pasien mengeluh nyeri saat mengunyah di gigi molar kanan bawah."
}
```

Success response (201):
```json
{
  "success": true,
  "message": "Data doctor note berhasil dibuat",
  "data": {
    "id": "dn-1",
    "procedure_id": "mp-1",
    "user_id": "user-2",
    "notes": "Pasien mengeluh nyeri saat mengunyah di gigi molar kanan bawah.",
    "deleted_at": null
  }
}
```

Validation notes:
- `procedure_id` harus ada di tabel medical_procedure (foreign key check).
- `user_id` harus ada di tabel user (foreign key check).
- Catatan: DoctorNote tidak memiliki kolom created_at/updated_at, hanya id, procedure_id, user_id, notes, dan deleted_at.

## 2) Read Doctor Note by ID

- Method: GET
- Endpoint: /api/doctor-notes/{id}
- Headers:
  - Accept: application/json

Contoh:
GET /api/doctor-notes/dn-1

Success response (200):
```json
{
  "success": true,
  "message": "Data doctor note berhasil diambil",
  "data": {
    "id": "dn-1",
    "procedure_id": "mp-1",
    "user_id": "user-2",
    "notes": "Pasien mengeluh nyeri saat mengunyah di gigi molar kanan bawah.",
    "deleted_at": null,
    "medical_procedure": {
      "id": "mp-1",
      "registration_id": "reg-1",
      "patient_id": "pat-1",
      "doctor_id": "doc-1",
      "discount_type": "none",
      "discount_value": "0.00",
      "total_amount": "300000.00",
      "notes": "Perawatan scaling gigi umum",
      "created_at": "2026-03-27T10:30:00.000000Z",
      "updated_at": "2026-03-27T10:30:00.000000Z",
      "deleted_at": null
    },
    "user": {
      "id": "user-2",
      "role_id": "role-dct-id",
      "name": "drg. Jane Doe",
      "email": "jane.doe@klinik.com",
      "is_active": true,
      "is_verified": true,
      "created_at": "2026-03-26T10:00:00.000000Z",
      "updated_at": "2026-03-26T10:00:00.000000Z"
    }
  }
}
```

Not found response (404):
```json
{
  "success": false,
  "message": "Data doctor note tidak ditemukan"
}
```

Catatan:
- Response includes relasi `medical_procedure` (data dari tabel medical_procedure) dan `user` (data dari tabel user yang mengisi notes).

## 3) Update Doctor Note by ID

- Method: PUT
- Endpoint: /api/doctor-notes/{id}
- Headers:
  - Content-Type: application/json
  - Accept: application/json

Contoh:
PUT /api/doctor-notes/dn-1

Request body (partial update diperbolehkan):
```json
{
  "notes": "Keluhan berkurang setelah tindakan scaling."
}
```

Success response (200):
```json
{
  "success": true,
  "message": "Data doctor note berhasil diperbarui",
  "data": {
    "id": "dn-1",
    "procedure_id": "mp-1",
    "user_id": "user-2",
    "notes": "Keluhan berkurang setelah tindakan scaling.",
    "deleted_at": null
  }
}
```

## 4) Delete Doctor Note by ID (Soft Delete)

- Method: DELETE
- Endpoint: /api/doctor-notes/{id}
- Headers:
  - Accept: application/json

Contoh:
DELETE /api/doctor-notes/dn-1

Success response (200):
```json
{
  "success": true,
  "message": "Data doctor note berhasil dihapus (soft delete)"
}
```

Catatan:
- Endpoint ini melakukan soft delete dengan mengisi kolom deleted_at.
- Data tidak hilang permanen dari database.

---

# API Medical Procedure

Base URL:
http://localhost:8000

## 1) Create Medical Procedure

- Method: POST
- Endpoint: /api/medical-procedures
- Headers:
  - Content-Type: application/json
  - Accept: application/json

Request body:
```json
{
  "registration_id": "reg-1",
  "patient_id": "pat-1",
  "doctor_id": "doc-1",
  "discount_type": "none",
  "discount_value": 0,
  "total_amount": 300000,
  "notes": "Perawatan scaling gigi umum"
}
```

Success response (201):
```json
{
  "success": true,
  "message": "Data medical procedure berhasil dibuat",
  "data": {
    "id": "mp-1",
    "registration_id": "reg-1",
    "patient_id": "pat-1",
    "doctor_id": "doc-1",
    "discount_type": "none",
    "discount_value": "0.00",
    "total_amount": "300000.00",
    "notes": "Perawatan scaling gigi umum",
    "created_at": "2026-03-27T10:30:00.000000Z",
    "updated_at": "2026-03-27T10:30:00.000000Z",
    "deleted_at": null
  }
}
```

Validation notes:
- `registration_id`, `patient_id`, `doctor_id` harus ada di tabel masing-masing (foreign key check).
- `discount_type`: 'none' | 'percentage' | 'fix'
- `discount_value` dan `total_amount` diformat sebagai decimal dengan 2 desimal.

## 2) Read Medical Procedure by ID

- Method: GET
- Endpoint: /api/medical-procedures/{id}
- Headers:
  - Accept: application/json

Contoh:
GET /api/medical-procedures/mp-1

Success response (200):
```json
{
  "success": true,
  "message": "Data medical procedure berhasil diambil",
  "data": {
    "id": "mp-1",
    "registration_id": "reg-1",
    "patient_id": "pat-1",
    "doctor_id": "doc-1",
    "discount_type": "none",
    "discount_value": "0.00",
    "total_amount": "300000.00",
    "notes": "Perawatan scaling gigi umum",
    "created_at": "2026-03-27T10:30:00.000000Z",
    "updated_at": "2026-03-27T10:30:00.000000Z",
    "deleted_at": null,
    "registration": {
      "id": "reg-1",
      "appointment_datetime": "2026-03-27T14:00:00.000000Z",
      "patient_id": "pat-1",
      "doctor_id": "doc-1",
      "poli_id": "pol-1",
      "status": "scheduled",
      "created_at": "2026-03-27T09:00:00.000000Z",
      "updated_at": "2026-03-27T09:00:00.000000Z",
      "deleted_at": null
    },
    "patient": {
      "id": "pat-1",
      "user_id": "user-pat-1",
      "full_name": "Muhammad Farhan",
      "email": "farhan@gmail.com",
      "medical_record_no": "MR202603270001",
      "date_of_birth": "2001-04-12",
      "gender": "Male",
      "blood_type": "O",
      "rhesus": "+",
      "address": "Jl. Bandung No 10",
      "phone_number": "081234567890",
      "city": "Bandung",
      "id_card_number": "087726425124",
      "allergy_history": "Tidak ada",
      "created_at": "2026-03-18T10:00:00.000000Z",
      "updated_at": "2026-03-18T10:00:00.000000Z",
      "deleted_at": null
    },
    "doctor": {
      "id": "doc-1",
      "user_id": "user-dct-1",
      "full_name": "drg. Jane Doe",
      "email": "jane.doe@klinik.com",
      "phone_number": "081234567890",
      "specialization": "Sp.Ortho",
      "job_title": "Dokter Gigi",
      "is_active": true,
      "created_at": "2026-03-26T10:00:00.000000Z",
      "updated_at": "2026-03-26T10:00:00.000000Z",
      "deleted_at": null
    }
  }
}
```

Not found response (404):
```json
{
  "success": false,
  "message": "Data medical procedure tidak ditemukan"
}
```

Catatan:
- Response includes relasi `registration` (data dari tabel registration), `patient` (data dari tabel patient), dan `doctor` (data dari tabel doctor).

## 3) Update Medical Procedure by ID

- Method: PUT
- Endpoint: /api/medical-procedures/{id}
- Headers:
  - Content-Type: application/json
  - Accept: application/json

Contoh:
PUT /api/medical-procedures/mp-1

Request body (partial update diperbolehkan):
```json
{
  "discount_type": "percentage",
  "discount_value": 10,
  "total_amount": 270000
}
```

Success response (200):
```json
{
  "success": true,
  "message": "Data medical procedure berhasil diperbarui",
  "data": {
    "id": "mp-1",
    "registration_id": "reg-1",
    "patient_id": "pat-1",
    "doctor_id": "doc-1",
    "discount_type": "percentage",
    "discount_value": "10.00",
    "total_amount": "270000.00",
    "notes": "Perawatan scaling gigi umum",
    "created_at": "2026-03-27T10:30:00.000000Z",
    "updated_at": "2026-03-27T10:45:00.000000Z",
    "deleted_at": null
  }
}
```

## 4) Delete Medical Procedure by ID (Soft Delete)

- Method: DELETE
- Endpoint: /api/medical-procedures/{id}
- Headers:
  - Accept: application/json

Contoh:
DELETE /api/medical-procedures/mp-1

Success response (200):
```json
{
  "success": true,
  "message": "Data medical procedure berhasil dihapus (soft delete)"
}
```

Catatan:
- Endpoint ini melakukan soft delete dengan mengisi kolom deleted_at.
- Data tidak hilang permanen dari database.

---

# API Procedure Item

Base URL:
http://localhost:8000

## 1) Create Procedure Item

- Method: POST
- Endpoint: /api/procedure-items
- Headers:
  - Content-Type: application/json
  - Accept: application/json

Request body:
```json
{
  "procedure_id": "mp-1",
  "master_procedure_id": "mpr-1",
  "quantity": 1,
  "unit_price": 300000,
  "discount_type": "none",
  "discount_value": 0,
  "subtotal": 300000
}
```

Success response (201):
```json
{
  "success": true,
  "message": "Data procedure item berhasil dibuat",
  "data": {
    "id": "pi-1",
    "procedure_id": "mp-1",
    "master_procedure_id": "mpr-1",
    "quantity": 1,
    "unit_price": "300000.00",
    "discount_type": "none",
    "discount_value": "0.00",
    "subtotal": "300000.00",
    "deleted_at": null
  }
}
```

Validation notes:
- `procedure_id` dan `master_procedure_id` harus ada di tabel masing-masing (foreign key check).
- `quantity` harus integer > 0.
- `discount_type`: 'none' | 'percentage' | 'fix'
- `unit_price`, `discount_value`, `subtotal` diformat sebagai decimal dengan 2 desimal.
- Catatan: ProcedureItem tidak memiliki kolom created_at/updated_at.

## 2) Read Procedure Item by ID

- Method: GET
- Endpoint: /api/procedure-items/{id}
- Headers:
  - Accept: application/json

Contoh:
GET /api/procedure-items/pi-1

Success response (200):
```json
{
  "success": true,
  "message": "Data procedure item berhasil diambil",
  "data": {
    "id": "pi-1",
    "procedure_id": "mp-1",
    "master_procedure_id": "mpr-1",
    "quantity": 1,
    "unit_price": "300000.00",
    "discount_type": "none",
    "discount_value": "0.00",
    "subtotal": "300000.00",
    "deleted_at": null,
    "medical_procedure": {
      "id": "mp-1",
      "registration_id": "reg-1",
      "patient_id": "pat-1",
      "doctor_id": "doc-1",
      "discount_type": "none",
      "discount_value": "0.00",
      "total_amount": "300000.00",
      "notes": "Perawatan scaling gigi umum",
      "created_at": "2026-03-27T10:30:00.000000Z",
      "updated_at": "2026-03-27T10:30:00.000000Z",
      "deleted_at": null
    },
    "master_procedure": {
      "id": "mpr-1",
      "procedure_name": "Scaling Gigi",
      "base_price": "350000.00",
      "is_active": true,
      "created_at": "2026-03-25T10:00:00.000000Z",
      "updated_at": "2026-03-25T10:00:00.000000Z"
    }
  }
}
```

Not found response (404):
```json
{
  "success": false,
  "message": "Data procedure item tidak ditemukan"
}
```

Catatan:
- Response includes relasi `medical_procedure` (data dari tabel medical_procedure) dan `master_procedure` (data dari tabel master_procedure).

## 3) Update Procedure Item by ID

- Method: PUT
- Endpoint: /api/procedure-items/{id}
- Headers:
  - Content-Type: application/json
  - Accept: application/json

Contoh:
PUT /api/procedure-items/pi-1

Request body (partial update diperbolehkan):
```json
{
  "quantity": 2,
  "discount_type": "percentage",
  "discount_value": 5,
  "subtotal": 570000
}
```

Success response (200):
```json
{
  "success": true,
  "message": "Data procedure item berhasil diperbarui",
  "data": {
    "id": "pi-1",
    "procedure_id": "mp-1",
    "master_procedure_id": "mpr-1",
    "quantity": 2,
    "unit_price": "300000.00",
    "discount_type": "percentage",
    "discount_value": "5.00",
    "subtotal": "570000.00",
    "deleted_at": null
  }
}
```

## 4) Delete Procedure Item by ID (Soft Delete)

- Method: DELETE
- Endpoint: /api/procedure-items/{id}
- Headers:
  - Accept: application/json

Contoh:
DELETE /api/procedure-items/pi-1

Success response (200):
```json
{
  "success": true,
  "message": "Data procedure item berhasil dihapus (soft delete)"
}
```

Catatan:
- Endpoint ini melakukan soft delete dengan mengisi kolom deleted_at.
- Data tidak hilang permanen dari database.
