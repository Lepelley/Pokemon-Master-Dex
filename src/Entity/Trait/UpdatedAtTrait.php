<?php

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait UpdatedAtTrait
 */
trait UpdatedAtTrait
{
    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
