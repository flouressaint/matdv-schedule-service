<?php

declare(strict_types=1);

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class SetScoresListRequest
{
    #[Assert\Type('countable')]
    #[Assert\All(new Assert\Type(type: ScoreListItem::class))]
    #[Assert\Valid]
    /**
     * @var ScoreListItem[]
     */
    private array $scores;

    /**
     * @return ScoreListItem[]
     */
    public function getScores(): array
    {
        return $this->scores;
    }

    /**
     * @param ScoreListItem[] $scores
     */
    public function setScores(array $scores): self
    {
        $this->scores = $scores;

        return $this;
    }
}