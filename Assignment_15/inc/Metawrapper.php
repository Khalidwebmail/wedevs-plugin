<?php

namespace WdStudentInfo;

//Prevent Direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Metadata API wrapper helper trait
 */
trait Metawrapper {
    /**
     * Adds meta data field value to a studentmeta table.
     *
     * @param int    $student_id    student ID.
     * @param string $meta_key   Metadata name.
     * @param mixed  $meta_value Metadata value.
     * @param bool   $unique     Optional, default is false. Whether the same key should not be added.
     * 
     * @return int|false Meta ID on success, false on failure.
     */
    public function add_student_meta( $student_id, $meta_key, $meta_value, $unique = false ) {
        return add_metadata( 'student', $student_id, $meta_key, $meta_value, $unique );
    }

    /**
     * Removes metadata matching criteria from a student.
     *
     * You can match based on the key, or key and value. Removing student on key and
     * value, will keep from removing duplicate metadata with the same key. It also
     * allows removing all metadata matching key, if needed.
     *
     * @param int    $student_id    Student ID
     * @param string $meta_key   Metadata name.
     * @param mixed  $meta_value Optional. Metadata value.
     * 
     * @return bool True on success, false on failure.
     */
    function delete_student_meta( $student_id, $meta_key, $meta_value = '' ) {
        return delete_metadata( 'student', $student_id, $meta_key, $meta_value );
    }

    /**
     * Retrieve meta field for a student.
     *
     * @param int    $student_id Student ID.
     * @param string $key     Optional. The meta key to retrieve. By default, returns data for all keys.
     * @param bool   $single  Whether to return a single value.
     * 
     * @return mixed Will be an array if $single is false. Will be value of meta data field if $single is true.
     */
    function get_student_meta( $student_id, $key = '', $single = false ) {
        return get_metadata( 'student', $student_id, $key, $single );
    }

    /**
     * Update student meta field based on student ID.
     *
     * Use the $prev_value parameter to differentiate between meta fields with the
     * same key and student ID.
     *
     * If the meta field for the student does not exist, it will be added.
     *
     * @param int    $student_id    Student ID.
     * @param string $meta_key      Metadata key.
     * @param mixed  $meta_value    Metadata value.
     * @param mixed  $prev_value    Optional. Previous value to check before removing.
     * 
     * @return int|bool Meta ID     if the key didn't exist, true on successful update, false on failure.
     */
    function update_student_meta( $student_id, $meta_key, $meta_value, $prev_value = '' ) {
        return update_metadata('student', $student_id, $meta_key, $meta_value, $prev_value );
    }
}
