-- Update stored procedure sp_UpdateLeverancier to include Naam, ContactPersoon, and LeverancierNummer
-- Run this script to update the existing stored procedure in your database

DROP PROCEDURE IF EXISTS sp_UpdateLeverancier;

DELIMITER //

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

DELIMITER ;

