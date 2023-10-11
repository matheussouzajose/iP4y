<?php

namespace tests\Unit\Domain\User\ObjectValues;

use Core\Domain\User\Exception\CpfInvalidException;
use Core\Domain\User\ObjectValues\Cpf;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\TestCase;

class CpfUnitTest extends TestCase
{
    /**
     * @throws BindingResolutionException
     * @throws CpfInvalidException
     */
    public function test_throw_cpf_error()
    {
        $invalidCpf = '123456789';
        $this->expectExceptionObject(new CpfInvalidException("O cpf {$invalidCpf} não é um CPF válido.", 422));

        new Cpf($invalidCpf);
    }

    /**
     * @throws BindingResolutionException
     * @throws CpfInvalidException
     */
    public function test_new_cpf_success()
    {
        $cpf = '28508617070';

        $newCpf = new Cpf($cpf);

        $this->assertEquals($cpf, (string) $newCpf);
    }
}
