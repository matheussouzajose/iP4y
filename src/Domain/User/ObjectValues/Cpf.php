<?php

namespace Core\Domain\User\ObjectValues;

use Core\Domain\User\Exception\CpfInvalidException;
use Illuminate\Contracts\Container\BindingResolutionException;

class Cpf
{
    /**
     * @throws BindingResolutionException
     * @throws CpfInvalidException
     */
    public function __construct(protected string $value)
    {
        $this->validation($value);
    }

    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * @throws BindingResolutionException
     * @throws CpfInvalidException
     */
    private function validation(string $cpf): void
    {
        $this->value = preg_replace('/[^0-9]/', '', $cpf);
        $validation = (Validator())->make(['cpf' => $this->value], [
            'cpf' => 'required|cpf'
        ]);

        if ($validation->fails()) {
            throw CpfInvalidException::itemInvalid($this->value);
        }
    }
}
