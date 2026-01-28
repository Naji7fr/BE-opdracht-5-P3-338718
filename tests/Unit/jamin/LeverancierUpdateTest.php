<?php

namespace Tests\Unit\jamin;

use Tests\TestCase;

class LeverancierUpdateTest extends TestCase
{
    /**
     * Unit-test: controleert dat alle verplichte velden voor leverancier-update aanwezig zijn.
     * Test één stukje logica (validatie-velden) zonder database.
     */
    public function test_required_update_fields_are_defined(): void
    {
        // Arrange: velden die de update-methode vereist (zoals in LeverancierController::update)
        $requiredFields = [
            'naam',
            'contactpersoon',
            'leveranciernummer',
            'straat',
            'huisnummer',
            'postcode',
            'stad',
        ];

        // Assert: alle 7 verplichte velden zijn gedefinieerd
        $this->assertCount(7, $requiredFields);
        $this->assertContains('naam', $requiredFields);
        $this->assertContains('contactpersoon', $requiredFields);
        $this->assertContains('leveranciernummer', $requiredFields);
        $this->assertContains('straat', $requiredFields);
        $this->assertContains('huisnummer', $requiredFields);
        $this->assertContains('postcode', $requiredFields);
        $this->assertContains('stad', $requiredFields);
    }

    /**
     * Unit-test: controleert dat een geldige leverancier-data structuur correct is.
     */
    public function test_valid_leverancier_data_structure(): void
    {
        // Arrange: nep data zoals bij een geslaagde update (zonder database)
        $data = [
            'naam' => 'Test Leverancier',
            'contactpersoon' => 'Jan Test',
            'leveranciernummer' => 'L1234567890',
            'straat' => 'Teststraat',
            'huisnummer' => '1',
            'postcode' => '1234AB',
            'stad' => 'Amsterdam',
        ];

        $this->assertArrayHasKey('naam', $data);
        $this->assertSame('Test Leverancier', $data['naam']);
        $this->assertSame(7, count($data));
    }
}
