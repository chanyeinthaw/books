<?php

namespace Lib;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Exception;
use App\Exceptions\GeneralException;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator as V;
use Illuminate\Validation\ValidationException;

abstract class RequestHandler {
    protected string $component;
    protected ?string $errorComponent = null;
    protected ?string $redirectTo = null;
    protected bool $backOnError = false;
    protected Validator $validator;

    protected InertiaResponse|Response $response;

    public function __construct(protected Request $request) { }

    public function response(): InertiaResponse|Response {
        return $this->response;
    }


    public function run(mixed $input) {
        try {
            $validator = $this->validator();
            $validator->validate();
            $this->validator = $validator;
            $this->response = $this->handler($input);
        } catch (Exception $e) {
            $e = $this->onError($e);

            if ($e instanceof GeneralException) {
                $serializedError = serialize_exception($e);

                if ($this->backOnError)
                    $this->response = redirect()
                        ->back()
                        ->with('error', $serializedError);
                else if ($this->redirectTo)
                    $this->response = response()
                        ->redirectTo($this->redirectTo)
                        ->with('error', $serializedError);
                else
                    $this->response = $this->createInertiaRenderResponse([
                        'error' => $serializedError
                    ], $this->errorComponent ?? $this->component);
            } else if ($e !== false) {
                throw $e;
            }
        }
    }

    protected function createInertiaRenderResponse(mixed $props, ?string $component = null): InertiaResponse {
        return Inertia::render($component ?? $this->component, $props);
    }

    protected function onError(Exception $e): Exception|false {
        return $e;
    }

    protected function validator(): Validator {
        return V::make($this->request->all(), []);
    }

    protected abstract function handler(mixed $input);
}