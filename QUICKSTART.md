# Quick Start Guide - Tunisie Telecom Website

## For Developers

### Local Development Setup

1. **Clone and Setup**
   ```bash
   git clone <repository-url>
   cd telecom-service-checker
   cp .env.example .env
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

4. **Configure Database**
   Edit `.env` file:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=telecom_checker
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Run Migrations**
   ```bash
   php artisan migrate
   ```

6. **Seed Database (Optional)**
   ```bash
   php artisan db:seed
   ```

7. **Build Assets**
   ```bash
   npm run dev  # For development with hot reload
   # OR
   npm run build  # For production
   ```

8. **Start Development Server**
   ```bash
   php artisan serve
   ```

9. **Access Application**
   - Home: http://localhost:8000
   - Coverage Checker: http://localhost:8000/coverage
   - Admin (requires auth): http://localhost:8000/admin/dashboard

### Development Workflow

#### Making Style Changes
```bash
# Run Vite in watch mode
npm run dev

# Make changes to:
# - resources/css/app.css
# - tailwind.config.js
# - Blade files

# Changes auto-reload in browser
```

#### Adding New Colors
Edit `tailwind.config.js`:
```javascript
colors: {
    'tt-red': '#E30613',
    'tt-red-dark': '#B80510',
    'tt-red-light': '#FFE5E7',
    'your-color': '#hexcode',
}
```

#### Adding New Routes
Edit `routes/web.php`:
```php
// Public routes (no auth)
Route::get('/new-page', function () {
    return view('pages.new');
})->name('page.new');

// Protected routes (auth required)
Route::middleware('auth')->get('/admin/new', function () {
    return view('admin.new');
})->name('admin.new');
```

#### Creating New Blade Components
```bash
php artisan make:component ComponentName

# Creates:
# - app/View/Components/ComponentName.php
# - resources/views/components/component-name.blade.php

# Use in views:
<x-component-name />
```

### Testing

#### Run PHP Tests
```bash
./vendor/bin/phpunit
# OR
php artisan test
```

#### Run Specific Test
```bash
php artisan test --filter=TestName
```

#### API Testing with curl
```bash
# Get governorates
curl http://localhost:8000/api/coverage/governorates

# Check coverage
curl -X POST http://localhost:8000/api/coverage/check \
  -H "Content-Type: application/json" \
  -H "X-CSRF-TOKEN: your-token" \
  -d '{"governorate":"Tunis"}'
```

### Common Tasks

#### Clear All Caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

#### Rebuild Assets
```bash
npm run build
```

#### Database Reset
```bash
php artisan migrate:fresh --seed
```

#### Generate IDE Helper (for autocomplete)
```bash
composer require --dev barryvdh/laravel-ide-helper
php artisan ide-helper:generate
php artisan ide-helper:models
```

### Project Structure

```
telecom-service-checker/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   └── CoverageApiController.php
│   │   │   └── Admin/
│   │   └── Middleware/
│   └── Models/
│       ├── Area.php
│       ├── ServiceType.php
│       └── CoverageHistory.php
├── resources/
│   ├── css/
│   │   └── app.css  # TT custom styles
│   ├── js/
│   │   └── app.js
│   └── views/
│       ├── layouts/
│       │   └── public.blade.php  # Main public layout
│       ├── coverage/
│       │   └── public.blade.php  # Coverage checker
│       ├── welcome-new.blade.php  # Landing page
│       └── components/
├── routes/
│   ├── web.php  # Web routes
│   └── api.php  # API routes
├── public/
│   └── build/  # Built assets (gitignored)
├── database/
│   └── migrations/
├── tailwind.config.js  # Tailwind configuration
├── vite.config.js  # Vite configuration
└── package.json  # NPM dependencies
```

### Environment Variables

Key variables in `.env`:

```bash
APP_NAME="Tunisie Telecom"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_DATABASE=telecom_checker

# Mail (for notifications)
MAIL_MAILER=smtp
MAIL_FROM_ADDRESS="noreply@tunisietelecom.tn"

# Rate Limiting (recommended for production)
THROTTLE_PUBLIC_API=60  # requests per minute
```

### Troubleshooting

#### Assets not loading
```bash
npm run build
php artisan config:clear
```

#### 500 Error
```bash
# Check logs
tail -f storage/logs/laravel.log

# Fix permissions
chmod -R 775 storage bootstrap/cache
```

#### Database connection error
```bash
# Verify .env settings
php artisan config:clear
php artisan migrate
```

#### Tailwind classes not working
```bash
# Rebuild with Tailwind
npm run build
# Ensure class names are in content paths (tailwind.config.js)
```

### VS Code Extensions (Recommended)

- Laravel Extra Intellisense
- Laravel Blade Snippets
- Tailwind CSS IntelliSense
- PHP Intelephense
- ESLint
- Prettier

### Git Workflow

```bash
# Create feature branch
git checkout -b feature/new-feature

# Make changes and commit
git add .
git commit -m "feat: Add new feature"

# Push to remote
git push origin feature/new-feature

# Create Pull Request on GitHub
```

### Production Deployment

See `IMPLEMENTATION.md` for full deployment instructions.

Quick checklist:
- [ ] Set `APP_ENV=production` and `APP_DEBUG=false`
- [ ] Run `composer install --no-dev --optimize-autoloader`
- [ ] Run `npm run build`
- [ ] Run `php artisan optimize`
- [ ] Set proper file permissions
- [ ] Configure web server (Nginx/Apache)
- [ ] Set up SSL certificate
- [ ] Configure database backups
- [ ] Set up monitoring

### Getting Help

- Laravel Documentation: https://laravel.com/docs
- Tailwind CSS Documentation: https://tailwindcss.com/docs
- Alpine.js Documentation: https://alpinejs.dev/start-here
- Project Issues: Create an issue on GitHub

### Code Style

We follow PSR-12 coding standards for PHP:
```bash
# Check code style
./vendor/bin/phpcs

# Fix code style
./vendor/bin/phpcbf
```

For JavaScript/CSS, we use Prettier:
```bash
npm run format
```
