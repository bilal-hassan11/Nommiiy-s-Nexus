<?php

namespace App\Services;

use App\Repositories\BaseRepository;

class BaseService
{
    protected $repository;

    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(array $with = [], array $columns = ['*'], array $conditions = [])
    {
        return $this->repository->all($with, $columns, $conditions);
    }

    
    public function paginate($perPage = 15, array $with = [], array $columns = ['*'], array $conditions = [], $sortOrder = 'asc', $sortBy = 'id')
    {
        return $this->repository->paginate($perPage, $with, $columns, $conditions, $sortOrder, $sortBy);
    }

    public function paginateDynamic($modelClass, $perPage = 15, array $with = [], array $columns = ['*'], array $conditions = [], $sortOrder = 'asc', $sortBy = 'id')
    {
        return $this->repository->paginateDynamic($modelClass, $perPage, $with, $columns, $conditions, $sortOrder, $sortBy);
    }
    
    


    public function getById($id, array $with = [], array $columns = ['*'])
    {
        return $this->repository->find($id, $with, $columns);
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    public function changeStatus(int $id, string $isActive)
{
    return $this->repository->updateStatus($id, $isActive);
}


  
}