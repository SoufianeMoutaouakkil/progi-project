# Progi-Project

## Table of Contents

-   [Quick Start](#quick-start)
    -   [API](#api)
    -   [Frontend](#frontend)
    -   [Browser](#browser)
-   [Introduction](#introduction)
    -   [purpose](#purpose)
-   [Structure](#structure)
    -   [Api](#api-1)
        -   [Dependencies](#dependencies)
        -   [Endpoints](#endpoints)
        -   [Services](#services)
        -   [Entities](#entities)
        -   [Config](#config)
    -   [Frontend](#frontend-1)
        -   [Dependencies](#dependencies-1)
        -   [Views](#views)

## Quick Start

### API

1.  Go to the `api` directory
2.  Run `composer install`
3.  Run `symfony serve -d`
4.  The API is now running on `http://localhost:8000`

### Frontend

1.  Go to the `frontend` directory
2.  Run `npm install`
3.  Run `npm run dev`
4.  The frontend is now running on `http://localhost:3000`

### Browser

1.  Go to `http://localhost:3000`
2.  You get the home page of the application. click on the `Vehicle cost simulator Service` card.
3.  You get the form to fill in the base price and the type of vehicle or you can click the calculate button, since the form is already filled with default values.
4.  Check the result of the calculation below the form.

## Introduction

### purpose

This project is created for technical test interview at Progi.
It is a simple web application that allows users to get the total price of a vehicle based on the base price and the type of vehicle + Fees details.

## Structure

### Api

#### Dependencies

-   Symfony 5.4 (PHP 8.0) skeleton project
-   symfony/routing
-   dev dependencies:
    -   symfony/maker-bundle
    -   symfony/phpunit-bridge
    -   phpunit/phpunit

#### Endpoints

-   `GET /api/vehicle/cost`: Get the total price and fees details of a vehicle based on the base price and the type of vehicle.

#### Services

-   `VehicleService`:

    -   `__construct`: Inject the `ConfigLoaderService` service.
    -   `getVehicleWithCosts`: return the total price and fees details of a vehicle based on the base price and the type of vehicle. it uses a list of `strategies` to apply the fees on the `Vehicle` entity.

-   `ConfigLoaderService`:

    -   `__construct`: Inject the `feesConfig` configuration.
    -   `getFeeConfig`: Load the configuration for a specific fee.

-   `AbstractFeeStrategy`:
    -   `__construct`: takes `$feeConfig` as a parameter for a specific fee.
    -   `apply`: `abstract` method that takes the `Vehicle` entity as a parameter and apply the fee on it by setting the concerned property.
    -   `validateFeeConfig`: `abstract` method that takes the `feeConfig` as a parameter and validate it. if the configuration is not valid, it throws an exception.
-   `FeeStrategies`:
    -   a list of strategies that apply the fees on the `Vehicle` entity.
    -   extends the `AbstractFeeStrategy` class.
    -   they are using the `feeConfig` configuration to apply the fees.

#### Entities

-   `Vehicle`:
    -   it represents a vehicle with a set of properties concerning:
        -   `basePrice`: the base price of the vehicle.
        -   `vehicleType`: the type of the vehicle.
        -   `basicBuyerFee`: the basic buyer fee.
        -   `sellerSpecialFee`: the seller special fee.
        -   `associationFee`: the association fee.
        -   `storageFee`: the storage fee.
    -   apart from the `getters` and `setters`, it has a `getTotalPrice` and `getTotalFees` methods.
    -   it implements the `JsonSerializable` interface to serialize the entity to JSON.
    -   it has a `static` method `isValidVehicleType` that checks if the vehicle type is valid.

#### Config

-   `feesConfig`:
    -   a list of fees configuration.
    -   each fee is the name of the fee and its configuration.
    -   each fee could be disabled by setting the `enabled` property to `false`.

### Frontend

#### Dependencies

-   vue 3: as demanded in the technical test.
-   axios: for making HTTP requests.
-   vue-router: for routing between Home page and Vehicle cost simulator page.
-   vuetify: for the UI components.
-   test dependencies:
    -   @vue/test-utils
    -   jsdom
    -   resize-observer-polyfill (for vuetify form submission)
    -   vitest
-   mocking dependencies:
    -   msw (mock api responses)
-   build dependencies:
    -   vite
    -   @vue/compiler-sfc

#### Views

-   `Home`:

    -   the home page of the application.
    -   it contains a card that links to the `CalculateVehicleCostView` View.

-   `CalculateVehicleCostView`:
    -   it contains a back button to go back to the home page.
    -   it contains the form to fill in the base price and the type of vehicle.
    -   it contains a button to calculate the total price and fees details of the vehicle.
    -   it displays the result of the calculation below the form.

#### Environment variables

-   `VITE_API_URL`: the URL of the API. example: `http://localhost:8000/api`
-   `VITE_MOCK_MODE`: the status of the mock mode. example: `true` or `false`. it is used to mock the API responses but only in the `development` environment.
