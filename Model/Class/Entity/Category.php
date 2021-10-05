<?php

use Controller\Traits\GlobalEntityTrait;

class Category
{
    use GlobalEntityTrait;

    private string $color;

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param string $color
     * @return $this
     */
    public function setColor(string $color): Category
    {
        $this->color = $color;
        return $this;
    }


}