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

class CSVBookExporter implements FromCollection, WithProperties, WithHeadings, WithMapping
{
    use Exportable;

    public function __construct(
        private array $headings,
        private \Closure $rowMapper,
        private bool $authorsOnly = false
    ) {}

    public function collection(): Collection
    {
        if ($this->authorsOnly) {
            return Book::query()
                ->select(['author'])
                ->distinct()
                ->get();
        }
        return Book::all();
    }

    #[ArrayShape(['title' => "string"])]
    public function properties(): array
    {
        return [
            'title' => 'Books',
        ];
    }

    #[Pure] public function headings(): array
    {
        return $this->headings;
    }

    public function map($row): array
    {
        return call_user_func($this->rowMapper, $row);
    }

    #[Pure] public static function build(array $headings, \Closure $rowMapper, bool $authorsOnly = false): static
    {
        return new static($headings, $rowMapper, $authorsOnly);
    }
}
