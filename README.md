# Payment Processing Service

Production-ready payment processing service built with Laravel 11.

## Stack
- Laravel 11 (PHP 8.3)
- PostgreSQL
- Redis
- Laravel Horizon
- InertiaJS + Vue 3
- TailwindCSS
- Docker

## Features
- **Idempotency**: Prevent duplicate payments using `Idempotency-Key` header.
- **Async Processing**: External gateway calls are handled in background jobs with 3 retries and exponential backoff.
- **Reliability**: Uses database transactions with pessimistic locking (`FOR UPDATE`) for balance safety.
- **Monitoring**: Integrated Laravel Horizon for queue monitoring.
- **Failover**: Handles timeouts and failures from mock gateway with automatic refunds on permanent failure.

## Setup Instructions

1. **Clone the repository** (or copy files to your directory).
2. **Setup environment**:
   ```bash
   cp .env.example .env
   ```
3. **Start Docker**:
   ```bash
   docker-compose up -d
   ```
4. **Install dependencies**:
   ```bash
   docker exec -it payment-app composer install
   docker exec -it payment-app npm install
   docker exec -it payment-app npm run build
   ```
5. **Run Migrations & Seeders**:
   ```bash
   docker exec -it payment-app php artisan migrate --seed
   ```
6. **Generate APP_KEY**:
   ```bash
   docker exec -it payment-app php artisan key:generate
   ```

## Usage

- **Dashboard**: Access `http://localhost`
- **Horizon**: Access `http://localhost/horizon`
- **API Health**: `GET /api/health`
- **Create Payment**: `POST /api/payments` (Requires `Idempotency-Key` header)

## Testing
Run the feature tests to verify the core logic:
```bash
docker exec -it payment-app php artisan test
```

## Mock Gateway Simulation
The simulated gateway in `app/Services/MockPaymentGateway.php` has:
- 25% failure rate.
- 10% timeout rate.
- Statuses are updated in the `transactions` table and reflected in the UI.
