<?php

class Seed
{
    // Attributs
    public int $id;
    public string $name;
    public string $family;
    public ?int $planting_period;
    public ?int $harvest_period;
    public ?string $advices;
    public ?string $image;
    public ?int $quantity;


    public function load(int $id, string $name, string $family, ?int $planting_period, ?int $harvest_period, ?string $advices, ?string $image, ?int $quantity)
    {
        $this->id = $id;
        $this->name = $name;
        $this->family = $family;
        $this->planting_period = $planting_period;
        $this->harvest_period = $harvest_period;
        $this->advices = $advices;
        $this->image = $image;
        $this->quantity = $quantity;
    }



    // Getters
    public function getId(): int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getFamily(): string
    {
        return $this->family;
    }
    public function getPlantingPeriod(): ?int
    {
        return $this->planting_period;
    }
    public function getHarvestPeriod(): ?int
    {
        return $this->harvest_period;
    }
    public function getAdvices(): ?string
    {
        return $this->advices;
    }
    public function getImage(): ?string
    {
        return $this->image;
    }
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }
}
