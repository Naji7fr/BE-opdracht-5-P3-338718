-- ============================================
-- Update Admin User Role
-- Description: Updates the admin@jamin.nl user role from 'logistiek medewerker' back to 'admin'
-- ============================================

UPDATE users 
SET role = 'admin' 
WHERE email = 'admin@jamin.nl' AND role = 'logistiek medewerker';

-- Verify the update
SELECT name, email, role 
FROM users 
WHERE email = 'admin@jamin.nl';