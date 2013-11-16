<?php namespace MODX\Command\System;

use MODX\Command\ProcessorCmd;

class ClearCache extends ProcessorCmd
{
    protected $processor = 'system/clearcache';

    protected $defaultOptions = array();

    protected $name = 'system:clearcache';
    protected $description = 'Clears MODX cache';

    protected function processResponse(array $response = array())
    {
        $this->info('Cache cleared');
    }
}
