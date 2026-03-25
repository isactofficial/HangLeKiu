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
  "city": "Bandung",
  "id_card_number": "087726425124",
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
  - Authorization/Cookie Session login user

Contoh:
PUT /api/patients/550e8400-e29b-41d4-a716-446655440000

Request body (partial update diperbolehkan):
```json
{
  "full_name": "Muhammad Farhan Update",
  "email": "farhan.update@gmail.com",
  "password": "passwordBaru123",
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
  "message": "Anda tidak memiliki akses untuk mengubah data pasien ini"
}
```

Validation notes:
- Semua field bersifat opsional (partial update).
- Jika mengirim email, email harus unik pada tabel user (kecuali milik user pasien yang sedang diupdate).
- Jika mengirim password kosong/null, password user tidak diubah.

## 5) Delete Pasien (Soft Delete)

- Method: DELETE
- Endpoint: /api/patients/{id}
- Headers:
  - Accept: application/json
  - Authorization/Cookie Session login user

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
  "message": "Anda tidak memiliki akses untuk mengubah data pasien ini"
}
```

Catatan:
- Endpoint ini melakukan soft delete pada data patient dan user terkait (jika ada).
- Data tidak hilang permanen dari database, hanya terisi deleted_at.
- Admin bisa update/delete semua data pasien, user hanya bisa update/delete data miliknya sendiri.
