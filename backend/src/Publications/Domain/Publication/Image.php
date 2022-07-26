<?php

declare(strict_types=1);

namespace App\Publications\Domain\Publication;

use Doctrine\ORM\Mapping as ORM;

/**
 * Изображение контента
 *
 * @ORM\Embeddable()
 */
class Image
{
    /**
     * @ORM\Column(type="string", name="id", nullable=false)
     */
    private string $id;

    public function __construct(string $id)
    {
        $this->setId($id);
    }

    public function getId(): string
    {
        return $this->id;
    }

    private function setId(string $id): void
    {
        $imageId = $id;
        if (empty($imageId)) {
            $imageId = 'default';
        }

        $this->id = $imageId;
    }
}
