<?php

declare(strict_types=1);

namespace App\Publications\Domain\Publication;

use App\SharedKernel\Domain\Assert\Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Контент публикации
 *
 * @ORM\Embeddable()
 */
class Content
{
    /**
     * @ORM\Column(type="string", name="title", nullable=false)
     */
    private string $title;

    /**
     * @ORM\Column(type="text", name="text", nullable=false)
     */
    private string $text;

    /**
     * @ORM\Embedded(class="App\Publications\Domain\Publication\Image")
     */
    private Image $image;

    public function __construct(
        string $title,
        string $text,
        Image $image
    ) {
        $this->setTitle($title);
        $this->setText($text);
        $this->image = $image;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getImage(): Image
    {
        return $this->image;
    }

    private function setTitle(string $title): void
    {
        Assert::notEmpty(
            $title,
            'Заголовок не может быть пустым.'
        );

        $this->title = $title;
    }

    private function setText(string $text): void
    {
        Assert::notEmpty(
            $text,
            'Основной текст не может быть пустым.'
        );

        $this->text = $text;
    }
}
