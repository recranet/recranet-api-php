<?php

require 'vendor/autoload.php';

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Dotenv\Dotenv;
use Recranet\Api\RecranetApiClient;
use Recranet\Api\Exceptions\ApiException;

$app = new Silly\Application();

$dotenv = new Dotenv(__DIR__);
$dotenv->load();

// Get accommodations
$app
    ->command('accommodations [--modifiedDateFrom=]', function (OutputInterface $output, $modifiedDateFrom = null) {
        // Create client
        $client = new RecranetApiClient(new ConsoleLogger($output));

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
    })
    ->descriptions('Get accommodations', array(
        '--modifiedDateFrom' => 'Date modified in ISO8601 format 2019-01-01T00:00:00Z'
    ))
;

// Get accommodation price components
$app
    ->command('accommodation_price_components accommodation dateFrom dateTo [--modifiedDateFrom=]', function (OutputInterface $output, $accommodation, $dateFrom, $dateTo, $modifiedDateFrom = null) {
        // Create client
        $client = new RecranetApiClient(new ConsoleLogger($output));

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
    })
    ->descriptions('Get accommodation price components', array(
        'accommodation' => 'Accommodation id',
        'dateFrom' => 'Date from in ISO8601 format 2019-01-01T00:00:00Z',
        'dateTo' => 'Date to in ISO8601 format 2019-01-01T00:00:00Z',
        '--modifiedDateFrom' => 'Date modified in ISO8601 format 2019-01-01T00:00:00Z'
    ))
;

// Get age group specifications
$app
    ->command('age_group_specifications [--modifiedDateFrom=]', function (OutputInterface $output, $modifiedDateFrom = null) {
        // Create client
        $client = new RecranetApiClient(new ConsoleLogger($output));

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
    })
    ->descriptions('Get age group specifications', array(
        '--modifiedDateFrom' => 'Date modified in ISO8601 format 2019-01-01T00:00:00Z'
    ))
;

// Get accommodation quotations
$app
    ->command('accommodation_quotations accommodation dateFrom dateTo', function (OutputInterface $output, $accommodation, $dateFrom, $dateTo) {
        // Create client
        $client = new RecranetApiClient(new ConsoleLogger($output));

        try {
            $result = $client->getAccommodationQuotations($accommodation, array(
                'dateFrom' => $dateFrom,
                'dateTo' => $dateTo
            ));
        } catch (ApiException $e) {
            return $output->writeln(sprintf('ApiException: %s', $e->getMessage()));
        }

        // Output result count
        $output->writeln(sprintf('%d quotations found', count($result)));

        // Output result items
        foreach ($result as $item) {
            $output->writeln(sprintf('Period %s - %s (orderLinesTotal: %s)', $item->dateFrom, $item->dateTo, $item->orderLinesTotal));
        }
    })
    ->descriptions('Get accommodation quotations', array(
        'accommodation' => 'Accommodation id',
        'dateFrom' => 'Date from in ISO8601 format 2019-01-01T00:00:00Z',
        'dateTo' => 'Date to in ISO8601 format 2019-01-01T00:00:00Z',
    ))
;

// Get discount specifications
$app
    ->command('discount_specifications [--modifiedDateFrom=]', function (OutputInterface $output, $modifiedDateFrom = null) {
        // Create client
        $client = new RecranetApiClient(new ConsoleLogger($output));

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
    })
    ->descriptions('Get discount specifications', array(
        '--modifiedDateFrom' => 'Date modified in ISO8601 format 2019-01-01T00:00:00Z'
    ))
;

// Get reservations
$app
    ->command('guests [offset] [limit] [--modifiedDateFrom=]', function (OutputInterface $output, $offset = null, $limit = null, $modifiedDateFrom = null) {
        // Create client
        $client = new RecranetApiClient(new ConsoleLogger($output));

        try {
            $result = $client->getGuests(array(
                'offset' => $offset,
                'limit' => $limit,
                'modifiedDateFrom' => $modifiedDateFrom,
            ));
        } catch (ApiException $e) {
            return $output->writeln(sprintf('ApiException: %s', $e->getMessage()));
        }

        // Output result count
        $output->writeln(sprintf('%d guests found (max. 100 results)', count($result)));

        // Output result items
        foreach ($result as $item) {
            $output->writeln(sprintf('%d - %s (modified: %s)', $item->id, $item->surname, $item->modified));
        }
    })
    ->descriptions('Get guests', array(
        'offset' => 'Offset integer',
        'limit' => 'Limit integer (max. 100)',
        '--modifiedDateFrom' => 'Date modified in ISO8601 format 2019-01-01T00:00:00Z'
    ))
;

// Get package specifications
$app
    ->command('package_specifications [--modifiedDateFrom=]', function (OutputInterface $output, $modifiedDateFrom = null) {
        // Create client
        $client = new RecranetApiClient(new ConsoleLogger($output));

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
    })
    ->descriptions('Get package specifications', array(
        '--modifiedDateFrom' => 'Date modified in ISO8601 format 2019-01-01T00:00:00Z'
    ))
;

// Get reservations
$app
    ->command('reservations dateFrom dateTo [offset] [limit] [--modifiedDateFrom=]', function (OutputInterface $output, $dateFrom, $dateTo, $offset = null, $limit = null, $modifiedDateFrom = null) {
        // Create client
        $client = new RecranetApiClient(new ConsoleLogger($output));

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
    })
    ->descriptions('Get reservations', array(
        'dateFrom' => 'Date from in ISO8601 format 2019-01-01T00:00:00Z',
        'dateTo' => 'Date to in ISO8601 format 2019-01-01T00:00:00Z',
        'offset' => 'Offset integer',
        'limit' => 'Limit integer (max. 100)',
        '--modifiedDateFrom' => 'Date modified in ISO8601 format 2019-01-01T00:00:00Z'
    ))
;

// Get supplements
$app
    ->command('supplements [--modifiedDateFrom=]', function (OutputInterface $output, $modifiedDateFrom = null) {
        // Create client
        $client = new RecranetApiClient(new ConsoleLogger($output));

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
    })
    ->descriptions('Get supplements', array(
        '--modifiedDateFrom' => 'Date modified in ISO8601 format 2019-01-01T00:00:00Z'
    ))
;

// Create reservation
$app
    ->command('reservation-create accommodation dateFrom dateTo', function(InputInterface $input, OutputInterface $output, $accommodation, $dateFrom, $dateTo) {
        // Set reservation request data
        $data = array(
            'accommodation' => array('id' => $accommodation),
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        );

        // Create client
        $client = new RecranetApiClient(new ConsoleLogger($output));

        try {
            $result = $client->createReservation(json_encode($data));
        } catch (ApiException $e) {
            return $output->writeln(sprintf('ApiException: %s', $e->getMessage()));
        }

        $output->writeln(sprintf('Reservation created with id %d and token %s', $result->id, $result->token));
    })
    ->descriptions('Create reservation for accommodation and period', array(
        'accommodation' => 'Accommodation id',
        'dateFrom' => 'Date from in ISO8601 format 2019-01-01T00:00:00Z',
        'dateTo' => 'Date to in ISO8601 format 2019-01-01T00:00:00Z',
    ))
;

// Update reservation
$app
    ->command('reservation-update id token accommodation', function(InputInterface $input, OutputInterface $output, $id, $token, $accommodation) {
        // Create client
        $client = new RecranetApiClient(new ConsoleLogger($output));

        // Set reservation request data
        $data = array(
            'ageGroupLines' => array(),
            'supplementOrderLines' => array()
        );

        $helper = new QuestionHelper();

        // Get age group specifications
        try {
            $ageGroupSpecifications = $client->getAgeGroupSpecifications(array('accommodation' => $accommodation));
        } catch (ApiException $e) {
            return $output->writeln(sprintf('ApiException: %s', $e->getMessage()));
        }

        foreach ($ageGroupSpecifications as $ageGroupSpecification) {
            $question = new Question('Quantity for ' . $ageGroupSpecification->description . ': ', '');
            $quantity = $helper->ask($input, $output, $question);

            if ($quantity > 0) {
                $data['ageGroupLines'][] = array(
                    'quantity' => $quantity,
                    'ageGroupSpecification' => array('id' => $ageGroupSpecification->id)
                );
            }
        }

        // Get supplements
        try {
            $supplements = $client->getSupplements(array(
                'accommodation' => $accommodation,
                'required' => 'false',
                'normal' => 'true'
            ));
        } catch (ApiException $e) {
            return $output->writeln(sprintf('ApiException: %s', $e->getMessage()));
        }

        foreach ($supplements as $supplement) {
            $question = new Question('Quantity for ' . $supplement->description . ': ', '');
            $quantity = $helper->ask($input, $output, $question);

            if ($quantity > 0) {
                $data['supplementOrderLines'][] = array(
                    'quantity' => $quantity,
                    'supplement' => array('id' => $supplement->id)
                );
            }
        }

        try {
            $result = $client->updateReservation($id, $token, json_encode($data));
        } catch (ApiException $e) {
            return $output->writeln(sprintf('ApiException: %s', $e->getMessage()));
        }

        $output->writeln(sprintf('Reservation updated with id %d and token %s', $result->id, $result->token));
    })
    ->descriptions('Update reservation with age group lines and supplement order lines', array(
        'id' => 'Reservation id',
        'token' => 'Reservation token',
        'accommodation' => 'Accommodation id',
    ))
;

// Place reservation
$app
    ->command('reservation-place id token', function(InputInterface $input, OutputInterface $output, $id, $token) {
        // Set reservation request data
        $data = array(
            'guest' => array()
        );

        // Guest attributes
        $attributes = array(
            'firstName',
            'surname',
            'email',
            'phoneNumber',
            'address',
            'addressNo',
            'postalCode',
            'locality',
            'country',
            'locale'
        );

        $helper = new QuestionHelper();

        // Set guest data
        foreach ($attributes as $attribute) {
            $question = new Question('Reservation ' . $attribute . ': ', '');
            $data['guest'][$attribute] = $helper->ask($input, $output, $question);
        }

        // Set source
        $question = new ChoiceQuestion(
            'Reservation source? ',
            array('office', 'owner', 'reception', 'telephone', 'tour-operator', 'web', 'email', 'booking', 'holidaymedia'),
            0
        );
        $data['source'] = $helper->ask($input, $output, $question);

        // Confirm reservation
        $question = new ConfirmationQuestion('Reservation confirmed? y/n ', false);

        if ($helper->ask($input, $output, $question)) {
            $data['confirmed'] = true;
        }

        // Create client
        $client = new RecranetApiClient(new ConsoleLogger($output));

        try {
            $result = $client->placeReservation($id, $token, json_encode($data));
        } catch (ApiException $e) {
            return $output->writeln(sprintf('ApiException: %s', $e->getMessage()));
        }

        $output->writeln('Reservation placed');
    })
    ->descriptions('Place reservation', array(
        'id' => 'Reservation id',
        'token' => 'Reservation token',
    ))
;

$app->run();
