# Generator CV

Prosty generator CV online zbudowany w [Laravel](https://laravel.com) 13 + Tailwind CSS 4 + [Alpine.js](https://alpinejs.dev).
Wypełniasz formularz, widzisz podgląd CV na żywo, wybierasz jeden z dwóch szablonów i pobierasz gotowe CV jako PDF.

## Funkcje

- Formularz z danymi osobowymi, doświadczeniem zawodowym, wykształceniem i umiejętnościami (pola powtarzalne — dodawaj/usuwaj wpisy)
- Podgląd CV na żywo, aktualizowany w czasie rzeczywistym w trakcie wypełniania formularza (Alpine.js, bez przeładowania strony)
- Dwa szablony wizualne: **Klasyczny** i **Nowoczesny**
- Eksport do PDF ([dompdf](https://github.com/dompdf/dompdf))
- Zapis CV jako szablonu do edycji później — generuje unikalny link (bez logowania), pod którym można wrócić i zaktualizować dane

## Wymagania

- PHP >= 8.3
- Composer
- Node.js + npm

## Szybki start

```bash
composer install
cp .env.example .env
php artisan key:generate

npm install
npm run build

php artisan serve
```

Po uruchomieniu `php artisan serve` strona będzie dostępna pod `http://127.0.0.1:8000`.

Pobieranie CV jako PDF działa bez zapisywania czegokolwiek — dane z formularza trafiają bezpośrednio do generatora PDF
w ramach jednego żądania. Opcja **„Zapisz jako szablon”** zapisuje dane w bazie (SQLite) i generuje unikalny,
niedomyślny do odgadnięcia link do edycji — każdy, kto ten link zna, może edytować dany szablon (nie ma kont
użytkowników), więc nie udostępniaj go publicznie.

### Tryb developerski (auto-przebudowa CSS/JS)

```bash
npm run dev
```

i w drugim terminalu:

```bash
php artisan serve
```

## Struktura projektu

- `app/Http/Controllers/CvController.php` — wyświetla formularz i generuje PDF
- `app/Http/Controllers/CvTemplateController.php` — zapis/edycja/aktualizacja zapisanych szablonów CV
- `app/Models/CvTemplate.php` — zapisany szablon CV (identyfikowany przez UUID w URL)
- `app/Http/Requests/StoreCvRequest.php` — walidacja danych CV i przygotowanie ich do renderowania
- `resources/views/cv/create.blade.php` — formularz + podgląd na żywo (Alpine.js), używany zarówno dla nowego CV, jak i edycji zapisanego szablonu
- `resources/views/pdf/cv.blade.php` + `resources/views/pdf/partials/body.blade.php` — szablon PDF (dompdf)

## Uwaga dot. czcionek w PDF

Szablony PDF używają czcionek `DejaVu Sans` / `DejaVu Serif` (wbudowane w dompdf), ponieważ obsługują polskie znaki
diakrytyczne (ą, ę, ś, ć, ż, ź, ł, ń, ó) — domyślne czcionki PDF (Helvetica, Times) ich nie wspierają.
