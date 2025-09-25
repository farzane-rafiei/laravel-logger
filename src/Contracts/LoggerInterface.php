<?php

namespace Rafiei\LaravelLogger\Contracts;

interface LoggerInterface
{
    /**
     * Log a message with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return void
     */
    public function log($level, string $message, array $context = []);
}