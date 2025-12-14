# Jamin Warehouse Management System - BE Opdracht 2

## Project Overview
This Laravel application implements a warehouse management system for Jamin, featuring supplier and product inventory management.

## Implemented User Stories

### User Story 1: Overzicht Leveranciers
- **Scenario 1**: View all suppliers with their product count, sorted by number of products (descending)
- **Scenario 2**: Handle suppliers with no products (shows message and redirects after 3 seconds)

### User Story 2: Toevoegen Producten
- **Scenario 1**: Add new product deliveries to warehouse inventory
- **Scenario 2**: Validate inactive products (shows error and redirects after 4 seconds)

## Database Structure

### Tables Created:
1. **Leverancier** - Suppliers with contact information
2. **Product** - Products with barcodes
3. **Magazijn** - Warehouse inventory
4. **Allergeen** - Allergen information
5. **ProductPerLeverancier** - Product deliveries by suppliers
6. **ProductPerAllergeen** - Product allergen relationships

All tables include system fields:
- `IsActief` (BIT) - Active status
- `Opmerking` (VARCHAR) - Comments
- `DatumAangemaakt` (DATETIME) - Created timestamp
- `DatumGewijzigd` (DATETIME) - Modified timestamp

### Stored Procedures:
1. `sp_GetAllLeveranciers` - Get all suppliers with product count
2. `sp_GetProductenByLeverancier` - Get products for a specific supplier
3. `sp_GetLeverancierById` - Get supplier by ID
4. `sp_AddProductLevering` - Add product delivery and update stock

## Installation Instructions

### 1. Database Setup

```bash
# Open MySQL/PhpMyAdmin and run the following scripts in order:
1. database/createscript/create_jamin_tables.sql
2. database/createscript/sp_GetAllLeveranciers.sql
3. database/createscript/sp_GetProductenByLeverancier.sql
4. database/createscript/sp_GetLeverancierById.sql
5. database/createscript/sp_AddProductLevering.sql
```

### 2. Laravel Configuration

```bash
# Update .env file with your database credentials
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 3. Install Dependencies

```bash
composer install
npm install
```

### 4. Run Migrations (if needed for authentication tables)

```bash
php artisan migrate
```

### 5. Seed Admin User

```bash
php artisan db:seed --class=UserSeeder
```

### 6. Start Development Server

```bash
# Terminal 1: Start PHP server
php artisan serve

# Terminal 2: Build assets
npm run dev
```

## Usage

### Login Credentials
- **Admin Account**:
  - Email: admin@smilepro.nl
  - Password: admin123

### Navigation Flow

1. **Login** → Use admin credentials
2. **Dashboard** → Click "Overzicht Leveranciers"
3. **Suppliers Overview** → View all suppliers sorted by product count
4. **Click Box Icon** → View products for specific supplier
5. **Click Plus Icon** → Add new product delivery
6. **Fill Form** → Enter quantity and next delivery date
7. **Save** → Stock is automatically updated

### Testing Scenarios

#### User Story 1 - Scenario 1:
1. Login as admin
2. Go to "Overzicht Leveranciers"
3. Click the box icon for "Venco"
4. View products sorted by magazine stock (descending)

#### User Story 1 - Scenario 2:
1. Go to "Overzicht Leveranciers"
2. Click the box icon for "Quality Street" (no products)
3. See message: "Dit bedrijf heeft tot nu toe geen producten geleverd aan Jamin"
4. Automatically redirected after 3 seconds

#### User Story 2 - Scenario 1:
1. Go to "Overzicht Leveranciers"
2. Click box icon for "Venco"
3. Click plus icon for "Mintnopjes"
4. Enter aantal: 25
5. Enter datum: 2024-05-29
6. Click "Sla op"
7. Verify stock is updated

#### User Story 2 - Scenario 2:
1. Go to "Overzicht Leveranciers"
2. Click box icon for "Basset"
3. Click plus icon for "Winegums" (inactive product)
4. Enter aantal: 30
5. Enter datum: today
6. Click "Sla op"
7. See error: "Het product Winegums van de leverancier Basset wordt niet meer geproduceerd"
8. Automatically redirected after 4 seconds

## Features

### Technical Implementation:
- ✅ MVC Framework (Laravel)
- ✅ OOP (Object-Oriented Programming)
- ✅ Stored Procedures (MySQL)
- ✅ PDO/Eloquent ORM
- ✅ Professional UI with Tailwind CSS
- ✅ Form validation
- ✅ Error handling
- ✅ Automatic redirects with timers
- ✅ Foreign key relationships

### UI Features:
- Blue gradient table headers
- Color-coded action buttons
- Hover effects
- Loading indicators
- Success/error messages
- Responsive design

## Git Workflow

```bash
# Initialize repository
git init
git add .
git commit -m "Initial commit"

# User Story 1 branch
git checkout -b dev-opdracht-2-us01
# (Make commits while implementing User Story 1)
git commit -m "Implement User Story 1 Scenario 1"
git commit -m "Implement User Story 1 Scenario 2"

# User Story 2 branch
git checkout -b dev-opdracht-2-us02
# (Make commits while implementing User Story 2)
git commit -m "Implement User Story 2 Scenario 1"
git commit -m "Implement User Story 2 Scenario 2"

# Final merge
git checkout main
git merge dev-opdracht-2-us01
git merge dev-opdracht-2-us02
git push origin main
```

## File Structure

```
BE-opdracht-1-338718-main/
├── app/
│   ├── Http/Controllers/
│   │   └── LeverancierController.php
│   └── Models/
│       ├── Leverancier.php
│       ├── Product.php
│       ├── Magazijn.php
│       ├── ProductPerLeverancier.php
│       └── Allergeen.php
├── database/
│   └── createscript/
│       ├── create_jamin_tables.sql
│       ├── sp_GetAllLeveranciers.sql
│       ├── sp_GetProductenByLeverancier.sql
│       ├── sp_GetLeverancierById.sql
│       └── sp_AddProductLevering.sql
├── resources/views/
│   ├── leveranciers/
│   │   ├── index.blade.php (Wireframe-01)
│   │   ├── producten.blade.php (Wireframe-02)
│   │   ├── no-products.blade.php (Wireframe-03)
│   │   └── levering-form.blade.php (Wireframe-04)
│   └── dashboard.blade.php
└── routes/
    └── web.php
```

## Video Recording Instructions

1. Enable Xbox Game Bar: Settings → Gaming → Xbox Game Bar → On
2. Press Windows + G to start recording
3. Record the following (max 60 seconds):
   - Login process
   - Navigate to Leveranciers overview
   - Click to view products
   - Add new delivery
   - Show PhpMyAdmin with tables and data
4. Save video to `vids/` folder in project root
5. Push to GitHub

## Submission

Create a public GitHub repository named: `BE-opdracht-2-P2-[your-student-number]`

Include:
1. Complete source code
2. Database create scripts
3. Stored procedures
4. Demo video in `vids/` folder
5. This README file

Push everything to GitHub and submit the link on Canvas before Sunday December 14, 2025, 23:00.

## Author
Student Number: [Your Student Number]
Class: IO-SD-2309AB
Date: December 2, 2025
