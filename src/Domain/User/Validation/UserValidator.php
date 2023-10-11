<?php

namespace Core\Domain\User\Validation;

use Core\Domain\Shared\Entity\Entity;
use Core\Domain\Shared\Validation\ValidatorInterface;
use Rakit\Validation\Validator;

class UserValidator implements ValidatorInterface
{
    public function validate(Entity $entity): void
    {
        $data = $this->convertEntityForArray($entity);

        $validation = (new Validator())->validate($data, [
            'firstName' => 'required|min:3|max:255',
            'lastName' => 'required|min:3|max:255',
            'email' => 'required|email',
        ]);

        if ($validation->fails()) {
            foreach ($validation->errors()->all() as $error) {
                $entity->notification->addError([
                    'context' => 'user',
                    'message' => $error,
                ]);
            }
        }
    }

    private function convertEntityForArray(Entity $entity): array
    {
        return [
            'firstName' => $entity->firstName,
            'lastName' => $entity->lastName,
            'email' => $entity->email,
        ];
    }
}
