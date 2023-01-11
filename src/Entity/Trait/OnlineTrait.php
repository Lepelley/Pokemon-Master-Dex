<?php

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait OnlineTrait
 */
trait OnlineTrait
{
    #[ORM\Column]
    private ?bool $isOnline = null;

    public function isOnline(): ?bool
    {
        return $this->isOnline;
    }

    public function setIsOnline(bool $isOnline): self
    {
        $this->isOnline = $isOnline;

        return $this;
    }
}
