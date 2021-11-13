<?php

namespace Lib;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Exception;
use App\Exceptions\GeneralException;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;

abstract class RequestHandler {
    protected string $component;
    protected ?string $errorComponent = null;
    protected ?string $redirectTo = null;

    private InertiaResponse|Response $response;

    public function __construct(protected Request $request) { }

    public function response(): InertiaResponse|Response {
        return $this->response;
    }

    /**
     * @throws ValidationException
     */
    public function run() {
        $validator = $this->validator();
        $validator->validate();

        try {
            $this->response = $this->handler();
        } catch (Exception $e) {
            $e = $this->onError($e);
            $serializedError = serialize_exception($e);
            $component = $this->errorComponent ?? $this->component;

            if ($e instanceof GeneralException) {
                if ($this->redirectTo)
                    $this->response = response()->redirectTo($this->redirectTo);
                else
                    $this->response = $this->createInertiaRenderResponse($component, null, $serializedError) ;
            } else if ($e !== false) {
                throw $e;
            }
        }
    }

    protected function createInertiaRenderResponse(string $component, mixed $data, mixed $error): InertiaResponse {
        $props = [];

        if ($data) $props['data'] = $data;
        if ($error) $props['error'] = $error;

        return Inertia::render($component, $props);
    }

    protected function onError(Exception $e): Exception|false {
        return $e;
    }

    protected abstract function validator(): Validator;

    protected abstract function handler();
}