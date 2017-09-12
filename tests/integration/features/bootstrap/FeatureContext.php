<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;

require __DIR__ . '/../../../../lib/composer/autoload.php';
require_once 'bootstrap.php';


/**
 * Features context.
 */
class FeatureContext implements Context, SnippetAcceptingContext {
	use BasicStructure;

	protected function resetAppConfigs() {
		// TODO: know what needs to be enabled here
	}
}
