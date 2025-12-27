<?php
namespace App\Service;
use App\Repository\DepartmentRepository;
use App\Repository\CourRepository;
use App\Repository\EtudiantRepository;
use App\Repository\FormateurRepository;

class UniversityService
{
    public static function getCoursesByDepartement(int $deptId): array {
        return CourRepository::findByDepartement($deptId);
    }

    public static function getEtudiantsByDepartement(int $deptId): array {
        return EtudiantRepository::findByDepartement($deptId);
    }

    public static function getCoursesByFormateur(int $formateurId): array {
        return FormateurRepository::getCoursesByFormateur($formateurId);
    }
}