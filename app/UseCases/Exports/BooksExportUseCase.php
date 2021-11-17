<?php

namespace App\UseCases\Exports;

use App\UseCases\Exports\Exporters\CSVBookExporter;
use App\UseCases\Exports\Exporters\XMLBookExporter;
use Lib\UseCase;
use Sabre\Xml\Service;

class BooksExportUseCase extends UseCase {
    private const EXPORT_FORMATS = ['csv', 'xml'];
    private string $format;
    private int $option;

    public function __construct(
        private Service $xml
    ) {}

    /**
     * 0 - full
     * 1 - id, title and author
     * 2 - id, title
     * 3 - author
     */
    private const EXPORT_OPTIONS = [
        0, 1, 2, 3
    ];

    protected function handler(mixed $input): XMLBookExporter|CSVBookExporter
    {
        $this->validateInputs($input);

        return match($this->format) {
            'csv' => CSVBookExporter::build(
                $this->getHeadingsForCSV(),
                $this->getCSVRowMapper(),
                $this->option === 3
            ),
            'xml' => XMLBookExporter::build(
                $this->getXMLRowMapper(),
                $this->xml,
                $this->option === 3
            )
        };
    }

    private function getXMLRowMapper(): \Closure
    {
        $createXMLEntryForBook = fn (int $id, array $value) => [
            'name' => 'book',
            'attributes' => [
                'id' => $id . ''
            ],
            'value' => $value
        ];

        return fn (mixed $row) => match($this->option) {
            1 => $createXMLEntryForBook($row->id, [
                'title' => $row->title,
                'author' => $row->author
            ]),
            2 => $createXMLEntryForBook($row->id, [
                'title' => $row->title,
            ]),
            3 => [
                'author' => [
                    'name' => 'name',
                    'value' => $row->author
                ]
            ],
            default => $createXMLEntryForBook($row->id, [
                'title' => $row->title,
                'author' => $row->author,
                'description' => $row->description,
                'image' => $row->image
            ])
        };
    }

    private function getCSVRowMapper(): \Closure
    {
        return fn (mixed $row) => match($this->option) {
            1 => [$row->id, $row->title, $row->author],
            2 => [$row->id, $row->title],
            3 => [$row->author],
            default => [
                $row->id,
                $row->title,
                $row->author,
                $row->description,
                $row->image
            ]
        };
    }

    private function getHeadingsForCSV(): array
    {
        return match($this->option)
        {
            1 => ['ID', 'Title', 'Author'],
            2 => ['ID', 'Title'],
            3 => ['Authors'],
            default => ['ID', 'Title', 'Author', 'Description', 'Image URL']
        };
    }

    private function validateInputs(array $input)
    {
        /**
         * @var string $format
         * @var int $option
         */
        extract($input);

        if (
            !in_array($format, self::EXPORT_FORMATS) ||
            !in_array($option, self::EXPORT_OPTIONS)
        ) throw new \Error("Invalid arguments." );

        $this->format = $format;
        $this->option = $option;
    }
}