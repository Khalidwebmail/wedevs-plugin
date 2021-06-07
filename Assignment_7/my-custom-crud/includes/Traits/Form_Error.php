<?php
namespace My\Crud\Traits;

/**
 * Error handler trait
 */

trait Form_Error {

	/**
	 * Holds the errors
	 *
	 * @var array
	 */
	public $errors = [];

	/**
	 * has_error
	 *
	 * Check if the form has error
	 *
	 * @param  string  $key
	 *
	 * @return boolean
	 */
	public function has_error( $key ) {
		return isset( $this->errors[ $key ] ) ? true : false;
	}

	/**
	 * get_error
	 *
	 * Get the error by key
	 *
	 * @param  key $key
	 *
	 * @return string | false
	 */
	public function get_error( $key ) {
		if( isset( $this->errors[ $key ] ) ) {
			return $this->errors[ $key ];
		}
		return false;
	}
}