<?php

namespace Framework;


class RepositoryFactory
{
    private $pdo;
    private  $repositories = [];

         public function setPdo(\PDO $pdo)
    {
        $this->pdo = $pdo;
        return $this;
    }

    public function createRepository($entityName)
    {
        if (isset($this->repositories[$entityName])){
            return $this->repositories[$entityName];
        }

        $className = "\\Model\\Repository\\{$entityName}Repository";

        $reposit = new $className();
        $reposit->setPdo($this->pdo);
        $this->repositories[$entityName] = $reposit;
        return $reposit;


    }
}