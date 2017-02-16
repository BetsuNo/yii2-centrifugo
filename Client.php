<?php namespace yii2\centrifugo;

use phpcent\Client as CentrifugoClient;
use phpcent\ITransport;
use yii\base\Model;

/**
 * Class Centrifugo
 * @package yii2\centrifugo
 * @property string $host
 * @property string $secret write-only
 * @property \phpcent\Client $client read-only
 * @property ITransport $transport
 * @mixin \phpcent\Client
 */
class Client extends Model
{
	public $host;
	public $transport;

	/** @var string */
	protected $_secret;

	/** @var \phpcent\Client */
	protected $_client;

	public function initClient()
	{
		$this->_client = new CentrifugoClient($this->host);
		$this->_client->setSecret($this->_secret);

		if (null === $this->transport) {
			return;
		}

		$transport = $this->createTransport($this->transport);

		if ($transport instanceof ITransport) {
			$this->_client->setTransport($transport);
		}
	}

	/**
	 * @param string $value
	 */
	public function setSecret($value)
	{
		$this->_secret = $value;
	}

	/**
	 * @return \phpcent\Client
	 */
	public function getClient()
	{
		if (null === $this->_client) {
			$this->initClient();
		}
		return $this->_client;
	}

	/**
	 * @param $config
	 * @return object|null
	 */
	protected static function createTransport($config)
	{
		if (is_array($config) && isset($config['class'])) {
			$className = $config['class'];
			unset($config['class']);
			$instance = new $className;
			foreach ($config as $key => $value) {
				if (property_exists($instance, $key)) {
					$instance->$key = $value;
				} else {
					$setter = 'set' . ucfirst($key);
					$instance->$setter($value);
				}
			}
			return $instance;
		}
		return null;
	}

	public function __call($name, $params)
	{
		$client = $this->getClient();
		if (method_exists($client, $name)) {
			return call_user_func_array([$client, $name], $params);
		}
		return parent::__call($name, $params);
	}
}