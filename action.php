<?php
/**
 * action.php
 *
 * POST Action handler demo
 *
 * Expects POST request with 'action' and optionally 'data' parameters.
 * Returns application/json Response.
 *
 * Example response:
 * {
 *      "status": true, // true if successful
 *      "response": 126, // response message
 * }
 *
 * Expanding functionality:
 * - Supported actions need to be added to App/Enums/ActionsEnum.php
 * - After that corresponding new ActionStrategy implementing ActionStrategyInterface
 *   needs to be created and added to App/Functions/ActionStrategies/ActionStrategyFactory.php
 *
 *
 * @author Delaja Fedorco
 * @version 1.0
 * @license MIT
 */

require_once __DIR__ . '/autoload.php';

use Sperky\App\Functions\ActionHandler;
use Sperky\App\Functions\ActionStrategies\ActionStrategyFactory;

// Get action name and data from POST request
$action = $_POST['action'] ?? null;
$data = $_POST['data'] ?? null;

// Get handler instance
$actionHandler = new ActionHandler(new ActionStrategyFactory());

// Pass data to ActionHandler, this does the strategy determination for us and returns JsonResponse
$response = $actionHandler->handle($action, $data);

// Send response to client
$response->send();

/*
 * Alternatively this can also be done directly via factory if we know what ActionEnum to use:
 * ActionStrategyFactory::getStrategy(ActionsEnum::GET_WAREHOUSE_VALUE) // Get strategy
 *      ->execute($data) // Execute strategy
 *      ->send(); // Send JSON Response
 *
 * Or directly via strategy:
 * ( new GetWarehouseValueStrategy() ) // Get strategy
 *      ->execute($data) // Execute strategy
 *      ->send(); // Send JSON Response
 *
 * ( new GetWarehouseValueStrategy() ) // Get strategy
 *      ->execute($data) // Execute strategy
 *      ->response; // get response value, in this case its integer
 *
 * Or skip strategy and go directly to Product
 * Product::getWarehouseValue(); // int value
 *
 * We can also create JSON response via provided classes:
 * ( new JsonResponse( Product::getWarehouseValue()) )->send(); // Send JSON Response
 */

