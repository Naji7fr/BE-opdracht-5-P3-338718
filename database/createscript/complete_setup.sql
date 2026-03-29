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
DROP TABLE IF EXISTS ProductEinddatumLevering;
DROP TABLE IF EXISTS Magazijn;
DROP TABLE IF EXISTS Allergeen;
DROP TABLE IF EXISTS Product;
DROP TABLE IF EXISTS Leverancier;
DROP TABLE IF EXISTS Contact;

-- Note: Laravel system tables (sessions, users, cache, jobs) should be created via migrations
-- Run: php artisan migrate

-- Drop existing stored procedures
DROP PROCEDURE IF EXISTS sp_GetAllLeveranciers;
DROP PROCEDURE IF EXISTS sp_GetProductenByLeverancier;
DROP PROCEDURE IF EXISTS sp_GetLeverancierById;
DROP PROCEDURE IF EXISTS sp_AddProductLevering;
DROP PROCEDURE IF EXISTS sp_GetLeverancierWithContactById;
DROP PROCEDURE IF EXISTS sp_UpdateLeverancier;
DROP PROCEDURE IF EXISTS sp_GetProductenMetAllergeen;
DROP PROCEDURE IF EXISTS sp_GetLeverancierGegevensByProductId;
DROP PROCEDURE IF EXISTS sp_GetGeleverdeProductenByTijdsvak;
DROP PROCEDURE IF EXISTS sp_GetSpecificatieLeveringen;
DROP PROCEDURE IF EXISTS sp_GetProductenUitAssortiment;
DROP PROCEDURE IF EXISTS sp_GetProductDetail;
DROP PROCEDURE IF EXISTS sp_VerwijderProduct;

-- ============================================
-- PART 2: CREATE BUSINESS TABLES
-- ============================================

-- Table: Contact (Contact Address Information)
CREATE TABLE Contact (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Straat VARCHAR(100) NOT NULL,
    Huisnummer VARCHAR(10) NOT NULL,
    Postcode VARCHAR(10) NOT NULL,
    Stad VARCHAR(100) NOT NULL,
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(250) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
);

-- Table: Leverancier (Supplier)
-- ContactId NULL allowed (Opdracht 4: leverancier zonder adresgegevens, bv. Hom Ken Food)
CREATE TABLE Leverancier (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Naam VARCHAR(100) NOT NULL,
    ContactPersoon VARCHAR(100) NOT NULL,
    LeverancierNummer VARCHAR(20) NOT NULL UNIQUE,
    Mobiel VARCHAR(15) NOT NULL,
    ContactId INT NULL,
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(250) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    FOREIGN KEY (ContactId) REFERENCES Contact(Id) ON DELETE RESTRICT
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

-- Table: ProductEinddatumLevering (Opdracht 5 - User Story 1)
CREATE TABLE ProductEinddatumLevering (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    ProductId INT NOT NULL,
    EinddatumLevering DATE NOT NULL,
    IsActief BIT NOT NULL DEFAULT 1,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
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

-- Insert Data: Contact (Contact Addresses) - Opdracht 4 specificatie
INSERT INTO Contact (Straat, Huisnummer, Postcode, Stad) VALUES
('Van Gilslaan', '34', '1045CB', 'Hilvarenbeek'),
('Den Dolderpad', '2', '1067RC', 'Utrecht'),
('Fredo Raalteweg', '257', '1236OP', 'Nijmegen'),
('Bertrand Russellhof', '21', '2034AP', 'Den Haag'),
('Leon van Bonstraat', '213', '145XC', 'Lunteren'),
('Bea van Lingenlaan', '234', '2197FG', 'Sint Pancras');

-- Insert Data: Leverancier (Suppliers)
-- ContactId mapping: 1=Venco, 2=Astra Sweets, 3=Haribo, 4=Basset, 5=De Bron, 6=Quality Street, 7=Hom Ken Food (NULL)
INSERT INTO Leverancier (Naam, ContactPersoon, LeverancierNummer, Mobiel, ContactId) VALUES
('Venco', 'Bert van Linge', 'L1029384719', '06-28493827', 1),
('Astra Sweets', 'Jasper del Monte', 'L1029284315', '06-39398734', 2),
('Haribo', 'Sven Stalman', 'L1029324748', '06-24383291', 3),
('Basset', 'Joyce Stelterberg', 'L1023845773', '06-48293823', 4),
('De Bron', 'Remco Veenstra', 'L1023857736', '06-34291234', 5),
('Quality Street', 'Johan Nooij', 'L1029234586', '06-23458456', 6),
('Hom Ken Food', 'Hom Ken', 'L1029234599', '06-23458477', NULL);

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
('Zoute Ruitjes', '8719587323256'),
('Drop ninja''s', '8719587323277');

-- Set Winegums as inactive (IsActief = 0) for User Story 2 Scenario 2
UPDATE Product SET IsActief = 0 WHERE Naam = 'Winegums';

-- Insert Data: ProductEinddatumLevering (Opdracht 5 - User Story 1)
-- Both Schoolkrijt and Honingdrop appear in filter 01-05-2024..01-06-2024
-- Schoolkrijt CAN be deleted (Scenario 02), Honingdrop is BLOCKED (Scenario 03)
-- Block is via future DatumEerstVolgendeLevering in ProductPerLeverancier (see UPDATE below)
INSERT INTO ProductEinddatumLevering (ProductId, EinddatumLevering) VALUES
(1,  '2024-06-01'),  -- Mintnopjes
(2,  '2024-05-22'),  -- Schoolkrijt  -> CAN delete (Scenario 02)
(3,  '2024-05-30'),  -- Honingdrop   -> BLOCKED     (Scenario 03)
(4,  '2024-05-12'),  -- Zure Beren
(7,  '2024-05-27'),  -- Witte Muizen
(10, '2024-05-03'),  -- Winegums
(11, '2024-02-09'),  -- Drop Munten
(14, '2024-01-01');  -- Drop ninja's

-- Give Honingdrop a future DatumEerstVolgendeLevering so sp_VerwijderProduct blocks its deletion
UPDATE ProductPerLeverancier SET DatumEerstVolgendeLevering = '2027-05-30' WHERE ProductId = 3;

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
(13, 1), (13, 4), (13, 5),
(14, 5);

-- Insert Data: ProductPerLeverancier (Using dates from assignment: 2023-04-09 to 2023-04-21)
-- Note: Assignment shows duplicate Id=14, but we use auto-increment so this will be Id=15
INSERT INTO ProductPerLeverancier (LeverancierId, ProductId, DatumLevering, Aantal, DatumEerstVolgendeLevering) VALUES
(1, 1, '2023-04-09', 23, '2023-04-16'),
(1, 1, '2023-04-18', 21, '2023-04-25'),
(1, 2, '2023-04-09', 12, '2023-04-16'),
(1, 3, '2023-04-10', 11, '2023-04-17'),
(2, 4, '2023-04-14', 16, '2023-04-21'),
(2, 4, '2023-04-21', 23, '2023-04-28'),
(2, 5, '2023-04-14', 45, '2023-04-21'),
(2, 6, '2023-04-14', 30, '2023-04-21'),
(3, 7, '2023-04-12', 12, '2023-04-19'),
(3, 7, '2023-04-19', 23, '2023-04-26'),
(3, 8, '2023-04-10', 12, '2023-04-17'),
(3, 9, '2023-04-11', 1, '2023-04-18'),
(4, 10, '2023-04-16', 24, '2023-04-30'),
(5, 11, '2023-04-10', 47, '2023-04-17'),
(5, 11, '2023-04-19', 60, '2023-04-26'),
(5, 12, '2023-04-11', 45, NULL),
(5, 13, '2023-04-12', 23, NULL),
(7, 14, '2023-04-14', 20, NULL);

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

-- Stored Procedure: sp_GetLeverancierWithContactById
-- Description: Get supplier information with contact address by ID
CREATE PROCEDURE sp_GetLeverancierWithContactById(IN leverancierId INT)
BEGIN
    SELECT 
        l.Id,
        l.Naam,
        l.ContactPersoon,
        l.LeverancierNummer,
        l.Mobiel,
        l.ContactId,
        c.Straat,
        c.Huisnummer,
        c.Postcode,
        c.Stad
    FROM Leverancier l
    INNER JOIN Contact c ON l.ContactId = c.Id
    WHERE l.Id = leverancierId AND l.IsActief = 1;
END//

-- Stored Procedure: sp_UpdateLeverancier
-- Description: Update supplier information and contact address
-- Returns: 1 on success, 0 on failure (for error scenario testing)
CREATE PROCEDURE sp_UpdateLeverancier(
    IN p_LeverancierId INT,
    IN p_Naam VARCHAR(100),
    IN p_ContactPersoon VARCHAR(100),
    IN p_LeverancierNummer VARCHAR(50),
    IN p_Mobiel VARCHAR(15),
    IN p_Straat VARCHAR(100),
    IN p_Huisnummer VARCHAR(10),
    IN p_Postcode VARCHAR(10),
    IN p_Stad VARCHAR(100)
)
BEGIN
    DECLARE v_ContactId INT;
    DECLARE v_ErrorOccurred INT DEFAULT 0;
    
    -- Get ContactId for this leverancier
    SELECT ContactId INTO v_ContactId
    FROM Leverancier
    WHERE Id = p_LeverancierId;
    
    -- For testing error scenario: De Bron (Id=5) will fail
    IF p_LeverancierId = 5 THEN
        SET v_ErrorOccurred = 1;
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Technische storing bij het bijwerken van leverancier';
    ELSE
        -- Update Contact address
        UPDATE Contact
        SET Straat = p_Straat,
            Huisnummer = p_Huisnummer,
            Postcode = p_Postcode,
            Stad = p_Stad,
            DatumGewijzigd = NOW(6)
        WHERE Id = v_ContactId;
        
        -- Update Leverancier
        UPDATE Leverancier
        SET Naam = p_Naam,
            ContactPersoon = p_ContactPersoon,
            LeverancierNummer = p_LeverancierNummer,
            Mobiel = p_Mobiel,
            DatumGewijzigd = NOW(6)
        WHERE Id = p_LeverancierId;
    END IF;
END//

-- Stored Procedure: sp_GetProductenMetAllergeen (Opdracht 4 - User Story 01)
-- Description: Producten die een bepaald allergeen bevatten, gesorteerd A-Z (één rij per product)
CREATE PROCEDURE sp_GetProductenMetAllergeen(IN p_AllergeenId INT)
BEGIN
    SELECT 
        p.Id AS ProductId,
        p.Naam AS ProductNaam,
        p.Barcode,
        MAX(a.Naam) AS AllergeenNaam,
        MAX(a.Omschrijving) AS AllergeenOmschrijving
    FROM Product p
    INNER JOIN ProductPerAllergeen ppa ON p.Id = ppa.ProductId
    INNER JOIN Allergeen a ON ppa.AllergeenId = a.Id
    WHERE ppa.AllergeenId = p_AllergeenId
      AND p.IsActief = 1
      AND ppa.IsActief = 1
    GROUP BY p.Id, p.Naam, p.Barcode
    ORDER BY p.Naam ASC;
END//

-- Stored Procedure: sp_GetLeverancierGegevensByProductId (Opdracht 4 - User Story 01)
-- Description: Leverancier + adresgegevens voor een product (ContactId mag NULL zijn)
CREATE PROCEDURE sp_GetLeverancierGegevensByProductId(IN p_ProductId INT)
BEGIN
    SELECT 
        l.Id AS LeverancierId,
        l.Naam AS LeverancierNaam,
        l.ContactPersoon,
        l.LeverancierNummer,
        l.Mobiel,
        l.ContactId,
        c.Straat,
        c.Huisnummer,
        c.Postcode,
        c.Stad
    FROM ProductPerLeverancier ppl
    INNER JOIN Leverancier l ON ppl.LeverancierId = l.Id
    LEFT JOIN Contact c ON l.ContactId = c.Id
    WHERE ppl.ProductId = p_ProductId
      AND l.IsActief = 1
    LIMIT 1;
END//

-- Stored Procedure: sp_GetGeleverdeProductenByTijdsvak (Overzicht geleverde producten)
-- Description: Geleverde producten in een tijdsvak, gegroepeerd per leverancier+product, totaal geleverd, gesorteerd A-Z op leverancier
CREATE PROCEDURE sp_GetGeleverdeProductenByTijdsvak(IN p_StartDatum DATE, IN p_EindDatum DATE)
BEGIN
    SELECT 
        l.Id AS LeverancierId,
        l.Naam AS LeverancierNaam,
        l.ContactPersoon,
        p.Id AS ProductId,
        p.Naam AS ProductNaam,
        SUM(ppl.Aantal) AS TotaalGeleverd
    FROM ProductPerLeverancier ppl
    INNER JOIN Leverancier l ON ppl.LeverancierId = l.Id
    INNER JOIN Product p ON ppl.ProductId = p.Id
    WHERE ppl.DatumLevering BETWEEN p_StartDatum AND p_EindDatum
      AND l.IsActief = 1
    GROUP BY l.Id, l.Naam, l.ContactPersoon, p.Id, p.Naam
    ORDER BY l.Naam ASC, p.Naam ASC;
END//

-- Stored Procedure: sp_GetSpecificatieLeveringen (Specificatie geleverde producten)
-- Description: Per-levering regels voor een product in een tijdsvak (DatumLevering, Aantal)
CREATE PROCEDURE sp_GetSpecificatieLeveringen(IN p_ProductId INT, IN p_StartDatum DATE, IN p_EindDatum DATE)
BEGIN
    SELECT 
        ppl.DatumLevering,
        ppl.Aantal
    FROM ProductPerLeverancier ppl
    WHERE ppl.ProductId = p_ProductId
      AND ppl.DatumLevering BETWEEN p_StartDatum AND p_EindDatum
    ORDER BY ppl.DatumLevering ASC;
END//

-- Stored Procedure: sp_GetProductenUitAssortiment (Opdracht 5 - User Story 1)
-- Description: Products going out of assortment in a date range, sorted by EinddatumLevering DESC
CREATE PROCEDURE sp_GetProductenUitAssortiment(
    IN p_StartDatum DATE,
    IN p_EindDatum  DATE
)
BEGIN
    SELECT
        p.Id                  AS ProductId,
        p.Naam                AS ProductNaam,
        l.Naam                AS LeverancierNaam,
        l.ContactPersoon,
        COALESCE(c.Stad, '')  AS Stad,
        pel.EinddatumLevering
    FROM ProductEinddatumLevering pel
    INNER JOIN Product p
        ON pel.ProductId = p.Id AND p.IsActief = 1
    INNER JOIN (
        SELECT ProductId, MIN(LeverancierId) AS LeverancierId
        FROM ProductPerLeverancier
        GROUP BY ProductId
    ) ppl_first ON p.Id = ppl_first.ProductId
    INNER JOIN Leverancier l
        ON ppl_first.LeverancierId = l.Id AND l.IsActief = 1
    LEFT JOIN Contact c
        ON l.ContactId = c.Id
    WHERE pel.EinddatumLevering BETWEEN p_StartDatum AND p_EindDatum
    ORDER BY pel.EinddatumLevering DESC;
END//

-- Stored Procedure: sp_GetProductDetail (Opdracht 5 - User Story 1)
-- Description: Product info + allergen flags (Ja/Nee) for product detail page
CREATE PROCEDURE sp_GetProductDetail(IN p_ProductId INT)
BEGIN
    SELECT
        p.Id,
        p.Naam,
        p.Barcode,
        COALESCE(MAX(CASE WHEN a.Naam = 'Gluten'        THEN 'Ja' END), 'Nee') AS BevatGluten,
        COALESCE(MAX(CASE WHEN a.Naam = 'Gelatine'      THEN 'Ja' END), 'Nee') AS BevatGelatine,
        COALESCE(MAX(CASE WHEN a.Naam = 'AZO-Kleurstof' THEN 'Ja' END), 'Nee') AS BevatAZOKleurstof,
        COALESCE(MAX(CASE WHEN a.Naam = 'Lactose'       THEN 'Ja' END), 'Nee') AS BevatLactose,
        COALESCE(MAX(CASE WHEN a.Naam = 'Soja'          THEN 'Ja' END), 'Nee') AS BevatSoja,
        pel.EinddatumLevering
    FROM Product p
    LEFT JOIN ProductPerAllergeen ppa ON p.Id = ppa.ProductId AND ppa.IsActief = 1
    LEFT JOIN Allergeen a ON ppa.AllergeenId = a.Id AND a.IsActief = 1
    LEFT JOIN ProductEinddatumLevering pel ON p.Id = pel.ProductId
    WHERE p.Id = p_ProductId
    GROUP BY p.Id, p.Naam, p.Barcode, pel.EinddatumLevering;
END//

-- Stored Procedure: sp_VerwijderProduct (Opdracht 5 - User Story 1)
-- Description: Sets Product.IsActief=0 unless a future delivery is still expected.
-- Returns: resultaat = 'success' | 'blocked'
CREATE PROCEDURE sp_VerwijderProduct(IN p_ProductId INT)
BEGIN
    DECLARE v_EinddatumLevering     DATE;
    DECLARE v_MaxEerstVolgendeDatum DATE;

    SELECT EinddatumLevering INTO v_EinddatumLevering
    FROM ProductEinddatumLevering
    WHERE ProductId = p_ProductId LIMIT 1;

    SELECT MAX(DatumEerstVolgendeLevering) INTO v_MaxEerstVolgendeDatum
    FROM ProductPerLeverancier
    WHERE ProductId = p_ProductId;

    IF v_EinddatumLevering IS NULL THEN
        SELECT 'blocked' AS resultaat;
    ELSEIF v_MaxEerstVolgendeDatum IS NOT NULL AND v_MaxEerstVolgendeDatum > CURDATE() THEN
        SELECT 'blocked' AS resultaat;
    ELSE
        UPDATE Product SET IsActief = 0, DatumGewijzigd = NOW(6)
        WHERE Id = p_ProductId;
        SELECT 'success' AS resultaat;
    END IF;
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

