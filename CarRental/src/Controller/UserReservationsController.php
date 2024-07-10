<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class UserReservationsController extends AbstractController
{
    /**
     * @throws \Exception
     */
    public function __invoke(User $data, Request $request)
    {
        $connectedUser = $this->getUser();
        if ($connectedUser->getId() !== $data->getId()) {
            throw new UnauthorizedHttpException('', 'UNAUTHORIZED');
        }


        return $data->getReservations();
    }
}
