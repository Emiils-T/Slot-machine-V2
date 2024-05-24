<?php
class Combination
{
    private array $position;
    public function __construct(array $position)
    {
        $this->position = $position;
    }
    public function getPosition(): array
    {
        return $this->position;
    }
}
?>