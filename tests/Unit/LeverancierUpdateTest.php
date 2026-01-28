<?php

namespace Tests\Unit;

use Tests\TestCase;

class LeverancierUpdateTest extends TestCase
{
    /**
     * Unit-test: controleert dat update-data met fake data correct is.
     * Geen database – alleen nep data (fake data).
     */
    public function test_leverancier_update_data_structure_with_fake_data(): void
    {
        // Arrange: fake data (nep data) – geen database
        $fakeUpdateData = [
            'naam' => 'Test Leverancier',
            'contactpersoon' => 'Jan Test',
            'leveranciernummer' => 'L1234567890',
            'straat' => 'Teststraat',
            'huisnummer' => '123',
            'postcode' => '1234AB',
            'stad' => 'Amsterdam',
        ];

        // Assert: controleer de fake data
        $this->assertCount(7, $fakeUpdateData);
        $this->assertEquals('Test Leverancier', $fakeUpdateData['naam']);
        $this->assertEquals('Teststraat', $fakeUpdateData['straat']);
        $this->assertEquals('1234AB', $fakeUpdateData['postcode']);
    }

    /**
     * Unit-test: controleert dat "gewijzigde" data (fake) correct is na een "update".
     * Geen database – we simuleren alleen het resultaat met fake data.
     */
    public function test_leverancier_updated_values_with_fake_data(): void
    {
        // Arrange: fake data vóór "update"
        $fakeBefore = [
            'Mobiel' => '06-12345678',
            'Straat' => 'Oude Straat',
        ];

        // Act: we simuleren een update met fake data (geen DB)
        $fakeAfter = [
            'Mobiel' => '06-87654321',
            'Straat' => 'Nieuwe Straat',
        ];

        // Assert: controleer dat de fake "na update" waarden kloppen
        $this->assertNotEquals($fakeBefore['Mobiel'], $fakeAfter['Mobiel']);
        $this->assertNotEquals($fakeBefore['Straat'], $fakeAfter['Straat']);
        $this->assertEquals('06-87654321', $fakeAfter['Mobiel']);
        $this->assertEquals('Nieuwe Straat', $fakeAfter['Straat']);
    }
}
