<?php

require 'vendor/autoload.php';

use Symfony\Component\Console\Output\OutputInterface;
use Dotenv\Dotenv;
use Recranet\Api\RecranetApiClient;
use Recranet\Api\Exceptions\ApiException;

$app = new Silly\Application();

$dotenv = new Dotenv(__DIR__);
$dotenv->load();

// Get accommodations
$app->command('accommodations [modifiedDateFrom]', function (OutputInterface $output, $modifiedDateFrom = null) {
    $client = new RecranetApiClient();

    try {
        $result = $client->getAccommodations(compact('modifiedDateFrom'));
    } catch (ApiException $e) {
        return $output->writeln(sprintf('ApiException: %s', $e->getMessage()));
    }

    // Output result count
    $output->writeln(sprintf('%d accommodations found', count($result)));

    // Output result items
    foreach ($result as $item) {
        $output->writeln(sprintf('%d - %s (modified: %s)', $item->id, $item->title, $item->modified));
    }
});

// Get accommodation price components
$app->command('accommodation_price_components accommodation dateFrom dateTo [modifiedDateFrom]', function (OutputInterface $output, $accommodation, $dateFrom, $dateTo, $modifiedDateFrom = null) {
    $client = new RecranetApiClient();

    try {
        $result = $client->getAccommodationPriceComponents(array(
            'accommodation' => $accommodation,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'modifiedDateFrom' => $modifiedDateFrom
        ));
    } catch (ApiException $e) {
        return $output->writeln(sprintf('ApiException: %s', $e->getMessage()));
    }

    // Output result count
    $output->writeln(sprintf('%d accommodation price components found', count($result)));

    // Output result items
    foreach ($result as $item) {
        $output->writeln(sprintf('%d - %s (modified: %s)', $item->id, $item->description, $item->modified));
    }
});

// Get accommodations
$app->command('age_group_specifications [modifiedDateFrom]', function (OutputInterface $output, $modifiedDateFrom = null) {
    $client = new RecranetApiClient();

    try {
        $result = $client->getAgeGroupSpecifications(compact('modifiedDateFrom'));
    } catch (ApiException $e) {
        return $output->writeln(sprintf('ApiException: %s', $e->getMessage()));
    }

    // Output result count
    $output->writeln(sprintf('%d age group specifications found', count($result)));

    // Output result items
    foreach ($result as $item) {
        $output->writeln(sprintf('%d - %s (modified: %s)', $item->id, $item->description, $item->modified));
    }
});

// Get discount specifications
$app->command('discount_specifications [modifiedDateFrom]', function (OutputInterface $output, $modifiedDateFrom = null) {
    $client = new RecranetApiClient();

    try {
        $result = $client->getDiscountSpecifications(compact('modifiedDateFrom'));
    } catch (ApiException $e) {
        return $output->writeln(sprintf('ApiException: %s', $e->getMessage()));
    }

    // Output result count
    $output->writeln(sprintf('%d discount specifications found', count($result)));

    // Output result items
    foreach ($result as $item) {
        $output->writeln(sprintf('%d - %s (modified: %s)', $item->id, $item->description, $item->modified));
    }
});

// Get package specifications
$app->command('package_specifications [modifiedDateFrom]', function (OutputInterface $output, $modifiedDateFrom = null) {
    $client = new RecranetApiClient();

    try {
        $result = $client->getPackageSpecifications(compact('modifiedDateFrom'));
    } catch (ApiException $e) {
        return $output->writeln(sprintf('ApiException: %s', $e->getMessage()));
    }

    // Output result count
    $output->writeln(sprintf('%d package specifications found', count($result)));

    // Output result items
    foreach ($result as $item) {
        $output->writeln(sprintf('%d - %s (modified: %s)', $item->id, $item->title, $item->modified));
    }
});

// Get reservations
$app->command('reservations dateFrom dateTo [offset] [limit] [modifiedDateFrom]', function (OutputInterface $output, $dateFrom, $dateTo, $offset = null, $limit = null, $modifiedDateFrom = null) {
    $client = new RecranetApiClient();

    try {
        $result = $client->getReservations(array(
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'offset' => $offset,
            'limit' => $limit,
            'modifiedDateFrom' => $modifiedDateFrom,
        ));
    } catch (ApiException $e) {
        return $output->writeln(sprintf('ApiException: %s', $e->getMessage()));
    }

    // Output result count
    $output->writeln(sprintf('%d reservations found (max. 100 results)', count($result)));

    // Output result items
    foreach ($result as $item) {
        $output->writeln(sprintf('%d - %s (modified: %s)', $item->id, $item->name, $item->modified));
    }
});

// Get supplements
$app->command('supplements [modifiedDateFrom]', function (OutputInterface $output, $modifiedDateFrom = null) {
    $client = new RecranetApiClient();

    try {
        $result = $client->getSupplements(compact('modifiedDateFrom'));
    } catch (ApiException $e) {
        return $output->writeln(sprintf('ApiException: %s', $e->getMessage()));
    }

    // Output result count
    $output->writeln(sprintf('%d supplements found', count($result)));

    // Output result items
    foreach ($result as $item) {
        $output->writeln(sprintf('%d - %s (modified: %s)', $item->id, $item->description, $item->modified));
    }
});

$app->run();
