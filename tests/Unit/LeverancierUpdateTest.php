<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Leverancier;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class LeverancierUpdateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test successful update of leverancier information
     * This tests the update method logic for a successful scenario
     */
    public function test_leverancier_update_success(): void
    {
        // Arrange: Create contact and leverancier
        $contact = Contact::create([
            'Straat' => 'Teststraat',
            'Huisnummer' => '123',
            'Postcode' => '1234AB',
            'Stad' => 'Teststad',
            'IsActief' => true
        ]);

        $leverancier = Leverancier::create([
            'Naam' => 'Test Leverancier',
            'ContactPersoon' => 'Test Contact',
            'LeverancierNummer' => 'L1234567890',
            'Mobiel' => '06-12345678',
            'ContactId' => $contact->Id,
            'IsActief' => true
        ]);

        // Act: Update leverancier
        $leverancier->Mobiel = '06-87654321';
        $leverancier->save();

        $contact->Straat = 'Nieuwe Straat';
        $contact->save();

        // Assert: Verify the update was successful
        $this->assertEquals('06-87654321', $leverancier->fresh()->Mobiel);
        $this->assertEquals('Nieuwe Straat', $contact->fresh()->Straat);
        $this->assertNotNull($leverancier->fresh()->DatumGewijzigd);
    }

    /**
     * Test that DatumGewijzigd is updated when leverancier is modified
     * This tests the automatic timestamp update functionality
     */
    public function test_leverancier_datum_gewijzigd_updates_on_change(): void
    {
        // Arrange: Create contact and leverancier
        $contact = Contact::create([
            'Straat' => 'Teststraat',
            'Huisnummer' => '123',
            'Postcode' => '1234AB',
            'Stad' => 'Teststad',
            'IsActief' => true
        ]);

        $leverancier = Leverancier::create([
            'Naam' => 'Test Leverancier',
            'ContactPersoon' => 'Test Contact',
            'LeverancierNummer' => 'L1234567891',
            'Mobiel' => '06-12345678',
            'ContactId' => $contact->Id,
            'IsActief' => true
        ]);

        $originalDatumGewijzigd = $leverancier->DatumGewijzigd;

        // Wait a moment to ensure timestamp difference
        sleep(1);

        // Act: Update leverancier
        $leverancier->Mobiel = '06-99999999';
        $leverancier->save();

        // Assert: Verify DatumGewijzigd was updated
        $updatedLeverancier = $leverancier->fresh();
        $this->assertNotEquals(
            $originalDatumGewijzigd->format('Y-m-d H:i:s'),
            $updatedLeverancier->DatumGewijzigd->format('Y-m-d H:i:s')
        );
        $this->assertTrue(
            $updatedLeverancier->DatumGewijzigd->gt($originalDatumGewijzigd)
        );
    }
}

