<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function get(): array;

    public function first(): ?object;
}