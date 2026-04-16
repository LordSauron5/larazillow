# LaraZillow

A real estate listing platform built with Laravel 10 and Vue 3, similar to Zillow. Users can browse property listings, make offers, and receive notifications. Realtors manage their own listings, upload images, and handle incoming offers.

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Language | PHP 8.1 |
| Backend | Laravel 10 |
| Frontend | Vue 3 (Composition API) |
| Routing | Inertia.js (no separate SPA — server drives all navigation) |
| Styling | Tailwind CSS + @tailwindcss/forms |
| Build | Vite 4 |
| Auth | Laravel session auth + Sanctum (stateful) |
| Database | MySQL |
| Mail (dev) | Mailpit (SMTP trap on port 1025) |

---

## Prerequisites

- PHP 8.1
- Composer
- Node.js 18+
- MySQL
- Mailpit (optional, for email in development)

---

## Installation

```bash
# 1. Clone the repo
git clone <repo-url>
cd larazillow

# 2. Install PHP dependencies
composer install

# 3. Install JS dependencies
npm install

# 4. Set up environment
cp .env.example .env
php artisan key:generate

# 5. Configure your database in .env
# DB_DATABASE=larazillow
# DB_USERNAME=root
# DB_PASSWORD=

# 6. Run migrations and seed
php artisan migrate:fresh --seed

# 7. Create the storage symlink (required for listing images)
php artisan storage:link

# 8. Start the dev server
npm run dev
php artisan serve
```

---

## Seed Credentials

After running `php artisan migrate:fresh --seed`:

| Role | Email | Password |
|------|-------|----------|
| Admin (full access) | `admin@example.com` | `password` |
| Realtor (verified user) | `lister@example.com` | `password` |

Both accounts have their email pre-verified. The admin account has the `is_admin` flag set, granting policy-level bypass on all listings.

---

## Features

- **Browse listings** — Paginated grid with filters (price range, beds, baths, area)
- **Listing detail** — Image gallery, mortgage calculator (interactive interest rate & duration sliders), and offer form
- **Make offers** — Authenticated users can bid on listings with a range slider input
- **Realtor dashboard** — Create, edit, soft-delete, and restore your own listings
- **Image uploads** — Multiple images per listing stored in `public/storage`
- **Offer management** — Realtors accept/reject offers; accepting marks the listing as sold and auto-rejects all other offers
- **Notifications** — In-app notification badge + paginated notification list; also sends email on new offer
- **Email verification** — Required before accessing any realtor features
- **Soft deletes** — Listings can be deleted and restored without data loss

---

## Architecture

This project uses **Inertia.js** — there is no separate REST API for page rendering. Laravel controllers return Vue components with props via `inertia('Page/Name', [...props])`. A single Blade file (`resources/views/app.blade.php`) serves as the mount point.

```
resources/js/
├── app.js                   # Inertia entry point, applies MainLayout globally
├── Pages/                   # Page-level Vue components (map 1:1 to Laravel routes)
│   ├── Auth/                # Login, VerifyEmail
│   ├── Listing/             # Public browse + detail
│   ├── Realtor/             # Dashboard, CRUD, image upload, offers
│   ├── Notification/        # Notification list
│   └── UserAccount/         # Registration
├── Components/UI/           # Box, Price, ListingSpace, Pagination, EmptyState
├── Layouts/MainLayout.vue   # Navigation, notification badge, flash messages
└── Composables/
    └── useMonthlyPayment.js # Amortization formula used in listing cards and detail
```

Routes are shared with the frontend via **Ziggy**, which exposes the `route()` helper in Vue components.

---

## Key Routes

| Method | URI | Description |
|--------|-----|-------------|
| GET | `/listing` | Public listing index |
| GET | `/listing/{id}` | Listing detail |
| POST | `/listing/{id}/offer` | Submit an offer |
| GET | `/realtor/listing` | Realtor dashboard (auth + verified) |
| GET | `/realtor/listing/create` | Create listing form |
| POST | `/realtor/listing` | Store new listing |
| PUT | `/realtor/listing/{id}` | Update listing |
| DELETE | `/realtor/listing/{id}` | Soft-delete listing |
| PUT | `/realtor/listing/{id}/restore` | Restore soft-deleted listing |
| POST | `/realtor/listing/{id}/image` | Upload images |
| PUT | `/realtor/offer/{id}/accept` | Accept an offer |
| GET | `/notification` | Notifications list |

---

## Known Quirks

- **FK bug in offers migration** (`2023_12_21_171317_create_offers_table.php`): `bidder_id` foreign key constraint incorrectly references `listings` instead of `users`. The runtime behaviour is unaffected as long as user IDs and listing IDs don't collide, but the constraint is wrong.
- **Synchronous queue** (`QUEUE_CONNECTION=sync`): The `OfferMade` notification (email + database) runs synchronously during the request. Switch to a real queue driver for production.
- **Default string length**: `AppServiceProvider` sets `Schema::defaultStringLength(191)` for MySQL utf8 compatibility.
