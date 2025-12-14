# QUICK SETUP GUIDE - Jamin Warehouse System

## Step 1: Create Database Tables

1. Open **phpMyAdmin** in your browser (usually http://localhost/phpmyadmin)
2. Select your database **magazijn** from the left sidebar
3. Click on the **SQL** tab at the top
4. Copy and paste the contents of `database/createscript/create_jamin_tables.sql`
5. Click **Go** to execute
6. You should see: "Query OK, X rows affected"

## Step 2: Create Stored Procedures

1. Still in phpMyAdmin, click on the **SQL** tab again
2. Copy and paste the contents of `database/createscript/create_all_stored_procedures.sql`
3. Click **Go** to execute
4. Click on **Routines** tab to verify all 4 procedures are created:
   - sp_GetAllLeveranciers
   - sp_GetProductenByLeverancier
   - sp_GetLeverancierById
   - sp_AddProductLevering

## Step 3: Verify Data

In phpMyAdmin:
1. Click on table **Leverancier** - should see 6 suppliers
2. Click on table **Product** - should see 13 products
3. Click on table **Magazijn** - should see 13 inventory records
4. Click on table **ProductPerLeverancier** - should see 17 delivery records

## Step 4: Test the Application

1. Go to http://127.0.0.1:8000
2. Login with: **admin@smilepro.nl** / **admin123**
3. Click **Overzicht Leveranciers** on dashboard
4. You should see all 6 suppliers sorted by product count

## Troubleshooting

**If you see "Procedure does not exist":**
- Make sure you executed the stored procedure script
- Check in phpMyAdmin → Routines tab
- Database must be "magazijn"

**If you see "Table doesn't exist":**
- Execute the create_jamin_tables.sql script first
- Refresh phpMyAdmin

**If login doesn't work:**
- Run: `php artisan db:seed --class=UserSeeder`
- This creates the admin user

## Testing Scenarios

### User Story 1 - Scenario 1:
1. Click on Venco's box icon
2. See products with stock sorted descending
3. Last delivery dates shown

### User Story 1 - Scenario 2:
1. Click on Quality Street's box icon
2. See "geen producten" message
3. Auto-redirect after 3 seconds

### User Story 2 - Scenario 1:
1. Go to Venco → Mintnopjes
2. Click + icon
3. Enter: 25 units, date: 2024-05-29
4. Save → stock updated

### User Story 2 - Scenario 2:
1. Go to Basset → Winegums (inactive)
2. Click + icon
3. Enter: 30 units
4. Save → error message + 4 second redirect

## Ready to Record Video!

Press **Windows + G** to start recording your demo.
