<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Service\VehicleService;
use App\Entity\Vehicle;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

class VehicleController extends AbstractController
{
    #[Route('/api/vehicle/cost', name: 'app_vehicle')]
    public function cost(VehicleService $vehicleService, Request $request): JsonResponse
    {
        $type = strtolower($request->query->get('vehicle_type') ?? '');
        $basePrice = $request->query->get('base_price');
        $error = null;
        if (!$type || !$basePrice) {
            $error = 'Base price and type are required';
        } elseif (!Vehicle::isValidVehicleType($type)) {
            $error = 'Invalid vehicle type';
        } elseif (!is_numeric($basePrice) || $basePrice < 0) {
            $error = 'Invalid base price';
        }

        if ($error) {
            throw new HttpException(400, $error);
        }
        return new JsonResponse($vehicleService->getVehicleWithCosts( $basePrice, $type));
    }
}
