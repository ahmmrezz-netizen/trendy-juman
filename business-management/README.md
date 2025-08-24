# Business Management Software

A comprehensive business management system built with Laravel 12 and Bootstrap 5 for managing products, clients, purchases, and generating reports.

## Features

### 🎯 Core Modules
- **Dashboard**: Overview with summary cards and recent activity
- **Products**: CRUD operations with stock management
- **Clients**: Customer management with contact information
- **Purchases**: Sales tracking with automatic stock reduction
- **Reports**: Analytics and export functionality

### 🚀 Technical Features
- **Responsive Design**: Mobile-friendly Bootstrap 5 interface
- **Real-time Stock Management**: Automatic inventory updates
- **Search & Pagination**: Efficient data browsing
- **Data Export**: CSV export for products
- **Validation**: Form validation with custom error messages
- **Relationships**: Proper Eloquent model relationships

## Technology Stack

### Backend
- **Laravel 12** - PHP framework
- **SQLite** - Database (easily configurable for MySQL/PostgreSQL)
- **Eloquent ORM** - Database operations
- **Resource Controllers** - RESTful API structure
- **Form Requests** - Validation classes

### Frontend
- **Bootstrap 5** - CSS framework
- **Bootstrap Icons** - Icon library
- **Responsive Grid** - Mobile-first design
- **Custom CSS** - Enhanced styling

## Installation

### Prerequisites
- PHP 8.2+
- Composer
- SQLite (or MySQL/PostgreSQL)

### Setup Steps

1. **Clone/Download the project**
   ```bash
   cd business-management
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Environment setup**
   ```bash
   # Copy environment file
   cp .env.example .env
   
   # Generate application key
   php artisan key:generate
   ```

4. **Database setup**
   ```bash
   # Run migrations
   php artisan migrate
   
   # Seed with sample data
   php artisan db:seed --class=SampleDataSeeder
   ```

5. **Start the server**
   ```bash
   php artisan serve
   ```

6. **Access the application**
   - Open: http://localhost:8000
   - Default admin credentials:
     - Email: admin@example.com
     - Password: password

## Database Structure

### Tables
- **users**: Admin users with roles
- **products**: Product catalog with stock levels
- **clients**: Customer information
- **purchases**: Sales transactions

### Relationships
- Client has many Purchases
- Product has many Purchases
- Purchase belongs to Client and Product

## Usage Guide

### Dashboard
- View summary statistics
- Monitor recent activity
- Quick access to all modules

### Products Management
1. **Add Product**: Fill in name, size, color, and quantity
2. **Edit Product**: Modify existing product details
3. **View Details**: See product information and purchase history
4. **Delete Product**: Remove products (with confirmation)

### Client Management
1. **Add Client**: Enter name, email, and phone
2. **Edit Client**: Update client information
3. **View Details**: See client profile and purchase history

### Purchase Recording
1. **Select Client**: Choose from existing clients
2. **Select Product**: Pick from available inventory
3. **Enter Quantity**: Specify purchase amount
4. **Set Date**: Choose purchase date
5. **Automatic Stock Update**: Inventory reduces automatically

### Reports
- **Product Report**: Stock levels and sales performance
- **Client Report**: Customer purchase patterns
- **Export Functionality**: Download data in CSV format

## API Endpoints

### Admin Routes (prefix: /admin)
- `GET /` - Dashboard
- `GET /products` - Products list
- `POST /products` - Create product
- `GET /products/{id}` - Show product
- `PUT /products/{id}` - Update product
- `DELETE /products/{id}` - Delete product
- `GET /clients` - Clients list
- `GET /purchases` - Purchases list
- `GET /reports` - Reports overview

## Customization

### Adding New Fields
1. Create migration: `php artisan make:migration add_field_to_table`
2. Update model fillable array
3. Modify form requests for validation
4. Update views and controllers

### Styling Changes
- Modify `resources/views/admin/layouts/app.blade.php`
- Customize Bootstrap variables
- Add custom CSS in the style section

### Database Configuration
- Edit `.env` file for database settings
- Support for MySQL, PostgreSQL, and SQLite

## Security Features

- **CSRF Protection**: All forms include CSRF tokens
- **Input Validation**: Form request validation classes
- **SQL Injection Prevention**: Eloquent ORM protection
- **XSS Protection**: Blade template escaping

## Performance Optimizations

- **Eager Loading**: Relationships loaded efficiently
- **Pagination**: Large datasets handled properly
- **Database Indexing**: Proper foreign key constraints
- **Caching**: Ready for Redis/Memcached integration

## Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Check `.env` file configuration
   - Ensure database exists and is accessible

2. **Permission Errors**
   - Set proper file permissions for storage and bootstrap/cache
   - Run: `chmod -R 775 storage bootstrap/cache`

3. **Composer Issues**
   - Clear cache: `composer clear-cache`
   - Update dependencies: `composer update`

4. **Migration Errors**
   - Reset database: `php artisan migrate:fresh --seed`
   - Check migration files for syntax errors

## Contributing

1. Fork the repository
2. Create feature branch
3. Make changes
4. Test thoroughly
5. Submit pull request

## License

This project is open-source and available under the MIT License.

## Support

For support and questions:
- Create an issue in the repository
- Check Laravel documentation
- Review Bootstrap documentation

## Future Enhancements

- [ ] User authentication system
- [ ] Advanced reporting with charts
- [ ] Email notifications
- [ ] Multi-language support
- [ ] API endpoints for mobile apps
- [ ] Advanced inventory management
- [ ] Financial reporting
- [ ] Customer relationship management (CRM)

---

**Built with ❤️ using Laravel 12 and Bootstrap 5**
