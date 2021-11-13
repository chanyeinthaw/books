<?php

namespace Tests\Traits;

use Illuminate\Support\Facades\Storage;

trait MockedDisk {
    protected function mockDisk() {
        Storage::fake(env('FILESYSTEM_DRIVER'));
    }

    protected function getMockedDisk() {
        return Storage::disk(env('FILESYSTEM_DRIVER'));
    }
}