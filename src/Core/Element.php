<?php

namespace Shopware\Pdf\Core;

abstract class Element {
    protected float $x;
    protected float $y;

    public function getX(): float
    {
        return $this->x;
    }

    public function getY(): float
    {
        return $this->y;
    }

    public function setPosition(float $x, float $y): self
    {
        $this->x = $x;
        $this->y = $y;
        return $this;
    }

    abstract public function render(): string;
}