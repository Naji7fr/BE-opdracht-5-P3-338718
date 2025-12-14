-- ============================================
-- COMPLETE DATABASE SETUP SCRIPT
-- Jamin Warehouse Management System
-- This script contains all tables, stored procedures, and initial data
-- Date: 2025-12-02
-- ============================================

-- ============================================
-- PART 1: DROP EXISTING TABLES AND PROCEDURES
-- ============================================

-- Drop existing business tables if they exist (in reverse order due to foreign keys)
DROP TABLE IF EXISTS ProductPerAllergeen;
DROP TABLE IF EXISTS ProductPerLeverancier;
DROP TABLE IF EXISTS Magazijn;
DROP TABLE IF EXISTS Allergeen;
DROP TABLE IF EXISTS Product;
DROP TABLE IF EXISTS Leverancier;

-- Note: Laravel system tables (sessions, users, cache, jobs) should be created via migrations
-- Run: php artisan migrate

-- Drop existing stored procedures
DROP PROCEDURE IF EXISTS sp_GetAllLeveranciers;
DROP PROCEDURE IF EXISTS sp_GetProductenByLeverancier;
DROP PROCEDURE IF EXISTS sp_GetLeverancierById;
DROP PROCEDURE IF EXISTS sp_AddProductLevering;

-- ============================================
-- PART 2: CREATE BUSINESS TABLES
-- ============================================

-- Table: Leverancier (Supplier)
CREATE TABLE Leverancier (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Naam VARCHAR(100) NOT NULL,
    ContactPersoon VARCHAR(100) NOT NULL,
    LeverancierNummer VARCHAR(20) NOT NULL UNIQUE,
    Mobiel VARCHAR(15) NOT NULL,
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
);

-- Table: Product
CREATE TABLE Product (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Naam VARCHAR(100) NOT NULL,
    Barcode VARCHAR(13) NOT NULL UNIQUE,
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
);

-- Table: Allergeen (Allergen)
CREATE TABLE Allergeen (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Naam VARCHAR(100) NOT NULL,
    Omschrijving VARCHAR(255) NOT NULL,
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
);

-- Table: Magazijn (Warehouse Inventory)
CREATE TABLE Magazijn (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    ProductId INT NOT NULL,
    VerpakkingsEenheid DECIMAL(5,1) NOT NULL,
    AantalAanwezig INT NULL,
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    FOREIGN KEY (ProductId) REFERENCES Product(Id) ON DELETE CASCADE
);

-- Table: ProductPerLeverancier (Product per Supplier)
CREATE TABLE ProductPerLeverancier (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    LeverancierId INT NOT NULL,
    ProductId INT NOT NULL,
    DatumLevering DATE NOT NULL,
    Aantal INT NOT NULL,
    DatumEerstVolgendeLevering DATE NULL,
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    FOREIGN KEY (LeverancierId) REFERENCES Leverancier(Id) ON DELETE CASCADE,
    FOREIGN KEY (ProductId) REFERENCES Product(Id) ON DELETE CASCADE
);

-- Table: ProductPerAllergeen (Product per Allergen)
CREATE TABLE ProductPerAllergeen (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    ProductId INT NOT NULL,
    AllergeenId INT NOT NULL,
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    FOREIGN KEY (ProductId) REFERENCES Product(Id) ON DELETE CASCADE,
    FOREIGN KEY (AllergeenId) REFERENCES Allergeen(Id) ON DELETE CASCADE
);

-- ============================================
-- PART 3: INSERT INITIAL DATA
-- ============================================

-- Insert Data: Leverancier (Suppliers)
INSERT INTO Leverancier (Naam, ContactPersoon, LeverancierNummer, Mobiel) VALUES
('Venco', 'Bert van Linge', 'L1029384719', '06-28493827'),
('Astra Sweets', 'Jasper del Monte', 'L1029284315', '06-39398734'),
('Haribo', 'Sven Stalman', 'L1029324748', '06-24383291'),
('Basset', 'Joyce Stelterberg', 'L1023845773', '06-48293823'),
('De Bron', 'Remco Veenstra', 'L1023857736', '06-34291234'),
('Quality Street', 'Johan Nooij', 'L1029234586', '06-23458456');

-- Insert Data: Product
INSERT INTO Product (Naam, Barcode) VALUES
('Mintnopjes', '8719587231278'),
('Schoolkrijt', '8719587326713'),
('Honingdrop', '8719587327836'),
('Zure Beren', '8719587321441'),
('Cola Flesjes', '8719587321237'),
('Turtles', '8719587322245'),
('Witte Muizen', '8719587328256'),
('Reuzen Slangen', '8719587325641'),
('Zoute Rijen', '8719587322739'),
('Winegums', '8719587327527'),
('Drop Munten', '8719587322345'),
('Kruis Drop', '8719587322265'),
('Zoute Ruitjes', '8719587323256');

-- Set Winegums as inactive (IsActief = 0) for User Story 2 Scenario 2
UPDATE Product SET IsActief = 0 WHERE Naam = 'Winegums';

-- Insert Data: Allergeen (Allergens)
INSERT INTO Allergeen (Naam, Omschrijving) VALUES
('Gluten', 'Dit product bevat gluten'),
('Gelatine', 'Dit product bevat gelatine'),
('AZO-Kleurstof', 'Dit product bevat AZO-kleurstoffen'),
('Lactose', 'Dit product bevat lactose'),
('Soja', 'Dit product bevat soja');

-- Insert Data: Magazijn (Warehouse Inventory)
INSERT INTO Magazijn (ProductId, VerpakkingsEenheid, AantalAanwezig) VALUES
(1, 5.0, 453),
(2, 2.5, 400),
(3, 5.0, 1),
(4, 1.0, 800),
(5, 3.0, 234),
(6, 2.0, 345),
(7, 1.0, 795),
(8, 10.0, 233),
(9, 2.5, 123),
(10, 3.0, NULL),
(11, 2.0, 367),
(12, 1.0, 467),
(13, 5.0, 20);

-- Insert Data: ProductPerAllergeen
INSERT INTO ProductPerAllergeen (ProductId, AllergeenId) VALUES
(1, 2), (1, 1), (1, 3),
(3, 4),
(6, 5),
(9, 2), (9, 5),
(10, 2),
(12, 4),
(13, 1), (13, 4), (13, 5);

-- Insert Data: ProductPerLeverancier (Starting dates from 2023-12-12)
INSERT INTO ProductPerLeverancier (LeverancierId, ProductId, DatumLevering, Aantal, DatumEerstVolgendeLevering) VALUES
(1, 1, '2023-12-12', 50, '2023-12-19'),
(1, 1, '2023-12-12', 23, '2023-12-19'),
(1, 1, '2023-12-12', 21, '2023-12-19'),
(1, 2, '2023-12-12', 12, '2023-12-19'),
(1, 3, '2023-12-12', 11, '2023-12-19'),
(2, 4, '2023-12-12', 16, '2023-12-19'),
(2, 4, '2023-12-12', 23, '2023-12-19'),
(2, 5, '2023-12-12', 45, '2023-12-19'),
(2, 6, '2023-12-12', 30, '2023-12-19'),
(3, 7, '2023-12-12', 12, '2023-12-19'),
(3, 7, '2023-12-12', 23, '2023-12-19'),
(3, 8, '2023-12-12', 12, '2023-12-19'),
(3, 9, '2023-12-12', 1, '2023-12-19'),
(4, 10, '2023-12-12', 24, '2023-12-19'),
(5, 11, '2023-12-12', 47, '2023-12-19'),
(5, 11, '2023-12-12', 60, '2023-12-19'),
(5, 12, '2023-12-12', 45, NULL),
(5, 13, '2023-12-12', 23, NULL);

-- ============================================
-- PART 4: CREATE STORED PROCEDURES
-- ============================================

DELIMITER //

-- Stored Procedure: sp_GetAllLeveranciers
-- Description: Get all suppliers with count of different products they supply
CREATE PROCEDURE sp_GetAllLeveranciers()
BEGIN
    SELECT 
        l.Id,
        l.Naam,
        l.ContactPersoon,
        l.LeverancierNummer,
        l.Mobiel,
        COUNT(DISTINCT ppl.ProductId) AS AantalVerschillendeProducten
    FROM Leverancier l
    LEFT JOIN ProductPerLeverancier ppl ON l.Id = ppl.LeverancierId
    WHERE l.IsActief = 1
    GROUP BY l.Id, l.Naam, l.ContactPersoon, l.LeverancierNummer, l.Mobiel
    ORDER BY AantalVerschillendeProducten DESC;
END//

-- Stored Procedure: sp_GetProductenByLeverancier
-- Description: Get all products delivered by a specific supplier with inventory info
CREATE PROCEDURE sp_GetProductenByLeverancier(IN leverancierId INT)
BEGIN
    SELECT 
        p.Id AS ProductId,
        p.Naam AS ProductNaam,
        p.Barcode,
        m.AantalAanwezig AS AantalInMagazijn,
        m.VerpakkingsEenheid,
        MAX(ppl.DatumLevering) AS Laatstelevering,
        p.IsActief AS ProductIsActief
    FROM Product p
    INNER JOIN ProductPerLeverancier ppl ON p.Id = ppl.ProductId
    LEFT JOIN Magazijn m ON p.Id = m.ProductId
    WHERE ppl.LeverancierId = leverancierId
    GROUP BY p.Id, p.Naam, p.Barcode, m.AantalAanwezig, m.VerpakkingsEenheid, p.IsActief
    ORDER BY m.AantalAanwezig DESC;
END//

-- Stored Procedure: sp_GetLeverancierById
-- Description: Get supplier information by ID
CREATE PROCEDURE sp_GetLeverancierById(IN leverancierId INT)
BEGIN
    SELECT 
        Id,
        Naam,
        ContactPersoon,
        LeverancierNummer,
        Mobiel
    FROM Leverancier
    WHERE Id = leverancierId AND IsActief = 1;
END//

-- Stored Procedure: sp_AddProductLevering
-- Description: Add a new delivery of a product and update magazine stock
CREATE PROCEDURE sp_AddProductLevering(
    IN p_LeverancierId INT,
    IN p_ProductId INT,
    IN p_Aantal INT,
    IN p_DatumEerstVolgendeLevering DATE
)
BEGIN
    DECLARE v_ProductIsActief BIT;
    DECLARE v_DatumLevering DATE;
    
    -- Check if product is active
    SELECT IsActief INTO v_ProductIsActief
    FROM Product
    WHERE Id = p_ProductId;
    
    IF v_ProductIsActief = 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Product is niet meer actief';
    ELSE
        -- Insert new delivery: DatumLevering uses the entered date (or today if not provided)
        SET v_DatumLevering = COALESCE(p_DatumEerstVolgendeLevering, CURDATE());
        
        INSERT INTO ProductPerLeverancier (LeverancierId, ProductId, DatumLevering, Aantal, DatumEerstVolgendeLevering)
        VALUES (p_LeverancierId, p_ProductId, v_DatumLevering, p_Aantal, p_DatumEerstVolgendeLevering);
        
        -- Update magazine stock
        UPDATE Magazijn
        SET AantalAanwezig = COALESCE(AantalAanwezig, 0) + p_Aantal,
            DatumGewijzigd = NOW(6)
        WHERE ProductId = p_ProductId;
    END IF;
END//

DELIMITER ;

-- ============================================
-- VERIFICATION
-- ============================================

-- Verify procedures were created
SHOW PROCEDURE STATUS WHERE Db = DATABASE();

-- ============================================
-- END OF SCRIPT
-- ============================================

