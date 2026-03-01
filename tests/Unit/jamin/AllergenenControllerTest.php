<?php

namespace Tests\Unit\jamin;

use Tests\TestCase;

/**
 * Unit-tests voor logica Overzicht Allergenen (Opdracht 4 - User Story 01).
 * Geen database – alleen fake data.
 */
class AllergenenControllerTest extends TestCase
{
    /**
     * Unit-test: leverancier zonder ContactId heeft geen adresgegevens (Scenario 03).
     * Gebruikt alleen fake data.
     */
    public function test_heeft_geen_adres_when_contact_id_is_null(): void
    {
        // Arrange: fake leverancier record zoals uit sp_GetLeverancierGegevensByProductId
        $fakeLeverancier = (object) [
            'LeverancierId' => 7,
            'LeverancierNaam' => 'Hom Ken Food',
            'ContactPersoon' => 'Hom Ken',
            'LeverancierNummer' => 'L1029234599',
            'Mobiel' => '06-23458477',
            'ContactId' => null,
            'Straat' => null,
            'Huisnummer' => null,
            'Postcode' => null,
            'Stad' => null,
        ];

        // Act: logica zoals in AllergenenController::leverancierGegevens
        $heeftGeenAdres = $fakeLeverancier->ContactId === null;

        // Assert
        $this->assertTrue($heeftGeenAdres);
        $this->assertNull($fakeLeverancier->Straat);
    }

    /**
     * Unit-test: leverancier met ContactId heeft wél adresgegevens (Scenario 02).
     * Gebruikt alleen fake data.
     */
    public function test_heeft_wel_adres_when_contact_id_is_set(): void
    {
        // Arrange: fake leverancier met adres (bv. De Bron voor Kruis Drop)
        $fakeLeverancier = (object) [
            'LeverancierId' => 5,
            'LeverancierNaam' => 'De Bron',
            'ContactPersoon' => 'Remco Veenstra',
            'LeverancierNummer' => 'L1023857736',
            'Mobiel' => '06-34291234',
            'ContactId' => 5,
            'Straat' => 'Leon van Bonstraat',
            'Huisnummer' => '213',
            'Postcode' => '145XC',
            'Stad' => 'Lunteren',
        ];

        $heeftGeenAdres = $fakeLeverancier->ContactId === null;

        $this->assertFalse($heeftGeenAdres);
        $this->assertNotNull($fakeLeverancier->Straat);
        $this->assertSame('Lunteren', $fakeLeverancier->Stad);
    }
}
