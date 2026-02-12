# Telecom Service Availability Checker

A modern Laravel application for checking telecom service availability in different areas. Built with Laravel 12, Bootstrap 5, and Chart.js.

## Features

- ✅ Customer portal for checking service availability
- ✅ Real-time status updates with auto-refresh (every 30 seconds)
- ✅ **Coverage Checker** - Interactive map-based coverage verification (powered by More-Taghtia)
- ✅ **Coverage API** - RESTful API for coverage data with historical tracking
- ✅ Admin dashboard with analytics and charts
- ✅ Service management (CRUD operations)
- ✅ Area and service type management
- ✅ Status change history tracking
- ✅ CSV export functionality
- ✅ Responsive design for all devices
- ✅ Modern UI with Bootstrap 5
- ✅ Role-based authentication and authorization

## Tech Stack

- **Backend**: Laravel 12.x (PHP 8.3+)
- **Frontend**: Bootstrap 5, JavaScript (Vanilla)
- **Charts**: Chart.js
- **Database**: SQLite (MySQL/PostgreSQL compatible)
- **Authentication**: Laravel Breeze

## Requirements

- PHP >= 8.1
- Composer
- Node.js >= 18 & NPM
- SQLite (or MySQL >= 5.7 / PostgreSQL >= 10)

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/rayenbouhoula/telecom-service-checker.git
   cd telecom-service-checker
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install NPM dependencies**
   ```bash
   npm install
   ```

4. **Create environment file**
   ```bash
   cp .env.example .env
   ```

5. **Generate application key**
   ```bash
   php artisan key:generate
   ```

6. **Configure API keys (Optional)**
   
   For the coverage checker to work with live data, configure these in `.env`:
   ```env
   # Tunisie Telecom API (optional - uses mock data by default)
   TT_API_URL=https://geo.tunisietelecom.tn/mytaghtia
   TT_API_KEY=your_api_key_here
   TT_API_TIMEOUT=10
   
   # Mapbox token for map visualization (optional)
   MAPBOX_TOKEN=your_mapbox_token_here
   ```
   
   > **Note**: The application works with mock coverage data by default. API keys are only needed for production use with real Tunisie Telecom data.

7. **Configure database**
   
   For SQLite (default):
   ```bash
   touch database/database.sqlite
   ```
   
   Or for MySQL, update `.env` file:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=telecom_checker
   DB_USERNAME=root
   DB_PASSWORD=
   ```

7. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```

8. **Build frontend assets**
   ```bash
   npm run build
   ```
   
   Or for development with hot reload:
   ```bash
   npm run dev
   ```

9. **Start the development server**
   ```bash
   php artisan serve
   ```

10. **Access the application**
    - Open your browser and navigate to: [http://localhost:8000](http://localhost:8000)

## Default Admin Credentials

After running the seeders, you can login with:

- **Email**: admin@telecom.com
- **Password**: password

## Application Structure

### Public Routes
- `/` - Landing page with features showcase
- `/check-availability` - Check service availability by area and service type
- `/coverage-checker` - Interactive coverage checker with map visualization

### API Routes
- `POST /api/v1/coverage/check` - Check coverage for a location
- `GET /api/v1/coverage/history` - Get coverage check history
- `GET /api/v1/coverage/stats` - Get coverage statistics
- `GET /api/v1/coverage/compare` - Compare coverage between areas

### Admin Routes (Authentication Required)
- `/admin/dashboard` - Statistics and analytics dashboard
- `/admin/services` - Manage service availability (CRUD)
- `/admin/areas` - Manage geographic areas
- `/admin/service-types` - Manage service types (Internet, 4G, 5G, Fiber)
- `/admin/history` - View status change history with filters

## Key Features

### Customer Portal
- Select area from dropdown
- Choose service type with visual cards
- View real-time service status (Available/Maintenance/Problem)
- Auto-refresh status every 30 seconds
- Color-coded status badges (Green/Yellow/Red)

### Admin Dashboard
- Statistics cards showing total services and status counts
- Doughnut chart for status distribution
- Line chart for 7-day status change trends
- Recent status changes table
- Quick action buttons

### Service Management
- Create, read, update, and delete service availability records
- Quick status update buttons
- Bulk update functionality
- Filter by area, service type, and status
- CSV export capability

### Status History
- Track all status changes with timestamps
- Filter by date range, area, service type, and user
- View who made changes and when
- Export filtered results to CSV

### Coverage Checker (New!)
- **Interactive Map**: Point-and-click coverage checking with Mapbox integration
- **Real-time Coverage Data**: Check 2G, 3G, 4G, ADSL, VDSL, GPON Fiber, and P2P Fiber availability
- **Historical Tracking**: All coverage checks are stored in the database for analysis
- **Heatmap Visualization**: See coverage patterns across different connection types
- **Batch Checking**: Select multiple locations and check simultaneously
- **Favorites & History**: Save frequently checked locations
- **API Access**: RESTful API for programmatic access to coverage data
- **Statistics Dashboard**: Track total checks, most-checked areas, and trends
- **Caching**: 5-minute cache to reduce API calls and improve performance

#### Coverage API Endpoints

**POST `/api/v1/coverage/check`**
Check coverage for a specific location:
```json
{
  "governorate": "Tunis",
  "latitude": 36.8065,
  "longitude": 10.1815
}
```

**GET `/api/v1/coverage/history?governorate=Tunis&limit=20`**
Get historical coverage checks with optional filters.

**GET `/api/v1/coverage/stats`**
Get statistics about coverage checks:
```json
{
  "total_checks": 150,
  "total_areas": 24,
  "checks_today": 15,
  "most_checked_areas": [...]
}
```

**GET `/api/v1/coverage/compare?areas[]=Tunis&areas[]=Sfax`**
Compare coverage between multiple areas (2-5 areas).

## Database Schema

### Tables
- `users` - User accounts with roles (admin/customer)
- `areas` - Geographic regions/areas
- `service_types` - Types of services offered
- `service_availability` - Current service status per area
- `status_history` - Audit trail of status changes
- `coverage_checks` - Coverage check history with location data

## Development

### Run tests
```bash
php artisan test
```

### Code formatting
```bash
vendor/bin/pint
```

### Watch for frontend changes
```bash
npm run dev
```

## Production Deployment

1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false` in `.env`
3. Run `php artisan config:cache`
4. Run `php artisan route:cache`
5. Run `php artisan view:cache`
6. Build production assets: `npm run build`

## Security

- CSRF protection enabled on all forms
- XSS protection via Blade templating
- Role-based access control
- Password hashing with bcrypt
- SQL injection protection via Eloquent ORM

## License

This project is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For issues and questions, please open an issue on the [GitHub repository](https://github.com/rayenbouhoula/telecom-service-checker/issues).

## Credits

Developed with ❤️ using Laravel, Bootstrap 5, and Chart.js.
