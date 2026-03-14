-- Stored procedures voor Overzicht geleverde producten (User Story 1)
-- Voer uit in phpMyAdmin op je Jamin-database

DROP PROCEDURE IF EXISTS sp_GetGeleverdeProductenByTijdsvak;
DROP PROCEDURE IF EXISTS sp_GetSpecificatieLeveringen;

DELIMITER //

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

DELIMITER ;
