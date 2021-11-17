<?php

namespace App\UseCases\Exports\Exporters;

use App\Models\Book;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;
use Sabre\Xml\Service;

class XMLBookExporter
{
    #[Pure] public function __construct(
        private \Closure $rowMapper,
        private Service $xml,
        private bool $authorsOnly = false,
    ){}

    private function getBooks(): Collection
    {
        if ($this->authorsOnly) {
            return Book::query()
                ->select(['author'])
                ->distinct()
                ->get();
        }

        return Book::all();
    }

    public function getXML(): string
    {
        $books = $this->getBooks();

        $xmlData = $books->map($this->rowMapper)->toArray();

        return $this->xml->write(
            $this->authorsOnly ? 'authors' : 'catalog',
            $xmlData
        );
    }

    #[Pure] public static function build(\Closure $rowMapper, Service $xml, bool $authorsOnly = false): static
    {
        return new static($rowMapper, $xml, $authorsOnly);
    }
}
