# Digi Sindh LMS Customizations – Audit & Migration Plan

This document lists all custom Digi Sindh logic added on top of the original Envato LMS, and a plan to isolate it into Traits and Base Controllers for safe core updates.

---

## 1. DSIMT Website Views vs Default

### DSIMT Custom Views (`resources/views/DSIMT-Webiste/`)

| File | Purpose | Original Equivalent |
|------|---------|---------------------|
| `index.blade.php` | Custom marketing home page | `HomeController` → `view('index')` (original landing) |
| `about.blade.php` | About DSIMT | N/A (custom) |
| `contact.blade.php` | Contact form | N/A or different structure |
| `course.blade.php` | Course listing (uses `publishedOnWebsite`) | `pages/course/grid.blade.php` (all courses) |
| `course-detail.blade.php` | Course detail (checks `isPublishedOnWebsite`) | Different course detail view |
| `event.blade.php` | Events listing | May differ in filtering |
| `event-detail.blade.php` | Event detail | — |
| `blog-list.blade.php` | Blog listing | — |
| `blog-detail.blade.php` | Blog post | — |
| `gallery.blade.php` | Gallery | N/A |
| `instructors.blade.php` | Instructors page | N/A |
| `pricing.blade.php` | Pricing | N/A |
| `testimonial.blade.php` | Testimonials | N/A |
| `faq.blade.php` | FAQ | N/A |
| `search.blade.php` | Course search | — |
| `search-detail.blade.php` | Search results | — |
| `comming.blade.php` | Coming soon | N/A |
| `404.blade.php` | Custom 404 | Default error page |
| `layout.blade.php` | DSIMT layout | `layouts.landing` |
| `Header & Footer/*.blade.php` | Header/Footer partials | — |

**Route:** Root `/` and `/dsimt/*` use `DSIMTWebsiteController`. Original home would have used `HomeController@index` → `view('index')`.

---

## 2. Controllers with Custom Digi Sindh Logic

### Fully Custom Controllers (entirely Digi Sindh – safe to keep as-is)

| Controller | Custom Logic |
|------------|--------------|
| `DSIMTWebsiteController` | Marketing website, `publishedOnWebsite()`, DSIMT routes |
| `Admin\FeeManagementController` | Fee dashboard, enrollment approval, vouchers |
| `Admin\InvoiceController` | Invoices, `FeeConfig`, `FeeReminderService`, `FeeVoucherService`, `access_expiry_date` |
| `Admin\DefaulterController` | Fee defaulters list |
| `Student\PaymentRequiredController` | Pay-wall when `access_expiry_date` expired |
| `SuperAdmin\CourseApprovalController` | Course `publication_status` approval workflow |
| `Api\BiometricPunchController` | Biometric device punch ingestion |

### Controllers with Injected Custom Logic (mixed – high risk on update)

| Controller | Custom Logic Injected |
|------------|-----------------------|
| `Admin\EnrollmentController` | `FeeVoucherService` on approve, `batch.monthly_fee`, discount, `access_expiry_date` |
| `Admin\DashboardController` | `FeeVoucherService::markOverdue()`, `Invoice`, `overdueCount` |
| `SuperAdmin\DashboardController` | `FeeVoucherService::markOverdue()`, `Invoice`, `feesCollected*`, `Expense` |
| `Student\ProfileController` | `FeeVoucherService` for vouchers/fee status |
| `Instructor\CourseController` | `publication_status` (draft on create) |
| `Instructor\ContentController` | `publication_status` (pending on submit) |

### Supporting Custom Files (not controllers)

| Type | File(s) |
|------|---------|
| Middleware | `EnsureStudentAccess` (access_expiry_date gate) |
| Helpers | `FeeConfig` |
| Services | `FeeVoucherService`, `FeeReminderService`, `BiometricPunchProcessor`, `AttendanceDeductionService`, `StudentLedgerService`, `EnrollmentTransferService` |
| Console Commands | `FeeReminderCommand`, `AutoBlockFeeDefaultersCommand`, `ProcessBiometricLogsCommand`, `UpgradeOnlineAttendanceCommand` |
| Models (custom/ extended) | `Invoice`, `Payment`, `Enrollment` (access_expiry_date, fees_collected, etc.), `Course` (publication_status, publishedOnWebsite), `UserDetail` (biometric_id), `BiometricLog`, `BiometricAttendance`, `AttendanceDeduction`, `Expense` |

---

## 3. Migration Strategy: Traits & Base Controllers

### Goal

- Move all Digi Sindh–specific logic into Traits and/or Base Controllers.
- Original controllers extend the base or use the trait only when needed.
- On Envato update: replace core controllers; your custom classes remain.

### Proposed Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Base/
│   │   │   ├── DigiSindhAdminController.php    # Base for Admin controllers with fee logic
│   │   │   ├── DigiSindhSuperAdminController.php
│   │   │   └── DigiSindhStudentController.php
│   │   ├── Traits/
│   │   │   ├── UsesFeeVoucherService.php
│   │   │   ├── UsesFeeReminderService.php
│   │   │   ├── UsesFeeConfig.php
│   │   │   ├── UsesCoursePublicationStatus.php
│   │   │   └── UsesEnrollmentFeeLogic.php
│   │   └── [existing controllers - refactor to use traits/base]
```

### Trait Assignments

| Trait | Used By | Logic |
|-------|---------|-------|
| `UsesFeeConfig` | `InvoiceController` | `FeeConfig::requirePaymentApproval()` |
| `UsesFeeVoucherService` | `Admin\EnrollmentController`, `Admin\DashboardController`, `SuperAdmin\DashboardController`, `Student\ProfileController` | Voucher generation, markOverdue |
| `UsesFeeReminderService` | `InvoiceController` | remind() |
| `UsesCoursePublicationStatus` | `Instructor\CourseController`, `Instructor\ContentController` | publication_status draft/pending |
| `UsesEnrollmentFeeLogic` | `Admin\EnrollmentController` | batch.monthly_fee, discount, FeeVoucherService on approve |

### Base Controller Assignments

| Base Controller | Extends | Used By |
|----------------|---------|---------|
| `DigiSindhAdminController` | `Controller` | `Admin\DashboardController`, `Admin\EnrollmentController`, `Admin\InvoiceController`, `Admin\FeeManagementController`, `Admin\DefaulterController` |
| `DigiSindhSuperAdminController` | `Controller` | `SuperAdmin\DashboardController`, `SuperAdmin\CourseApprovalController` |
| `DigiSindhStudentController` | `Controller` | `Student\PaymentRequiredController`, `Student\ProfileController` (fee-related parts) |

### What Stays Untouched on Update

1. **`DSIMTWebsiteController`** – fully custom; keep as-is.
2. **`app/Helpers/FeeConfig.php`** – custom helper.
3. **`app/Services/`** – FeeVoucherService, FeeReminderService, BiometricPunchProcessor, etc.
4. **`app/Http/Middleware/EnsureStudentAccess.php`** – custom middleware.
5. **`app/Http/Controllers/Api/BiometricPunchController.php`** – custom API.
6. **`resources/views/DSIMT-Webiste/`** – all DSIMT views.
7. **`resources/views/admin/fee-management/`** – fee management views.
8. **`resources/views/admin/invoices/`** – invoice views.
9. **`resources/views/admin/defaulters/`** – defaulter views.
10. **`resources/views/student/payment-required.blade.php`** – pay-wall view.
11. **`resources/views/super-admin/course-approval/`** – course approval views.
12. **`routes/web.php`** – DSIMT routes, fee-management routes, payment-required, etc.

### What May Be Replaced on Update (use Traits/Base to isolate)

- `Admin\DashboardController` – only the `markOverdue` + overdue logic is custom.
- `Admin\EnrollmentController` – approve/reject + fee voucher logic is custom.
- `SuperAdmin\DashboardController` – fee/expense KPIs are custom.
- `Instructor\CourseController` – `publication_status` on create.
- `Instructor\ContentController` – `publication_status` on submit.

---

## 4. Quick Reference: Files to Backup Before Update

```
app/Helpers/FeeConfig.php
app/Services/FeeVoucherService.php
app/Services/FeeReminderService.php
app/Services/BiometricPunchProcessor.php
app/Services/AttendanceDeductionService.php
app/Services/StudentLedgerService.php
app/Services/EnrollmentTransferService.php
app/Http/Controllers/DSIMTWebsiteController.php
app/Http/Controllers/Admin/FeeManagementController.php
app/Http/Controllers/Admin/InvoiceController.php
app/Http/Controllers/Admin/DefaulterController.php
app/Http/Controllers/Admin/EnrollmentController.php
app/Http/Controllers/Admin/DashboardController.php
app/Http/Controllers/Student/PaymentRequiredController.php
app/Http/Controllers/Student/ProfileController.php
app/Http/Controllers/SuperAdmin/CourseApprovalController.php
app/Http/Controllers/SuperAdmin/DashboardController.php
app/Http/Controllers/Api/BiometricPunchController.php
app/Http/Controllers/Instructor/CourseController.php
app/Http/Controllers/Instructor/ContentController.php
app/Http/Middleware/EnsureStudentAccess.php
app/Console/Commands/FeeReminderCommand.php
app/Console/Commands/AutoBlockFeeDefaultersCommand.php
app/Console/Commands/ProcessBiometricLogsCommand.php
app/Console/Commands/UpgradeOnlineAttendanceCommand.php
resources/views/DSIMT-Webiste/
resources/views/admin/fee-management/
resources/views/admin/invoices/
resources/views/admin/defaulters/
resources/views/student/payment-required.blade.php
resources/views/super-admin/course-approval/
database/migrations/*biometric*
database/migrations/*invoice*
database/migrations/*payment*
database/migrations/*enrollment*  (check for access_expiry_date, fees_collected)
database/migrations/*publication_status*
routes/web.php  (DSIMT + fee routes)
bootstrap/app.php  (EnsureStudentAccess middleware)
```

---

## 5. Migration Applied (Current State)

### Traits Created

| Trait | Path |
|-------|------|
| `UsesFeeConfig` | `app/Http/Controllers/Traits/UsesFeeConfig.php` |
| `UsesFeeVoucherService` | `app/Http/Controllers/Traits/UsesFeeVoucherService.php` |
| `UsesFeeReminderService` | `app/Http/Controllers/Traits/UsesFeeReminderService.php` |
| `UsesCoursePublicationStatus` | `app/Http/Controllers/Traits/UsesCoursePublicationStatus.php` |
| `UsesEnrollmentFeeLogic` | `app/Http/Controllers/Traits/UsesEnrollmentFeeLogic.php` |

### Base Controllers Created

| Base Controller | Path |
|----------------|------|
| `DigiSindhAdminController` | `app/Http/Controllers/Base/DigiSindhAdminController.php` |
| `DigiSindhSuperAdminController` | `app/Http/Controllers/Base/DigiSindhSuperAdminController.php` |
| `DigiSindhStudentController` | `app/Http/Controllers/Base/DigiSindhStudentController.php` |

### Controllers Refactored (Example)

- **Admin\EnrollmentController** – Now extends `DigiSindhAdminController`, uses `UsesEnrollmentFeeLogic`; `approve()` delegates to `applyEnrollmentApprovalLogic()`.
- **Admin\InvoiceController** – Now extends `DigiSindhAdminController`; uses `requirePaymentApproval()`, `feeReminderService()`, `feeVoucherService()` from base/traits.

### Remaining Refactors (Apply Same Pattern)

Apply the same pattern to:

1. **Admin\DashboardController** – Extend `DigiSindhAdminController`, replace `app(FeeVoucherService::class)->markOverdue()` with `$this->feeVoucherService()->markOverdue()`.
2. **SuperAdmin\DashboardController** – Extend `DigiSindhSuperAdminController`, same change.
3. **Student\ProfileController** – Extend `DigiSindhStudentController`, use `$this->feeVoucherService()`.
4. **Instructor\CourseController** – Add `UsesCoursePublicationStatus` trait, use `$this->setCourseDraft()` in store/update.
5. **Instructor\ContentController** – Add `UsesCoursePublicationStatus` trait, use `$this->setCoursePendingApproval()`.

---

## Next Steps

1. Create the Traits and Base Controllers.
2. Refactor the mixed controllers to use them.
3. Ensure `routes/web.php` and middleware stay under version control.
4. Document any model/DB changes (migrations) that are custom.
5. Before each Envato update: run a diff on the files listed above and re-apply only necessary custom logic.
