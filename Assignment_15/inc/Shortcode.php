<?php

namespace WdStudentInfo;

use WdStudentInfo\Metawrapper;

//Prevent Direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Shortcode class
 */
class Shortcode {
    use Metawrapper;
    /**
     * Class constructor
     */
    public function __construct() {
        add_shortcode( 'student-registration', [ $this, 'display_student_registration_form' ] );

        add_shortcode( 'display-student-info', [ $this, 'display_student_info' ] );
    }

    /**
     * Display student registration form
     * 
     * @return string
     */
    public function display_student_registration_form() {
        ob_start();

        wp_enqueue_style( 'student-reg-style' );
        wp_enqueue_script( 'student-reg-script' );

        require_once WSI_PATH . '/assets/templates/student-reg-template.php';

        $this->process_form();

        $html = ob_get_clean();

        return $html;
    }

    /**
     * Process form
     * 
     * @return void
     */
    public function process_form() {
        if ( isset( $_REQUEST['register_submit'] ) ) {
            unset( $_REQUEST['register_submit'] );

            foreach( $_REQUEST as $key => $value ) {
                if ( "" == $_REQUEST[$key] ) {
                    return;
                }
            }

            $args = array_map( 'sanitize_text_field', $_REQUEST );

            $args = [
                'first_name' => $args['first_name'],
                'last_name'  => $args['last_name'],
                's_class'    => $args['s_class'],
                'roll'       => $args['s_roll'],
                'reg_no'     => $args['reg_no'],
            ];

            $student_id = wsi_insert_student( $args );

            $marks = [
                'english'       => sanitize_text_field( absint( $_REQUEST['english'] ) ),
                'dsaal'         => sanitize_text_field( absint( $_REQUEST['dsaal'] ) ), 
                'pfundamantal'  => sanitize_text_field( absint( $_REQUEST['pfundamantal'] ) ),
                'dpattern'      => sanitize_text_field( absint( $_REQUEST['dpattern'] ) ),
                'sarchitecture' => sanitize_text_field( absint( $_REQUEST['sarchitecture'] ) ),
            ];

            if ( is_wp_error( $student_id ) ) {
                wp_die( $student_id->get_error_message() );
            }

            $this->update_student_meta( $student_id, 'marks', $marks );

            ?> 
                <script>
                    let success = document.querySelector( "#submit-success" );
                    success.innerText = "<?php echo __( "Register success", "we-student-info" ); ?>";
                    document.querySelector( "#student-regi-form" ).reset();
                </script>
            <?php
        }

    }

    /**
     * Display Student information
     * 
     * @return string
     */
    public function display_student_info() {
        ob_start();

        wp_enqueue_style( 'student-list-style' );

        
        echo '<div class="student-list-wrapper">';

        $current_page = ( ! empty( get_query_var( 'paged' ) ) ) ? get_query_var( 'paged' ) : 1;

        $per_page = 5;

        $args = [
            'number'  => $per_page,
            'offset'  => ( $current_page - 1 ) * $per_page,
            'orderby' => 'id',
            'order'   => 'DESC'
        ];

        $students = wsi_get_all_students( $args );

        if ( empty(  $students) ) {
            printf( '<h1>%s</h1>', __( 'Nothing found', 'we-student-info' ) );
        } else {
            require_once WSI_PATH . '/assets/templates/student-list-template.php';
        }

        $total_students = wsi_students_count();

        $total_page = ceil( $total_students / $per_page );

        echo "<div class='student_paginate'>";

        echo paginate_links( array(
            'format' => '?paged=%#%',
            'current' => $current_page,
            'total' => $total_page,
        ) );

        echo '</div>';

        echo '</div>';

        $html = ob_get_clean();

        return $html;
    }
}

