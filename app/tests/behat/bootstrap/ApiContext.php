<?php

use Behat\Behat\Context\ClosuredContextInterface,
	Behat\Behat\Context\TranslatedContextInterface,
	Behat\Behat\Context\BehatContext,
	Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
	Behat\Gherkin\Node\TableNode;

use Guzzle\Service\Client,
	Guzzle\Http\Exception\BadResponseException;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

require_once __DIR__.'/../../../../vendor/phpunit/phpunit/PHPUnit/Autoload.php';
require_once __DIR__.'/../../../../vendor/phpunit/phpunit/PHPUnit/Framework/Assert/Functions.php';

class ApiContext extends BehatContext
{
	/**
	 * The Guzzle HTTP Client.
	 */
	protected $client;

	/**
	 * The current resource
	 */
	protected $resource;

	/**
	 * The request payload
	 */
	protected $requestPayload;

	/**
	 * The Guzzle HTTP Response.
	 */
	protected $response;

	/**
	 * The decoded response object.
	 */
	protected $responsePayload;

	/**
	 * The current scope within the response payload
	 * which conditions are asserted against.
	 */
	protected $scope;

	/**
	 * Initializes context.
	 * Every scenario gets it's own context object.
	 *
	 * @param array $parameters context parameters (set them up through behat.yml)
	 */
	public function __construct(array $parameters)
	{
		$config = isset($parameters['guzzle']) && is_array($parameters['guzzle']) ? $parameters['guzzle'] : [];

		$this->client = new Client($parameters['base_url'], $config);
		$this->client->setDefaultHeaders([
			'Accept' => 'application/json',
			'Accept-Charset' => 'utf-8',
			'Authorization' => "Basic {$parameters['api_token']}",
		]);
	}

	/**
	 * @Given /^I have the payload:$/
	 */
	public function iHaveThePayload(PyStringNode $requestPayload)
	{
		$this->requestPayload = $requestPayload;
	}

	/**
	 * @When /^I request "(GET|PUT|POST|DELETE) ([^"]*)"$/
	 */
	public function iRequest($httpMethod, $resource)
	{
		$this->resource = $resource;

		$method = strtolower($httpMethod);

		try {
			switch ($httpMethod) {
				case 'PUT':
				case 'POST':
					$this->response = $this
						->client
						->$method($resource, array('Content-Type' => 'application/json'), $this->requestPayload)
						->send();
					break;

				default:
					$this->response = $this
						->client
						->$method($resource)
						->send();
			}
		} catch (BadResponseException $e) {

			$response = $e->getResponse();

			// Sometimes the request will fail, at which point we have
			// no response at all. Let Guzzle give an error here, it's
			// pretty self-explanatory.
			if ($response === null) {
				throw $e;
			}

			$this->response = $e->getResponse();
		}
	}

	/**
	 * @Then /^I get a "([^"]*)" response$/
	 */
	public function iGetAResponse($statusCode)
	{
		$response = $this->getResponse();
		$contentType = $response->getHeader('Content-Type');

		if ($contentType == 'application/json') {
			$bodyOutput = $response->getBody();
		} else {
			$bodyOutput = 'Output is '.$contentType.', which is not JSON and is therefore scary. Run the request manually.';
		}
		assertSame($statusCode, $this->getResponse()->getStatusCode(), $bodyOutput);
	}

	/**
	 * @Given /^the "([^"]*)" property equals "([^"]*)"$/
	 */
	public function thePropertyEquals($property, $expectedValue)
	{
		$payload = $this->getScopePayload();
		$actualValue = $this->arrayGet($payload, $property);

		assertEquals(
			$actualValue,
			$expectedValue,
			"Asserting the [$property] property in current scope equals [$expectedValue]: ".json_encode($payload)
		);
	}

	/**
	 * @Given /^the "([^"]*)" property exists$/
	 */
	public function thePropertyExists($property)
	{
		$payload = $this->getScopePayload();

		$message = sprintf(
			'Asserting the [%s] property exists in the scope [%s]: %s',
			$property,
			$this->scope,
			json_encode($payload)
		);

		if (is_object($payload)) {
			assertTrue(array_key_exists($property, get_object_vars($payload)), $message);

		} else {
			assertTrue(array_key_exists($property, $payload), $message);
		}
	}

	/**
	 * @Given /^the "([^"]*)" value exists$/
	 */
	public function theValueExists($value)
	{
		$payload = $this->getScopePayload();

		$message = sprintf(
			'Asserting the [%s] value exists in the scope [%s]: %s',
			$value,
			$this->scope,
			json_encode($payload)
		);

		if (is_object($payload)) {
			assertTrue(in_array($value, get_object_vars($payload)), $message);

		} else {
			assertTrue(in_array($value, $payload), $message);
		}
	}

	/**
	 * @Given /^the "([^"]*)" property must not be present$/
	 */
	public function thePropertyMustNotBePresent($property)
	{
		$payload = $this->getScopePayload();

		assertFalse(
			array_key_exists($property, $payload),
			"Asserting the [$property] property is NOT present in current scope [{$this->scope}]: ".json_encode($payload)
		);
	}

	/**
	 * @Given /^the "([^"]*)" property is an array$/
	 */
	public function thePropertyIsAnArray($property)
	{
		$payload = $this->getScopePayload();

		$actualValue = $this->arrayGet($payload, $property);


		assertTrue(
			is_array($actualValue),
			"Asserting the [$property] property in current scope [{$this->scope}] is an array: ".json_encode($payload)
		);
	}

	/**
	 * @Given /^the "([^"]*)" property is an object$/
	 */
	public function thePropertyIsAnObject($property)
	{
		$payload = $this->getScopePayload();

		$actualValue = $this->arrayGet($payload, $property);

		assertTrue(
			is_object($actualValue),
			"Asserting the [$property] property in current scope [{$this->scope}] is an object: ".json_encode($payload)
		);
	}

	/**
	 * @Given /^the "([^"]*)" property is an empty array$/
	 */
	public function thePropertyIsAnEmptyArray($property)
	{
		$payload = $this->getScopePayload();
		$scopePayload = $this->arrayGet($payload, $property);

		assertTrue(
			is_array($scopePayload) and $scopePayload === [],
			"Asserting the [$property] property in current scope [{$this->scope}] is an empty array: ".json_encode($payload)
		);
	}

	/**
	 * @Given /^the "([^"]*)" property contains (\d+) items$/
	 */
	public function thePropertyContainsItems($property, $count)
	{
		$payload = $this->getScopePayload();

		assertCount(
			$count,
			$this->arrayGet($payload, $property),
			"Asserting the [$property] property contains [$count] items: ".json_encode($payload)
		);
	}

	/**
	 * @Given /^the "([^"]*)" property is an integer$/
	 */
	public function thePropertyIsAnInteger($property)
	{
		$payload = $this->getScopePayload();

		isType(
			'int',
			$this->arrayGet($payload, $property),
			"Asserting the [$property] property in current scope [{$this->scope}] is an integer: ".json_encode($payload)
		);
	}

	/**
	 * @Given /^the "([^"]*)" property is a string$/
	 */
	public function thePropertyIsAString($property)
	{
		$payload = $this->getScopePayload();

		isType(
			'string',
			$this->arrayGet($payload, $property),
			"Asserting the [$property] property in current scope [{$this->scope}] is a string: ".json_encode($payload)
		);
	}

	/**
	 * @Given /^the "([^"]*)" property is a string equalling "([^"]*)"$/
	 */
	public function thePropertyIsAStringEqualling($property, $expectedValue)
	{
		$payload = $this->getScopePayload();

		$this->thePropertyIsAString($property);

		$actualValue = $this->arrayGet($payload, $property);

		assertSame(
			$actualValue,
			$expectedValue,
			"Asserting the [$property] property in current scope [{$this->scope}] is a string equalling [$expectedValue]."
		);
	}

	/**
	 * @Given /^the "([^"]*)" property is a boolean$/
	 */
	public function thePropertyIsABoolean($property)
	{
		$payload = $this->getScopePayload();

		assertTrue(
			gettype($this->arrayGet($payload, $property)) == 'boolean',
			"Asserting the [$property] property in current scope [{$this->scope}] is a boolean."
		);
	}

	/**
	 * @Given /^the "([^"]*)" property is a boolean equalling "([^"]*)"$/
	 */
	public function thePropertyIsABooleanEqualling($property, $expectedValue)
	{
		$payload = $this->getScopePayload();
		$actualValue = $this->arrayGet($payload, $property);

		if (! in_array($expectedValue, ['true', 'false'])) {
			throw new \InvalidArgumentException("Testing for booleans must be represented by [true] or [false].");
		}

		$this->thePropertyIsABoolean($property);

		assertSame(
			$actualValue,
			$expectedValue == 'true',
			"Asserting the [$property] property in current scope [{$this->scope}] is a boolean equalling [$expectedValue]."
		);
	}

	/**
	 * @Given /^the "([^"]*)" property is a integer equalling "([^"]*)"$/
	 */
	public function thePropertyIsAIntegerEqualling($property, $expectedValue)
	{
		$payload = $this->getScopePayload();
		$actualValue = $this->arrayGet($payload, $property);

		$this->thePropertyIsAnInteger($property);

		assertSame(
			$actualValue,
			(int) $expectedValue,
			"Asserting the [$property] property in current scope [{$this->scope}] is an integer equalling [$expectedValue]."
		);
	}

	/**
	 * @Given /^the "([^"]*)" property is either:$/
	 */
	public function thePropertyIsEither($property, PyStringNode $options)
	{
		$payload = $this->getScopePayload();
		$actualValue = $this->arrayGet($payload, $property);

		$valid = explode("\n", (string) $options);

		assertTrue(
			in_array($actualValue, $valid),
			sprintf(
				"Asserting the [%s] property in current scope [{$this->scope}] is in array of valid options [%s].",
				$property,
				implode(', ', $valid)
			)
		);
	}

	/**
	 * @Given /^scope into the first "([^"]*)" property$/
	 */
	public function scopeIntoTheFirstProperty($scope)
	{
		$this->scope = "{$scope}.0";
	}

	/**
	 * @Given /^scope into the "([^"]*)" property$/
	 */
	public function scopeIntoTheProperty($scope)
	{
		$this->scope = $scope;
	}

	/**
	 * @Given /^the properties exist:$/
	 */
	public function thePropertiesExist(PyStringNode $propertiesString)
	{
		foreach (explode("\n", (string) $propertiesString) as $property) {
			$this->thePropertyExists($property);
		}
	}

	/**
	 * @Given /^the property "([^"]*)" contains:$/
	 */
	public function thePropertyContains($scope, PyStringNode $valuesString)
	{
		$this->scope = $scope;

		foreach (explode("\n", (string) $valuesString) as $value) {
			$this->theValueExists($value);
		}
	}

	/**
	 * @Given /^reset scope$/
	 */
	public function resetScope()
	{
		$this->scope = null;
	}

	/**
	 * @Given /^I reset response$/
	 */
	public function iResetResponse()
	{
		if (! $this->response) {
			throw new Exception("You haven't made any requests yet, so nothing to reset.");
		}

		$this->response = null;
		$this->responsePayload = null;
	}

	/**
	 * @Transform /^(\d+)$/
	 */
	public function castStringToNumber($string)
	{
		return intval($string);
	}

	/**
	 * Checks the response exists and returns it.
	 *
	 * @return  Guzzle\Http\Message\Response
	 */
	protected function getResponse()
	{
		if (! $this->response) {
			throw new Exception("You must first make a request to check a response.");
		}

		return $this->response;
	}

	/**
	 * Return the response payload from the current response.
	 *
	 * @return  mixed
	 */
	protected function getResponsePayload()
	{
		if (! $this->responsePayload) {
			$json = json_decode($this->getResponse()->getBody(true));

			if (json_last_error() !== JSON_ERROR_NONE) {
				$message = 'Failed to decode JSON body ';

				switch (json_last_error()) {
					case JSON_ERROR_DEPTH:
						$message .= '(Maximum stack depth exceeded).';
						break;
					case JSON_ERROR_STATE_MISMATCH:
						$message .= '(Underflow or the modes mismatch).';
						break;
					case JSON_ERROR_CTRL_CHAR:
						$message .= '(Unexpected control character found).';
						break;
					case JSON_ERROR_SYNTAX:
						$message .= '(Syntax error, malformed JSON).';
						break;
					case JSON_ERROR_UTF8:
						$message .= '(Malformed UTF-8 characters, possibly incorrectly encoded).';
						break;
					default:
						$message .= '(Unknown error).';
						break;
				}

				throw new Exception($message);
			}

			$this->responsePayload = $json;
		}

		return $this->responsePayload;
	}

	/**
	 * Returns the payload from the current scope within
	 * the response.
	 *
	 * @return mixed
	 */
	protected function getScopePayload()
	{
		$payload = $this->getResponsePayload();

		if (! $this->scope) {
			return $payload;
		}

		return $this->arrayGet($payload, $this->scope);
	}

	/**
	 * Get an item from an array using "dot" notation.
	 *
	 * @copyright   Taylor Otwell
	 * @link        http://laravel.com/docs/helpers
	 * @param       array   $array
	 * @param       string  $key
	 * @param       mixed   $default
	 * @return      mixed
	 */
	protected function arrayGet($array, $key)
	{
		if (is_null($key)) {
			return $array;
		}

		// if (isset($array[$key])) {
		//     return $array[$key];
		// }

		foreach (explode('.', $key) as $segment) {

			if (is_object($array)) {
				if (! isset($array->{$segment})) {
					return;
				}
				$array = $array->{$segment};

			} elseif (is_array($array)) {
				if (! array_key_exists($segment, $array)) {
					return;
				}
				$array = $array[$segment];
			}
		}

		return $array;
	}

}
