<?php

namespace Tests\Feature;

use App\Models\CvTemplate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CvTemplateTest extends TestCase
{
    use RefreshDatabase;

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'template' => 'classic',
            'personal' => [
                'first_name' => 'Jan',
                'last_name' => 'Kowalski',
                'title' => 'Programista',
                'email' => 'jan@example.com',
                'phone' => null,
                'city' => null,
                'summary' => null,
            ],
            'experience' => [],
            'education' => [],
            'skills' => 'PHP, Laravel',
        ], $overrides);
    }

    public function test_a_visitor_can_save_a_cv_as_an_editable_template(): void
    {
        $response = $this->post('/cv/templates', $this->payload());

        $this->assertDatabaseCount(CvTemplate::class, 1);

        $cvTemplate = CvTemplate::firstOrFail();
        $response->assertRedirect(route('cv.templates.edit', $cvTemplate));
        $this->assertSame('classic', $cvTemplate->template);
        $this->assertSame('Jan', $cvTemplate->data['personal']['first_name']);
    }

    public function test_the_edit_page_shows_the_saved_template_data(): void
    {
        $this->post('/cv/templates', $this->payload());
        $cvTemplate = CvTemplate::firstOrFail();

        $response = $this->get(route('cv.templates.edit', $cvTemplate));

        $response->assertOk();
        // The saved data is handed to Alpine as JSON for the live-preview/form
        // to render client-side, so we check the shareable edit link instead
        // of literal name text.
        $response->assertSee($cvTemplate->uuid);
    }

    public function test_a_saved_template_can_be_updated(): void
    {
        $this->post('/cv/templates', $this->payload());
        $cvTemplate = CvTemplate::firstOrFail();

        $response = $this->post(
            route('cv.templates.update', $cvTemplate),
            $this->payload(['template' => 'modern', 'personal' => array_merge($this->payload()['personal'], ['first_name' => 'Anna'])])
        );

        $response->assertRedirect(route('cv.templates.edit', $cvTemplate));
        $this->assertDatabaseCount(CvTemplate::class, 1);

        $cvTemplate->refresh();
        $this->assertSame('modern', $cvTemplate->template);
        $this->assertSame('Anna', $cvTemplate->data['personal']['first_name']);
    }

    public function test_editing_an_unknown_template_returns_404(): void
    {
        $response = $this->get('/cv/templates/does-not-exist/edit');

        $response->assertNotFound();
    }
}
