<?php

namespace App\Http\Handlers\Books;

use App\UseCases\Exports\BooksExportUseCase;
use App\UseCases\Exports\Exporters\CSVBookExporter;
use App\UseCases\Exports\Exporters\XMLBookExporter;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
use JetBrains\PhpStorm\Pure;
use Lib\RequestHandler;
use Illuminate\Support\Facades\Validator as V;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class BooksExportHandler extends RequestHandler {
    #[Pure] public function __construct(
        private BooksExportUseCase $exportBooks,
        Request $request
    ) {
        parent::__construct($request);
    }

    protected function validator(): Validator
    {
        return V::make($this->request->all(), [
            'format' => 'required|string|in:xml,csv',
            'option' => 'required|integer|in:0,1,2,3'
        ]);
    }

    /**
     * @throws ValidationException
     */
    protected function handler(mixed $input): Response
    {
        $values = $this->validator->validated();

        /** @var XMLBookExporter|CSVBookExporter $exporter */
        $exporter = $this->exportBooks->run($values);

        return match($values['format']) {
            'csv' => Excel::download($exporter, 'exports.csv'),
            'xml' => response()->xml($exporter->getXML(), 'exports.xml')
        };
    }

    protected function onError(Exception $e): Exception|false
    {
        if ($e instanceof ValidationException) {
            $this->response = response()->json([
                'message' => 'Invalid arguments',
                'code' => 'InvalidArguments'
            ], 400);

            return false;
        }

        return parent::onError($e);
    }
}