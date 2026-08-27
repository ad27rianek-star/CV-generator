<?php

namespace Tests\Feature;

use Tests\TestCase;

class CvDownloadTest extends TestCase
{
    public function test_a_visitor_can_download_a_generated_cv_pdf(): void
    {
        $response = $this->post('/cv/download', [
            'template' => 'classic',
            'personal' => [
                'first_name' => 'Jan',
                'last_name' => 'Kowalski',
                'title' => 'Programista Full-Stack',
                'email' => 'jan@example.com',
                'phone' => '123456789',
                'city' => 'Warszawa',
                'summary' => 'Krótkie podsumowanie zawodowe.',
            ],
            'experience' => [
                ['company' => 'Acme Sp. z o.o.', 'position' => 'Backend Developer', 'period' => '2022 – obecnie', 'description' => 'Rozwój API.'],
                ['company' => '', 'position' => '', 'period' => '', 'description' => ''],
            ],
            'education' => [
                ['school' => 'Politechnika', 'field' => 'Informatyka', 'period' => '2018 – 2022'],
            ],
            'skills' => 'PHP, Laravel, JavaScript',
        ]);

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_the_modern_template_can_also_be_generated(): void
    {
        $response = $this->post('/cv/download', [
            'template' => 'modern',
            'personal' => [
                'first_name' => 'Anna',
                'last_name' => 'Nowak',
                'email' => 'anna@example.com',
            ],
        ]);

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_pdf_template_does_not_html_escape_the_font_family_declaration(): void
    {
        // Regression test: {{ }} previously escaped the quotes around the
        // DejaVu font names into &#039;, silently breaking the CSS and
        // making dompdf fall back to a font with no Polish glyph support.
        $html = view('pdf.cv', [
            'template' => 'classic',
            'personal' => ['first_name' => 'Ola', 'last_name' => 'Kowalska', 'title' => null, 'email' => 'a@a.com', 'phone' => null, 'city' => null, 'summary' => null],
            'experience' => [],
            'education' => [],
            'skills' => [],
        ])->render();

        $this->assertStringContainsString("'DejaVu Serif'", $html);
        $this->assertStringNotContainsString('&#039;', $html);
    }

    public function test_personal_data_is_required(): void
    {
        $response = $this->post('/cv/download', [
            'template' => 'classic',
        ]);

        $response->assertSessionHasErrors([
            'personal.first_name',
            'personal.last_name',
            'personal.email',
        ]);
    }
}
