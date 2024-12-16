<?php

namespace Shopware\Pdf\Core;

abstract class IndirectObject
{
    protected int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    abstract public function render(): string;
}