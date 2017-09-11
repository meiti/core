<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;

require __DIR__ . '/../../../../lib/composer/autoload.php';

/**
 * Capabilities context.
 */
class CapabilitiesContext implements Context, SnippetAcceptingContext {

	use BasicStructure;
	use AppConfiguration;

	/**
	 * @Then /^fields of capabilities match with$/
	 * @param \Behat\Gherkin\Node\TableNode|null $formData
	 */
	public function checkCapabilitiesResponse(\Behat\Gherkin\Node\TableNode $formData) {
		$capabilitiesXML = $this->getCapabilitiesXml();

		foreach ($formData->getHash() as $row) {
			PHPUnit_Framework_Assert::assertEquals(
				$row['value'] === "EMPTY" ? '' : $row['value'],
				$this->getParameterValueFromXml(
					$capabilitiesXML,
					$row['capability'],
					$row['path_to_element']
				),
				"Failed field " . $row['capability'] . " " . $row['path_to_element']
			);

		}
	}

	protected function setupAppConfigs() {
		// Remember the current capabilities
		$this->getCapabilitiesCheckResponse();
		$this->savedCapabilitiesXml = $this->getCapabilitiesXml();
		// Set the required starting values for testing
		$this->modifyServerConfig('core', 'shareapi_enabled', 'yes');
		$this->modifyServerConfig('core', 'shareapi_allow_links', 'yes');
		$this->modifyServerConfig('core', 'shareapi_allow_public_upload', 'yes');
		$this->modifyServerConfig('core', 'shareapi_allow_resharing', 'yes');
		$this->modifyServerConfig('files_sharing', 'outgoing_server2server_share_enabled', 'yes');
		$this->modifyServerConfig('files_sharing', 'incoming_server2server_share_enabled', 'yes');
		$this->modifyServerConfig('core', 'shareapi_enforce_links_password', 'no');
		$this->modifyServerConfig('core', 'shareapi_allow_public_notification', 'no');
		$this->modifyServerConfig('core', 'shareapi_default_expire_date', 'no');
		$this->modifyServerConfig('core', 'shareapi_enforce_expire_date', 'no');
		$this->modifyServerConfig('core', 'shareapi_allow_group_sharing', 'yes');
	}

	protected function restoreAppConfigs() {
		// Restore the previous capabilities settings
		$this->resetCapability(
			'files_sharing',
			'api_enabled',
			'core',
			'shareapi_enabled'
		);
		$this->resetCapability(
			'files_sharing',
			'public@@@enabled',
			'core',
			'shareapi_allow_links'
		);
		$this->resetCapability(
			'files_sharing',
			'public@@@upload',
			'core',
			'shareapi_allow_public_upload'
		);
		$this->resetCapability(
			'files_sharing',
			'resharing',
			'core',
			'shareapi_allow_resharing'
		);
		$this->resetCapability(
			'federation',
			'outgoing',
			'files_sharing',
			'outgoing_server2server_share_enabled'
		);
		$this->resetCapability(
			'federation',
			'incoming',
			'files_sharing',
			'incoming_server2server_share_enabled'
		);
		$this->resetCapability(
			'files_sharing',
			'public@@@password@@@enforced',
			'core',
			'shareapi_enforce_links_password'
		);
		$this->resetCapability(
			'files_sharing',
			'public@@@send_mail',
			'core',
			'shareapi_allow_public_notification'
		);
		$this->resetCapability(
			'files_sharing',
			'public@@@expire_date@@@enabled',
			'core',
			'shareapi_default_expire_date'
		);
		$this->resetCapability(
			'files_sharing',
			'public@@@expire_date@@@enforced',
			'core',
			'shareapi_enforce_expire_date'
		);
		$this->resetCapability(
			'files_sharing',
			'group_sharing',
			'core',
			'shareapi_allow_group_sharing'
		);
	}
}
