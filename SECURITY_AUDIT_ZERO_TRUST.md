# Zero-Trust Security Audit — LMS-Digi-Sindh

**Date:** 2025-02-27  
**Scope:** Attack surface reduction, Biometric API hardening, vulnerability scan, session/DB security.

---

## 1. Deleted Files (Attack Surface Reduction)

| File | Reason |
|------|--------|
| `app/Http/Controllers/Instructor/CheckInController.php` | Already removed in prior biometric-only migration; manual check-in decommissioned. |
| `app/Http/Controllers/Student/QrAttendanceController.php` | Already removed; QR attendance decommissioned. |
| `resources/views/student/attendance/qr.blade.php` | Already removed; QR UI removed. |
| `resources/views/instructor/batches/attendance-take.blade.php` | **Deleted this audit.** Dead code; take attendance is biometric-only and route redirects. Removes unused form surface. |

**Routes retained but neutered:**  
`/instructor/check-in`, `/instructor/check-out`, `/student/attendance/qr/{batch}`, `/student/attendance/qr-mark` now redirect to `/attendance/biometric-only` (no logic executed).

---

## 2. Default / Demo / Install Routes

| Route | Status | Notes |
|-------|--------|-------|
| `/install` (GET/POST) | **Retained, protected** | Wrapped in `install.guard` middleware. When `storage/installed` exists, access redirects to login. No test/debug routes found. |
| `/dsimt/testimonial` | **Legitimate** | Public DSIMT testimonial page, not a test route. |
| `/test`, `/debug`, `/demo` | **None found** | No such routes in `routes/web.php` or `routes/api.php`. |

**Recommendation:** In production, ensure `storage/installed` exists after first install so `/install` is never accessible.

---

## 3. Biometric API Hardening

### 3.1 Strict Validation (`BiometricPunchRequest`)

- **machine_user_id:** `required|string|max:50|regex:/^[A-Za-z0-9_\-\.]+$/` (alphanumeric, underscore, hyphen, dot only).
- **device_id:** `nullable|string|max:100|regex:/^[A-Za-z0-9_\-\.]+$/`.
- **scan_time:** `required|date|before_or_equal:end_of_today` (no future timestamps).
- **type:** `nullable|in:Fingerprint,Face,Card`.

Custom messages added for regex and date rules.

### 3.2 Rate Limiting

- **Before:** `throttle:120,1` (120 requests/minute per IP).
- **After:** `throttle:60,1` (60 requests/minute per IP) to reduce brute-force and DDoS risk.

### 3.3 Authentication

- **Guard:** Token-based (not Sanctum user sessions). Biometric devices use a shared secret; Sanctum is for browser/SPA user auth.
- **Middleware:** `ValidateBiometricToken` — accepts token via `Authorization: Bearer`, `X-Biometric-Token` header, or `api_token` input. Compared to `config('services.biometric.token')` (from `BIOMETRIC_API_TOKEN` in `.env`).
- **Hardening:** Removed fallback to `env('BIOMETRIC_API_TOKEN')` inside middleware; token is read only from `config()` so values are cached and not read from env on every request.
- **Optional:** Device allowlist via `BIOMETRIC_DEVICE_IDS` (comma-separated); when set, `device_id` must be in the list.

---

## 4. Vulnerability Scan

### 4.1 Mass Assignment

- **Audit:** All 38 models use `$fillable`; no `$guarded = []` or fully unguarded models found.
- **User model:** `password` is in `$fillable`; Laravel hashes it via `'password' => 'hashed'` cast. No change.

### 4.2 File Upload Security

- **Biometric:** No CSV/Excel import for biometric data. Admin has “Sync” (runs `biometric:process` command) and “Export” (download only). No file upload on biometric API.
- **Assignment submission (student):** Validation already had `mimes:pdf,doc,docx,txt,zip,py,js,html,css,java`. **Added:** Closure to reject extensions `php`, `phtml`, `phar`, `exe`, `dll`.
- **Course content (instructor):** Same MIME list; **added** same extension blacklist for `store` and `update`.
- **Receipt upload (student):** Already restricted to `image` (MIME). No change.
- **Storage:** Added `storage/app/public/.htaccess` to deny execution of `.php`, `.php3`, `.php4`, `.php5`, `.phtml`, `.phar`, `.exe`, `.dll` in the public disk (uploaded files).

### 4.3 Hardcoded Credentials / API Keys

- **Scan:** No hardcoded passwords, secrets, or long-lived API keys found in `app/`.
- **Config:** Biometric token and related options read from `config('services.biometric.*')` (env-backed). Middleware uses config only.

---

## 5. Database & Session Security

### 5.1 Session Cookies

- **HttpOnly:** `config/session.php`: `http_only` defaults to `true` (env `SESSION_HTTP_ONLY`); cast to `(bool)` for clarity.
- **Secure:** `secure` set to `env('SESSION_SECURE_COOKIE', env('APP_ENV') === 'production')` so in production (when `APP_ENV=production`) session cookie is Secure by default unless overridden.

### 5.2 Sensitive Data at Rest

- **Application-level:** Laravel does not encrypt DB columns by default. For PII (e.g. `user_details.cnic`, `mobile`), consider:
  - Laravel’s `encrypted` cast for specific columns (requires key in `.env` and handling of search/display).
  - Or rely on infrastructure: MySQL TDE, disk encryption, and restricted DB access.
- **Recommendation:** Use encrypted casting for high-sensitivity fields if required by policy; otherwise document that DB and backups are protected at the infrastructure layer.

---

## 6. Summary of Security Patches Applied

| Area | Patch |
|------|--------|
| **Attack surface** | Deleted `attendance-take.blade.php`. Confirmed no test/debug routes; install protected by middleware. |
| **Biometric API** | Stricter validation (regex, no future `scan_time`), 60/min throttle, token from config only. |
| **File upload** | Assignment and course-content uploads reject `.php`, `.phtml`, `.phar`, `.exe`, `.dll`. `.htaccess` in `storage/app/public` denies execution of scripts. |
| **Session** | Secure cookie default in production; HttpOnly explicitly bool. |
| **Secrets** | No hardcoded credentials; biometric token from config/env. |

---

## 7. Files Modified (This Audit)

- `app/Http/Requests/BiometricPunchRequest.php` — Validation and messages.
- `routes/api.php` — Throttle 120 → 60.
- `app/Http/Middleware/ValidateBiometricToken.php` — Use config only for token.
- `config/session.php` — Secure default in production, HttpOnly bool.
- `app/Http/Controllers/Student/AssignmentController.php` — Extension blacklist for file upload.
- `app/Http/Controllers/Instructor/ContentController.php` — Extension blacklist for file upload (store + update).
- `storage/app/public/.htaccess` — New; deny execution of script/executable extensions.

---

## 8. Recommended Next Steps

1. **Production:** Set `APP_ENV=production`, `SESSION_SECURE_COOKIE=true` (or rely on default), and ensure `storage/installed` exists.
2. **Biometric:** Use a long, random `BIOMETRIC_API_TOKEN` (e.g. `php artisan tinker` → `Str::random(64)`).
3. **Optional:** Add `BIOMETRIC_DEVICE_IDS` allowlist for known scanner IDs.
4. **Optional:** Encrypt PII columns (e.g. `user_details.cnic`, `mobile`) with Laravel’s `encrypted` cast if required by policy.
5. **Super Admin settings:** Legacy “Instructor check-in allowed IPs” and “Student QR attendance – GPS” are unused after biometric-only; consider removing or hiding the UI in a future cleanup.
