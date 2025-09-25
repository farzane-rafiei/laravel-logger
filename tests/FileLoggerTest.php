<?php
namespace Rafiei\LaravelLogger\Tests;

use PHPUnit\Framework\TestCase;
use Rafiei\LaravelLogger\Drivers\FileLogger;

class FileLoggerTest extends TestCase
{
    private string $tmpDir;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tmpDir = sys_get_temp_dir() . '/filelogger_test_' . uniqid();
        if (!file_exists($this->tmpDir)) {
            mkdir($this->tmpDir, 0755, true);
        }
    }

    protected function tearDown(): void
    {
        $logfile = $this->tmpDir . DIRECTORY_SEPARATOR . date('Y-m-d') . '.log';
        if (file_exists($logfile)) {
            unlink($logfile);
        }

        parent::tearDown();
    }

    public function test_it_creates_log_file_and_writes_message()
    {
        $logger = new FileLogger(['path' => $this->tmpDir]);
        $logger->info('Hello world');
        $logfile = $this->tmpDir . DIRECTORY_SEPARATOR . date('Y-m-d') . '.log';
        $this->assertFileExists($logfile);
        $this->assertStringContainsString('info: Hello world', file_get_contents($logfile));
    }
}