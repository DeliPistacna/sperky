<?php

namespace Sperky\App\Enums;

/*
 * When expanding this don't forget to add both enum and strategy for new actions
 */

enum ActionsEnum: string
{
	case DO_NOTHING = 'doNothing';
	case GET_WAREHOUSE_VALUE = 'getWarehouseValue';
}
