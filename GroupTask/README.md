## Appointments System - PHP REST API

Base URL when served from `htdocs/GroupTask/api`:

- `http://localhost/GroupTask/api`

### Endpoints

- POST `/appointments` — create a new appointment
- GET `/appointments` — list appointments (latest first)
- GET `/appointments/{id}` — get a single appointment
- PUT `/appointments/{id}` — update fields of an appointment

### Request/Response Examples

Create:

```bash
curl -X POST http://localhost/GroupTask/api/appointments \
  -H "Content-Type: application/json" \
  -d '{
    "national_id": "0123456789",
    "full_name": "محمد",
    "phone_number": "0500000000",
    "appointment_date": "2025-09-17",
    "appointment_reason": "شكوى",
    "reason_description": "وصف مختصر"
  }'
```

Response 201:

```json
{ "message": "Appointment created", "id": 1 }
```

List:

```bash
curl http://localhost/GroupTask/api/appointments?limit=25
```

Get by id:

```bash
curl http://localhost/GroupTask/api/appointments/1
```

Update:

```bash
curl -X PUT http://localhost/GroupTask/api/appointments/1 \
  -H "Content-Type: application/json" \
  -d '{ "appointment_date": "2025-10-01", "appointment_reason": "استفسار" }'
```

Response 200:

```json
{ "message": "Appointment updated" }
```

### Database

Expected table `appointments` with columns:
- `id` INT AUTO_INCREMENT PRIMARY KEY
- `national_id` VARCHAR(32)
- `full_name` VARCHAR(255)
- `phone_number` VARCHAR(32)
- `appointment_date` DATE
- `appointment_reason` VARCHAR(255)
- `reason_description` TEXT
- `created_at` DATETIME

Update database credentials in `api/config/database.php` if needed.


