<?php

namespace App\Filters;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;

class EvenementsFilter
{
    private string|int|bool|null|float|\DateTime $debut;
    private string|int|bool|null|float|\DateTime $fin;
    private string|int|bool|null|float|EntityType $sport;
    public function __construct(Request $request)
    {
        $this->debut = $request->query->get('debut');
        $this->fin = $request->query->get('fin');
        $this->sport = $request->query->get('sport');
    }

    public function getFilters(): array
    {
        $filters = [];
        if ($this->debut) {
            $filters['debut'] = $this->debut;
        }
        if ($this->fin) {
            $filters['fin'] = $this->fin;
        }
        if ($this->sport) {
            $filters['sport'] = $this->sport;
        }
        return $filters;
    }

    public function setDebut($getDebut): void
    {
        $this->debut = $getDebut;
    }

    public function setFin($getFin): void
    {
        $this->fin = $getFin;
    }

    public function setSport($getSport): void
    {
        $this->sport = $getSport;
    }

}
