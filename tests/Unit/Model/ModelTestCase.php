<?php

namespace Tests\Unit\Model;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\TestCase;

abstract class ModelTestCase extends TestCase
{
    abstract protected function model(): Model;

    abstract protected function traits(): array;

    abstract protected function fillables(): array;

    abstract protected function casts(): array;

    public function testIfUseTraits(): void
    {
        $traitsNeed = $this->traits();

        $traitsUsed = array_keys(class_uses($this->model()));

        $this->assertEquals($traitsNeed, $traitsUsed);
    }

    public function testFillables(): void
    {
        $expected = $this->fillables();

        $fillable = $this->model()->getFillable();

        $this->assertEquals($expected, $fillable);
    }

    public function testIncrementingIsFalse(): void
    {
        $model = $this->model();

        $this->assertFalse($model->incrementing);
    }

    public function testHasCasts(): void
    {
        $exceptedCasts = $this->casts();

        $casts = $this->model()->getCasts();

        $this->assertEquals($exceptedCasts, $casts);
    }
}
