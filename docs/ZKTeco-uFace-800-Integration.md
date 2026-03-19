# ZKTeco uFace 800 – LMS Digi Sindh Integration

This guide explains how to connect your **ZKTeco uFace 800** (or compatible devices) to the LMS so attendance is recorded automatically. The LMS supports **push** (device sends to LMS), **pull** (LMS connects to device via IP:4370), and **JSON API** (middleware posts to LMS).

---

## 1. Prerequisites

- **LMS** is deployed and reachable from your network (or the device has internet access to your LMS URL).
- **API token** is set in `.env` as `BIOMETRIC_API_TOKEN` (e.g. generate with `php artisan tinker` → `Str::random(64)`).
- **Users** in the LMS have **Biometric ID** set in their profile so it matches the **user ID (PIN)** on the uFace 800.

---

## 2. Map device user ID to LMS users

On the uFace 800, each person is identified by a **user ID** (often called PIN, e.g. `1`, `2`, `1005`). The LMS maps this to a user via **Biometric ID** in **User Details**.

1. In LMS: **Users** → edit a user → **User Details** (or equivalent).
2. Set **Biometric ID** to the **exact** user ID used on the uFace 800 (e.g. `1005`).
3. Save. Repeat for all users who will punch on the device.

If Biometric ID is missing or different, punches will be stored in **biometric_punch_failures** with reason “User not found”.

---

## 3. Option A – Device push (recommended)

The uFace 800 can **push** attendance to a URL (ZKTeco “cdata” / ATTLOG style). The LMS provides an endpoint that accepts this format.

### 3.1 Push URL

Use this URL on the device (replace with your LMS domain and token):

```
https://YOUR-LMS-DOMAIN.com/api/biometric/zkteco?api_token=YOUR_BIOMETRIC_API_TOKEN
```

Example:

```
https://lms.digisindh.example.com/api/biometric/zkteco?api_token=abc123...your-long-token
```

Optional: if you use **device allowlist** (see below), include the device serial so the middleware can check it:

```
https://YOUR-LMS-DOMAIN.com/api/biometric/zkteco?api_token=TOKEN&SN=DEVICE_SERIAL
```

### 3.2 Configure the uFace 800

1. Log in to the **web interface** of the uFace 800 (or use the device menu if it supports “Push URL”).
2. Find **Communication** / **Server** / **Push** or **Real-time event URL** (wording depends on firmware).
3. Set the **push URL** to the URL above (with your domain and token).
4. Ensure the device can reach the LMS (network/firewall and HTTPS if applicable).
5. Save and test by scanning once; check LMS **Biometric logs** or **Sync/Import Scanner Data** (and run `biometric:process` if needed).

The LMS expects a **POST** request with **tab-separated** body lines:

- Each line: `PIN`, `DateTime`, `Status`, `VerifyType`, ...
- Example: `1005\t2025-02-27 09:15:00\t0\t15\t...`

The endpoint responds with `OK` (text/plain) so the device considers the push successful.

### 3.3 Scanner has a local IP and is connected to the internet

Your biometric scanner has a **local IP** (e.g. 192.168.1.105) and is **connected to the internet**. You can use either a **local** or **public** push URL, depending on where the LMS runs.

| Where the LMS runs | Push URL to use | Notes |
|--------------------|-----------------|--------|
| **Same local network** (e.g. Laragon on your PC or a server in the office) | `http://LOCAL_IP_OF_LMS/api/biometric/zkteco?api_token=TOKEN` | Use the **LMS machine’s local IP** (e.g. `http://192.168.1.50/...`). Scanner and LMS must be on the same network. Prefer **HTTP** for local IP (no SSL needed). |
| **On the internet** (hosted server, cloud, or public URL) | `https://YOUR-LMS-DOMAIN.com/api/biometric/zkteco?api_token=TOKEN` | Because the scanner has internet, it can reach the public URL. Use **HTTPS** if your LMS uses SSL. |

**If the LMS is on your PC (e.g. Laragon):**

1. Find your PC’s local IP:
   - **Windows:** `ipconfig` → look for **IPv4 Address** (e.g. 192.168.1.50).
   - **Mac/Linux:** `ifconfig` or `ip addr`.
2. On the scanner, set the push URL to:
   ```text
   http://192.168.1.50/api/biometric/zkteco?api_token=YOUR_TOKEN
   ```
   (Replace `192.168.1.50` with your PC’s IP and use your real token.)
3. Ensure **Windows Firewall** (or your firewall) allows **inbound** HTTP (port 80) or the port your LMS uses (e.g. 8000 for `php artisan serve`) from the local network. If you use a different port, include it: `http://192.168.1.50:8000/api/biometric/zkteco?api_token=...`.

**If the LMS is on the internet:** use the public URL with `https://` (if you have SSL). The scanner’s internet connection is enough for it to reach that URL.

---

## 4. Option C – LMS pulls from uFace 800 (recommended when device is on same network)

When the uFace 800 has a **local IP** and the **LMS server can reach it** (same LAN or VPN), the LMS can **pull** attendance from the device every 5 minutes and on demand.

### 4.1 Configuration

1. In `.env` set the device IP and optional port/device ID:
   ```env
   ZKTECO_IP=192.168.1.201
   ZKTECO_PORT=4370
   ZKTECO_DEVICE_ID=uface800-1
   ```
2. Ensure the server can reach the device on **UDP port 4370** (firewall/network).

### 4.2 Automatic pull (every 5 minutes)

The scheduler runs:
```bash
php artisan biometric:pull-zkteco --process
```
every 5 minutes. Ensure the Laravel scheduler is running (e.g. cron: `* * * * * php /path/to/artisan schedule:run`).

### 4.3 Manual pull – “Sync Now with uFace 800”

In **Admin → Attendance & Payroll**, use the **Sync Now with uFace 800** button to pull immediately from the device and process logs into attendance. No device push URL is required.

### 4.4 Duplicate prevention

If the same punch is pulled more than once, the system **does not create a duplicate** log: it matches `user_id` + `device_id` + `scan_time` and skips existing rows.

---

## 5. Option B – JSON API (middleware or third-party software)

If you use **middleware** (e.g. ZKTeco’s own or a small script) that can send **HTTP POST with JSON**, use the standard biometric punch API:

- **URL:** `POST https://YOUR-LMS-DOMAIN.com/api/biometric/punch`
- **Headers:**
  - `Authorization: Bearer YOUR_BIOMETRIC_API_TOKEN`  
  **or**  
  - `X-Biometric-Token: YOUR_BIOMETRIC_API_TOKEN`
- **Body (JSON):**
  - `machine_user_id` (required) – user ID on the device (e.g. `1005`)
  - `scan_time` (required) – date/time of punch, e.g. `2025-02-27 09:15:00`
  - `device_id` (optional) – e.g. device serial
  - `type` (optional) – `Fingerprint`, `Face`, or `Card`

Example:

```json
{
  "machine_user_id": "1005",
  "scan_time": "2025-02-27 09:15:00",
  "device_id": "UFACE800-001",
  "type": "Face"
}
```

Again, ensure each user has **Biometric ID** in the LMS set to the same value as `machine_user_id`.

---

## 5. Optional: Device allowlist

To allow only specific devices:

1. In `.env` add (comma-separated serials):
   ```env
   BIOMETRIC_DEVICE_IDS=UFACE800-001,DEVICE_SERIAL_2
   ```
2. For **Option A** (push): use the URL with `SN=...` (or ensure the device sends its serial in the push so the LMS can read it; the ZKTeco endpoint uses query `SN` as device_id for the allowlist).
3. For **Option B**: send `device_id` in the JSON body (or `X-Device-ID` header).

Only requests with a matching device_id/SN are accepted when `BIOMETRIC_DEVICE_IDS` is set.

---

## 6. After punches are received

- Raw punches are stored in **biometric_logs** (and failures in **biometric_punch_failures**).
- Run the **Artisan** command to build attendance from logs:
  ```bash
  php artisan biometric:process
  ```
- Or use the admin **Sync/Import Scanner Data** (or equivalent) if it triggers the same processing.

---

## 7. Troubleshooting

| Issue | What to check |
|-------|----------------|
| 401 Invalid or missing API token | Token in URL (Option A) or header (Option B) must match `BIOMETRIC_API_TOKEN` in `.env`. |
| 403 Device not authorized | If `BIOMETRIC_DEVICE_IDS` is set, the request must include the device serial (SN or device_id). |
| Punches not in LMS | Confirm Biometric ID in user details equals the device user ID (PIN). Check **biometric_punch_failures** for “User not found”. |
| Device says push failed | Ensure URL is HTTPS if your LMS uses HTTPS; device must resolve the domain and reach the server; firewall must allow outbound 443. |
| Throttling (429) | API is limited to 60 requests per minute per IP; normal use is well below this. |
| uFace 800 sync failed: Could not connect | Set `ZKTECO_IP` in `.env` to the device’s IP. Ensure the server can reach the device on UDP port 4370 (same network or VPN). |

---

## Summary

- **Option A:** Configure uFace 800 push URL to  
  `https://YOUR-LMS-DOMAIN.com/api/biometric/zkteco?api_token=TOKEN`  
  (and optionally `&SN=...` for allowlist).
- **Option B:** Use middleware to POST JSON to  
  `https://YOUR-LMS-DOMAIN.com/api/biometric/punch`  
  with `Authorization: Bearer TOKEN` or `X-Biometric-Token: TOKEN`.
- Set **Biometric ID** in the LMS for every user to match the device PIN/user ID.
- Process logs with `php artisan biometric:process` (or the admin sync) to update attendance.
