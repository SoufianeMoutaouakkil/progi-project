<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Service\VehicleService;
use App\Entity\Vehicle;

class VehicleController extends AbstractController
{
    #[Route('/api/vehicle/cost', name: 'app_vehicle')]
    public function cost(VehicleService $vehicleService, Request $request): JsonResponse
    {
        $type = strtolower($request->query->get('type') ?? '');
        $basePrice = $request->query->get('base_price');
        $error = null;
        if (!$type || !$basePrice) {
            $error = 'Base price and type are required';
        } elseif (!in_array($type, [Vehicle::TYPE_COMMON, Vehicle::TYPE_LUXURY], true)) {
            $error = 'Invalid vehicle type';
        } elseif (!is_numeric($basePrice) || $basePrice < 0) {
            $error = 'Invalid base price';
        }

        if ($error) {
            return new JsonResponse(['error' => $error], 400);
        }

        return new JsonResponse($vehicleService->getVehicleWithCost((int) $basePrice, $type));
    }
}
