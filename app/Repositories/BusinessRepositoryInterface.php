<?php

namespace App\Repositories;

interface BusinessRepositoryInterface
{
    public function businessDetails($id);
    public function create(array $data);
}
