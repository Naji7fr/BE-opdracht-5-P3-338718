-- ============================================
-- Opdracht 4 – Update bestaande database
-- User Story 01: Overzicht Allergenen
-- Voer dit uit als je al een Jamin-database hebt.
-- ============================================

-- Leverancier: ContactId mag NULL
ALTER TABLE Leverancier MODIFY COLUMN ContactId INT NULL;

-- Nieuw record Leverancier 7 (zonder adres)
INSERT IGNORE INTO Leverancier (Id, Naam, ContactPersoon, LeverancierNummer, Mobiel, ContactId) VALUES
(7, 'Hom Ken Food', 'Hom Ken', 'L1029234599', '06-23458477', NULL);

-- Product 14
INSERT IGNORE INTO Product (Id, Naam, Barcode) VALUES
(14, 'Drop ninja''s', '8719587323277');

-- ProductPerAllergeen: product 14 heeft Soja (AllergeenId 5)
INSERT IGNORE INTO ProductPerAllergeen (ProductId, AllergeenId) VALUES (14, 5);

-- ProductPerLeverancier: leverancier 7 levert product 14
INSERT IGNORE INTO ProductPerLeverancier (LeverancierId, ProductId, DatumLevering, Aantal, DatumEerstVolgendeLevering) VALUES
(7, 14, '2023-04-14', 20, NULL);

-- Stored procedures voor Overzicht Allergenen
DROP PROCEDURE IF EXISTS sp_GetProductenMetAllergeen;
DROP PROCEDURE IF EXISTS sp_GetLeverancierGegevensByProductId;

DELIMITER //

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

DELIMITER ;
