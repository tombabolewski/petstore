# PetStore Client

1. Copy `.env.example` to `.env`
2. Install dependencies

```bash
composer i
npm i
```

3. Generate the docs

```bash
php artisan scribe:generate
```

4. Run development server

```bash
php artisan serve
```

5. Run Vue SPA

```bash
npm run dev
```

6. By default, the application is accessible at http://127.0.0.1:8000. The documentation can be found at `/docs`