<?php

namespace App\Controller\Admin;

use App\Repository\AgeCategoryRepository;
use App\Repository\DepartementRepository;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\NonUniqueResultException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersStatsController extends AbstractController
{
    /**
     * @var RoleRepository
     */
    private $roleRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var AgeCategoryRepository
     */
    private $ageCategoryRepository;
    /**
     * @var array
     */
    private $roles_labels = [];
    /**
     * @var array
     */
    private $users_count_roles = [];
    /**
     * @var array
     */
    private $users_count_age = [];
    /**
     * @var array
     */
    private $age_cat_labels = [];
    /**
     * @var array
     */
    private $users_count_dpt = [];
    /**
     * @var array
     */
    private $dpt_num = [];
    /**
     * @var DepartementRepository
     */
    private $departementRepository;
    private $year;
    /**
     * @var array
     */
    private $test;

    public function __construct(RoleRepository $roleRepository,
                                UserRepository $userRepository,
                                AgeCategoryRepository $ageCategoryRepository,
                                DepartementRepository $departementRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->userRepository = $userRepository;
        $this->ageCategoryRepository = $ageCategoryRepository;
        $this->departementRepository = $departementRepository;
        $this->year = '2020';

        $this->test = [];

//        foreach ($years as $year){
//            array_push($this->test[$year], $this->countUserPerMonth($year));
//        }

        $this->initVariables();
    }

    /**
     * @Route("/users-stats", name="users-stats")
     *
     * @throws Exception
     */
    public function index(): Response
    {
        return $this->render('bundles/EasyAdminBundle/page/users_stats.html.twig', [
            'roles_labels' => $this->roles_labels,
            'users_count_roles' => $this->users_count_roles,
            'users_count_age' => $this->users_count_age,
            'age_cat_labels' => $this->age_cat_labels,
            'dpt_num' => $this->dpt_num,
            'users_count_dpt' => $this->users_count_dpt,
            'year' => $this->year,
            'register_per_year' => $this->countUserPerYear(),
        ]);
    }

    private function countUserPerYear(): array
    {
        $user_per_years = [];

        foreach (range((new DateTime())->format('Y'), 2018) as $year) {
            $user_per_years[$year] = 0;
            try {
                $user_per_years[$year] = $this->countUserPerMonth((string) $year);
            } catch (Exception $e) {
            }
        }

        return $user_per_years;
    }

    /**
     * Number of registrations per month, according to the past year in parameter.
     *
     * @param $year : Year
     *
     * @throws Exception
     */
    private function countUserPerMonth($year): array
    {
        //TODO : A refaire
        $userPerMonth = [];

        foreach (range(1, 12) as $item) {
            $userPerMonth[$item] = 0;
        }

        foreach ($this->userRepository->findAll() as $user) {
            $date = new DateTime($user->getDateLastConnection());
            if ($date->format('Y') === $year && 'ROLE_USER' == $user->getRoles()) {
                ++$userPerMonth[$date->format('m')];
            }
        }

        $arr = [];
        foreach ($userPerMonth as $value) {
            array_push($arr, $value);
        }

        return $arr;
    }

    /**
     * Initialize dataset.
     */
    private function initVariables()
    {
        foreach ($this->roleRepository->findAll() as $role) {
            array_push($this->roles_labels, $role->getLabel());
        }

        foreach ($this->userRepository->countByRoles() as $users) {
            array_push($this->users_count_roles, $users['nbr']);
        }

        foreach ($this->ageCategoryRepository->findAll() as $age_category) {
            array_push($this->age_cat_labels, $age_category->getLabel());
        }

        foreach ($this->userRepository->countByAgeCategory() as $users) {
            array_push($this->users_count_age, $users['nbr']);
        }

        foreach ($this->departementRepository->findAll() as $dpt) {
            // TODO: A refaire
            array_push($this->dpt_num, $dpt->getNumber());
            try {
                array_push($this->users_count_dpt, $this->userRepository->countByDpt($dpt->getId())['nbr']);
            } catch (NonUniqueResultException $e) {
                array_push($this->users_count_dpt, 0);
            }
        }
    }
}
