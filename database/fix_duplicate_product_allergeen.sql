-- Verwijder dubbele koppeling Product 14 (Drop ninja's) - Allergeen 5 (Soja)
-- Voer dit eenmalig uit in phpMyAdmin als Drop ninja's dubbel verschijnt bij Soja.

-- Bewaar één rij en verwijder de overige duplicaten voor (ProductId=14, AllergeenId=5)
DELETE ppa1 FROM ProductPerAllergeen ppa1
INNER JOIN ProductPerAllergeen ppa2
  ON ppa1.ProductId = ppa2.ProductId AND ppa1.AllergeenId = ppa2.AllergeenId
  AND ppa1.Id > ppa2.Id
WHERE ppa1.ProductId = 14 AND ppa1.AllergeenId = 5;
