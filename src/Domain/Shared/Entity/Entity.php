<?php

namespace Core\Domain\Shared\Entity;

use Core\Domain\Shared\Exception\PropertyException;
use Core\Domain\Shared\NotificationPattern\Notification;

class Entity
{
    protected Notification $notification;

    public function __construct()
    {
        $this->notification = new Notification();
    }

    /**
     * @throws \Exception
     */
    public function __get($property)
    {
        if (isset($this->{$property})) {
            return $this->{$property};
        }

        $className = get_class($this);
        throw PropertyException::propertyNotFound($property, $className);
    }

    public function id(): string
    {
        return (string) $this->id;
    }

    public function createdAt(): string
    {
        return $this->createdAt->format('Y-m-d H:i:s');
    }
}
