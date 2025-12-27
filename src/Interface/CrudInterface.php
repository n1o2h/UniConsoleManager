<?php
namespace App\Interface;

interface CrudInterface
{
    public function save(): bool;
    public function findAll(): array;
    public function update(): bool;
    public function delete(): bool;
}