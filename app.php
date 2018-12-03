<?php

require 'vendor/autoload.php';

use Symfony\Component\Console\Output\OutputInterface;
use Dotenv\Dotenv;
use Recranet\Api\RecranetApiClient;
use Recranet\Api\Exceptions\ApiException;

$app = new Silly\Application();

$dotenv = new Dotenv(__DIR__);
$dotenv->load();

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

$app->run();
