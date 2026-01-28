# Filmpje Unit-test (max. 45 seconden)

## Opname starten
- **Windows-toets + Ctrl + R** = opname starten (Xbox Game Bar)
- Of: **Windows + G** → daarna op **Record** klikken

---

## Wat laten zien in het filmpje (max. 45 sec)

### 1. Test-code laten zien (ca. 15–20 sec)
- Open in VS Code: **`tests/Unit/jamin/LeverancierUpdateTest.php`**
- Laat het bestand zien (scroll eventueel zodat de test-methodes zichtbaar zijn)
- De teacher moet kunnen zien: class, test-methodes, assertions

### 2. Test runnen in de terminal (ca. 20–25 sec)
- Open de **Terminal** in VS Code (of PowerShell)
- Ga naar de projectmap (bijv. `cd C:\Users\naji2\Desktop\opdracht2`)
- Voer uit:
  ```bash
  php vendor/bin/phpunit tests/unit/jamin
  ```
- Wacht tot je **OK (2 tests, 11 assertions)** ziet
- Klaar

### 3. Opname stoppen
- **Windows + Ctrl + R** opnieuw om te stoppen
- Het filmpje wordt opgeslagen (meestal in **Videos/Captures**)

---

## Als het pad niet werkt op Windows
Probeer dan:
```bash
php vendor/bin/phpunit tests/Unit/jamin
```
(met hoofdletter U in Unit)

---

# Hoe test je? (Unit-tests runnen)

**Belangrijk:** De unit-tests gebruiken **geen echte database** – alleen fake data (nep data).

## 1. Terminal openen in je projectmap
```bash
cd C:\Users\naji2\Desktop\opdracht2
```
(of de map waar je Laravel-project staat)

## 2. Welke tests runnen?

| Wat runnen | Commando | Verwacht resultaat |
|------------|---------|--------------------|
| **Alleen de jamin-tests** (voor het filmpje) | `php vendor/bin/phpunit tests/unit/jamin` | OK (2 tests, 11 assertions) |
| **Alleen LeverancierUpdateTest** | `php vendor/bin/phpunit tests/Unit/LeverancierUpdateTest.php` | OK (2 tests, 8 assertions) |
| **Alle Unit-tests** | `php vendor/bin/phpunit tests/Unit` | OK (4 tests, 19 assertions) |

## 3. Voorbeelden
```bash
# Alleen tests in de map jamin (zoals de docent vraagt)
php vendor/bin/phpunit tests/unit/jamin

# Eén specifiek testbestand
php vendor/bin/phpunit tests/Unit/LeverancierUpdateTest.php

# Alle unit-tests
php vendor/bin/phpunit tests/Unit
```

## 4. Geslaagd?
Je ziet dan iets als:
```
OK (2 tests, 11 assertions)
```
of
```
OK (4 tests, 19 assertions)
```
Geen rode errors = tests zijn geslaagd.
