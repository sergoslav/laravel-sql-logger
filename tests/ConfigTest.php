<?php

namespace Mnabialek\LaravelSqlLogger\Tests;

use Illuminate\Contracts\Config\Repository;
use Mnabialek\LaravelSqlLogger\Config;
use Mockery;

class ConfigTest extends UnitTestCase
{
    /**
     * @var Repository|\Mockery\Mock
     */
    protected $repository;

    /**
     * @var Config|\Mockery\Mock
     */
    protected $config;

    protected function setUp()
    {
        $this->repository = Mockery::mock(Repository::class);
        $this->config = new Config($this->repository);
    }

    /** @test */
    public function it_returns_valid_values_for_logAllQueries()
    {
        $this->repository->shouldReceive('get')->once()->with('sql_logger.all_queries.enabled')
            ->andReturn(1);
        $this->assertTrue($this->config->logAllQueries());

        $this->repository->shouldReceive('get')->once()->with('sql_logger.all_queries.enabled')
            ->andReturn(0);
        $this->assertFalse($this->config->logAllQueries());
    }

    /** @test */
    public function it_returns_valid_values_for_logSlowQueries()
    {
        $this->repository->shouldReceive('get')->once()->with('sql_logger.slow_queries.enabled')
            ->andReturn(1);
        $this->assertTrue($this->config->logSlowQueries());

        $this->repository->shouldReceive('get')->once()->with('sql_logger.slow_queries.enabled')
            ->andReturn(0);
        $this->assertFalse($this->config->logSlowQueries());
    }

    /** @test */
    public function it_returns_valid_value_for_slowLogTime()
    {
        $value = '700';
        $this->repository->shouldReceive('get')->once()->with('sql_logger.slow_queries.min_exec_time')
            ->andReturn($value);
        $this->assertSame($value, $this->config->slowLogTime());
    }

    /** @test */
    public function it_returns_valid_values_for_overrideFile()
    {
        $this->repository->shouldReceive('get')->once()->with('sql_logger.all_queries.override_log')
            ->andReturn(1);
        $this->assertTrue($this->config->overrideFile());

        $this->repository->shouldReceive('get')->once()->with('sql_logger.all_queries.override_log')
            ->andReturn(0);
        $this->assertFalse($this->config->overrideFile());
    }

    /** @test */
    public function it_returns_valid_value_for_logDirectory()
    {
        $value = 'sample directory';
        $this->repository->shouldReceive('get')->once()->with('sql_logger.general.directory')
            ->andReturn($value);
        $this->assertSame($value, $this->config->logDirectory());
    }

    /** @test */
    public function it_returns_valid_values_for_useSeconds()
    {
        $this->repository->shouldReceive('get')->once()->with('sql_logger.general.use_seconds')
            ->andReturn(1);
        $this->assertTrue($this->config->useSeconds());

        $this->repository->shouldReceive('get')->once()->with('sql_logger.general.use_seconds')
            ->andReturn(0);
        $this->assertFalse($this->config->useSeconds());
    }

    /** @test */
    public function it_returns_valid_values_for_consoleSuffix()
    {
        $this->repository->shouldReceive('get')->once()->with('sql_logger.general.console_log_suffix')
            ->andReturn('-artisan');
        $this->assertSame('-artisan', $this->config->consoleSuffix());

        $this->repository->shouldReceive('get')->once()->with('sql_logger.general.console_log_suffix')
            ->andReturn('');
        $this->assertSame('', $this->config->consoleSuffix());
    }
}
