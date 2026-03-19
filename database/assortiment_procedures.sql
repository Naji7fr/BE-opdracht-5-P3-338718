-- ============================================
-- Opdracht 5 - User Story 1: Verwijder product uit het assortiment
-- ProductEinddatumLevering table + stored procedures
-- ============================================

-- Drop procedures if they exist
DROP PROCEDURE IF EXISTS sp_GetProductenUitAssortiment;
DROP PROCEDURE IF EXISTS sp_GetProductDetail;
DROP PROCEDURE IF EXISTS sp_VerwijderProduct;

-- Drop and recreate ProductEinddatumLevering table
DROP TABLE IF EXISTS ProductEinddatumLevering;

CREATE TABLE ProductEinddatumLevering (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    ProductId INT NOT NULL,
    EinddatumLevering DATE NOT NULL,
    IsActief BIT NOT NULL DEFAULT 1,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    FOREIGN KEY (ProductId) REFERENCES Product(Id) ON DELETE CASCADE
);

-- Insert data according to assignment specification
-- Note: Honingdrop (Id=3) uses a future date (2027-05-30) so Scenario 03 still works today
INSERT INTO ProductEinddatumLevering (ProductId, EinddatumLevering) VALUES
(1,  '2024-06-01'),  -- Mintnopjes
(2,  '2024-05-22'),  -- Schoolkrijt  (past  -> CAN be deleted)
(3,  '2027-05-30'),  -- Honingdrop   (future -> CANNOT be deleted, Scenario 03)
(4,  '2024-05-12'),  -- Zure Beren
(7,  '2024-05-27'),  -- Witte Muizen
(10, '2024-05-03'),  -- Winegums
(11, '2024-02-09'),  -- Drop Munten
(14, '2024-01-01');  -- Drop ninja's

DELIMITER //

-- -------------------------------------------------------
-- sp_GetProductenUitAssortiment
-- Returns products going out of assortment within a date
-- range, with leverancier + stad info, sorted by
-- EinddatumLevering DESC.
-- -------------------------------------------------------
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

-- -------------------------------------------------------
-- sp_GetProductDetail
-- Returns product info + allergen flags (Ja/Nee) for the
-- product detail page (Wireframe-03/05).
-- -------------------------------------------------------
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
    LEFT JOIN ProductPerAllergeen ppa
        ON p.Id = ppa.ProductId AND ppa.IsActief = 1
    LEFT JOIN Allergeen a
        ON ppa.AllergeenId = a.Id AND a.IsActief = 1
    LEFT JOIN ProductEinddatumLevering pel
        ON p.Id = pel.ProductId
    WHERE p.Id = p_ProductId
    GROUP BY p.Id, p.Naam, p.Barcode, pel.EinddatumLevering;
END//

-- -------------------------------------------------------
-- sp_VerwijderProduct
-- Deletes a product from the assortment by setting
-- Product.IsActief = 0, but ONLY when today >= EinddatumLevering.
-- Returns: resultaat = 'success' | 'blocked'
-- -------------------------------------------------------
CREATE PROCEDURE sp_VerwijderProduct(IN p_ProductId INT)
BEGIN
    DECLARE v_EinddatumLevering DATE;

    SELECT EinddatumLevering INTO v_EinddatumLevering
    FROM ProductEinddatumLevering
    WHERE ProductId = p_ProductId
    LIMIT 1;

    IF v_EinddatumLevering IS NULL THEN
        SELECT 'blocked' AS resultaat;
    ELSEIF CURDATE() < v_EinddatumLevering THEN
        -- Today is before the end date: cannot delete
        SELECT 'blocked' AS resultaat;
    ELSE
        -- Today is on or after the end date: safe to delete
        UPDATE Product SET IsActief = 0, DatumGewijzigd = NOW(6)
        WHERE Id = p_ProductId;
        SELECT 'success' AS resultaat;
    END IF;
END//

DELIMITER ;
