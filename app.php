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
$app->command('accommodations', function (OutputInterface $output) {
    $client = new RecranetApiClient();

    try {
        $result = $client->getAccommodations(array());
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
$app->command('accommodation_price_components accommodation dateFrom dateTo', function (OutputInterface $output, $accommodation, $dateFrom, $dateTo) {
    $client = new RecranetApiClient();

    try {
        $result = $client->getAccommodationPriceComponents(array(
            'accommodation' => $accommodation,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo
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

// Get discount specifications
$app->command('discount_specifications', function (OutputInterface $output) {
    $client = new RecranetApiClient();

    try {
        $result = $client->getDiscountSpecifications(array());
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
$app->command('package_specifications', function (OutputInterface $output) {
    $client = new RecranetApiClient();

    try {
        $result = $client->getPackageSpecifications(array());
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

// Get supplements
$app->command('supplements', function (OutputInterface $output) {
    $client = new RecranetApiClient();

    try {
        $result = $client->getSupplements(array());
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
