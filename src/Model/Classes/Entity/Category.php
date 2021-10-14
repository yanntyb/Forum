<?php

namespace Yanntyb\App\Model\Classes\Entity;

use Yanntyb\App\Model\Traits\GlobalEntityTrait;

class Category
{
    use GlobalEntityTrait;

    private string $color;
    private string $description;
    private int $archive;

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

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Category
     */
    public function setDescription(string $description): Category
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int
     */
    public function getArchive(): int
    {
        return $this->archive;
    }

    /**
     * @param int $archive
     * @return Category
     */
    public function setArchive(int $archive): Category
    {
        $this->archive = $archive;
        return $this;
    }




}