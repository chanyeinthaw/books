<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExportBooksTest extends TestCase
{
    use RefreshDatabase;
    private bool $seed = true;

    public function test_can_download_csv()
    {
        $response = $this->get('/export?format=csv&option=1');

        $response->assertStatus(200)
            ->assertDownload('exports.csv');
    }

    public function test_can_download_xml()
    {
        $response = $this->get('/export?format=xml&option=2');

        $response->assertStatus(200)
            ->assertDownload('exports.xml');
    }

    public function test_should_response_error_for_invlaid_arguments()
    {
        $response = $this->get('/export?format=invalid&option=4');

        $response->assertStatus(400)
            ->assertJson([
                'message' => 'Invalid arguments',
                'code' => 'InvalidArguments'
            ]);
    }
}
