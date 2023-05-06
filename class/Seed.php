<?php

class Seed
{
    // Attributs
    private int $seed_id;
    private string $seed_name;
    private int $family;
    private ?int $planting_period_min;
    private ?int $planting_period_max;
    private ?int $harvest_period_min;
    private ?int $harvest_period_max;
    private ?string $advices;
    private ?string $image;
    private int $quantity;

    /**
     * Crée un nouvel objet Seed
     * @param string $name Le nom de la graine
     * @param int $family L'id de la famille de la graine
     * @param int|null $planting_period_min La période de plantation minimale de la graine (en mois)
     * @param int|null $planting_period_max La période de plantation maximale de la graine (en mois)
     * @param int|null $harvest_period_min La période de récolte minimale de la graine (en mois)
     * @param int|null $harvest_period_max La période de récolte maximale de la graine (en mois)
     * @param string|null $advices Les conseils de plantation de la graine
     * @param string|null $image Nom du fichier image de la graine
     * @param int|null $quantity La quantité de graines restantes en stock
     * @return Seed L'objet Seed créé
     */
    public static function new(string $name, int $family, ?int $planting_period_min, ?int $planting_period_max, ?int $harvest_period_min, ?int $harvest_period_max, ?string $advices, ?string $image, ?int $quantity): Seed
    {
        $seed = new Seed();

        $seed->seed_name = $name;
        $seed->family = $family;
        $seed->planting_period_min = $planting_period_min;
        $seed->planting_period_max = $planting_period_max;
        $seed->harvest_period_min = $harvest_period_min;
        $seed->harvest_period_max = $harvest_period_max;
        $seed->advices = $advices;
        $seed->image = $image;

        if (!empty($quantity)) {
            $seed->quantity = $quantity;
        } else $seed->quantity = 0;

        return $seed;
    }

    // Guetteurs 
    public function getId(): int
    {
        return $this->seed_id;
    }

    public function getName(): string
    {
        return $this->seed_name;
    }

    public function getFamily(): int
    {
        return $this->family;
    }

    public function getPlantingPeriodMin(): ?int
    {
        return $this->planting_period_min;
    }

    public function getPlantingPeriodMax(): ?int
    {
        return $this->planting_period_max;
    }

    public function getHarvestPeriodMin(): ?int
    {
        return $this->harvest_period_min;
    }

    public function getHarvestPeriodMax(): ?int
    {
        return $this->harvest_period_max;
    }

    public function getAdvices(): ?string
    {
        return $this->advices;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    // Setteurs
    public function setName(string $name): void
    {
        $this->seed_name = $name;
    }

    public function setFamily(int $family): void
    {
        $this->family = $family;
    }

    public function setPlantingPeriodMin(?int $planting_period_min): void
    {
        $this->planting_period_min = $planting_period_min;
    }

    public function setPlantingPeriodMax(?int $planting_period_max): void
    {
        $this->planting_period_max = $planting_period_max;
    }

    public function setHarvestPeriodMin(?int $harvest_period_min): void
    {
        $this->harvest_period_min = $harvest_period_min;
    }

    public function setHarvestPeriodMax(?int $harvest_period_max): void
    {
        $this->harvest_period_max = $harvest_period_max;
    }

    public function setAdvices(?string $advices): void
    {
        $this->advices = $advices;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }
}
