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
