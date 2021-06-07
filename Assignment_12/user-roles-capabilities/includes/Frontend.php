<?php


namespace User\Role;

use User\Role\Frontend\User_Registration;

/**
 * Class Frontend
 * @package User\Role
 */
class Frontend {
	/**
	 * Frontend constructor.
	 */
	public function __construct() {
		new User_Registration();
	}
}