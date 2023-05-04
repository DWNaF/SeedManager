<?php

class Seed
{
    // Attributs
    public int $id;
    public string $name;
    public string $family;
    public string $planting_period;
    public string $harvest_period;
    public string $advices;
    public string $image;
    public int $quantity;


    // Constructeur
    public function load(string $name, string $family, string $planting_period, string $harvest_period, string $advices, string $image, int $quantity)
    {
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
    public function getPlantingPeriod(): string
    {
        return $this->planting_period;
    }
    public function getHarvestPeriod(): string
    {
        return $this->harvest_period;
    }
    public function getAdvices(): string
    {
        return $this->advices;
    }
    public function getImage(): string
    {
        return $this->image;
    }
    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
