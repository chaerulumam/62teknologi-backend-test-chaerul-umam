<?php

namespace App\Repositories;

interface BusinessRepositoryInterface
{
    public function businessDetails($id);
    public function create(array $data);
    public function updateDataById(Int $id, array $data);
    public function deleteDataById(Int $id);
    public function getDatabyParams($field = null, $keyword = null, $sortBy = null, $limit = null);
}
