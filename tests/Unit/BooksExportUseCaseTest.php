<?php

namespace Tests\Unit;


use App\UseCases\Exports\BooksExportUseCase;
use App\UseCases\Exports\Exporters\CSVBookExporter;
use App\UseCases\Exports\Exporters\XMLBookExporter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Sabre\Xml\Service;
use Tests\TestCase;

class BooksExportUseCaseTest extends TestCase
{
    use RefreshDatabase;

    private bool $seed = true;
    private BooksExportUseCase $exportBooks;

    protected function setUp(): void
    {
        $this->exportBooks = new BooksExportUseCase(
            new Service()
        );
    }

    public function test_should_get_csv_exporter_instance()
    {
       $exporter = $this->exportBooks->run([
           'format' => 'csv',
           'option' => 0
       ]);

       $this->assertTrue($exporter instanceof CSVBookExporter);
    }

    public function test_should_get_xml_exporter_instance()
    {
        $exporter = $this->exportBooks->run([
            'format' => 'xml',
            'option' => 0
        ]);

        $this->assertTrue($exporter instanceof XMLBookExporter);
    }

    public function test_should_get_error_for_invalid_arguments()
    {
        $this->expectErrorMessage("Invalid arguments.");
        $this->exportBooks->run([
            'format' => 'xlsx',
            'option' => 5
        ]);
    }
}
