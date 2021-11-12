<?php

namespace Lib;

use Exception;

abstract class UseCase {
    protected bool $silenceOnError = false;

    public function run(mixed $input) : mixed {
        try {
            return $this->handler($input);
        } catch (Exception $e) {
            $e = $this->onError($e);
            if ($e && !$this->silenceOnError) throw $e;
        }

        return null;
    }

    protected function onError(Exception $e) : Exception|false {
        return $e;
    }

    protected abstract function handler(mixed $input) : mixed;
}