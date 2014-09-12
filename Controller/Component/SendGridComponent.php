<?php
/**
* Licensed under The MIT License
* Redistributions of files must retain the above copyright notice.
*
* @license MIT License (http://www.opensource.org/licenses/mit-license.php)
*/
App::uses('Component', 'Controller');
App::uses('HttpSocket', 'Network/Http');
/**
 * SendGrid Component
 *
 * @author Rafael F Queiroz <rafaelfqf@gmail.com>
 */
class SendGridComponent extends Component {

	/** 
	 * Url
	 *
	 * @var string
	 */
	const URL = 'https://api.sendgrid.com';

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array();

	/**
	 * Settings
	 *
	 * @var array
	 */
	public $settings = array(
		'api_user' => null,
		'api_key' => null
	);

	/**
	 * HttpSocket
	 *
	 * @var HttpSocket
	 */
	private $http = null;

	/**
	 * Constructor
	 *
	 * @param ComponentCollection $collection 
	 * @param array $settings
	 * @return SendGridComponent
	 */
	public function __construct(ComponentCollection $collection, $settings) {
		
		$this->http = new HttpSocket();

		$this->settings['api_user'] = Configure::read('Sendgrid.username');
		$this->settings['api_key'] = Configure::read('Sendgrid.password');
	}

	/**
	 * Method of API
	 *
	 * @return HttpSocketResponse
	 */
	public function api() {
		
		$args = func_get_args();
		$url  = implode('/', array(self::URL, 'api', array_shift($args))) . ".json";

		do {
			$data = array_merge($this->settings, array_shift($args));
		} while ($args);
		
		return $this->http->post($url, $data);
	}

}