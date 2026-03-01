# Database – Opdracht 4

Create-scripts voor de Jamin-database (structuur, data, stored procedures) staan in:

- **`../database/createscript/complete_setup.sql`** – volledig create-script (7 tabellen + data + stored procedures, incl. Opdracht 4)
- **`opdracht4_update.sql`** – alleen wijzigingen voor Opdracht 4 (uitvoeren op bestaande database)

## Opdracht 4 – User Story 01

- Leverancier **ContactId** mag NULL (leverancier 7: Hom Ken Food).
- Nieuw product: **Drop ninja's** (Id 14).
- Nieuwe stored procedures: **sp_GetProductenMetAllergeen**, **sp_GetLeverancierGegevensByProductId**.

Voer bij een bestaande database eerst `opdracht4_update.sql` uit.
