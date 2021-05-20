<?php 

namespace My\Github\Frontend;

class Shortcode {

    public function __construct() {
        add_shortcode( 'wd-my-github-job', [ $this, 'wd_job_render_search_form' ] );
    }

    /**
     * Render serach form
     */
    public function wd_job_render_search_form() {
        ob_start();
            include_once WD_JOB_GITHUB_BASE_PATH .'/templates/search_form.php';
        echo ob_get_clean();

        $keyword   = $_REQUEST[ 'keyword' ];
        $location  = $_REQUEST[ 'location' ];
        $full_time = $_REQUEST[ 'full_time' ];

        $wd_search_url = 'https://jobs.github.com/positions.json?';
        $wd_search_args = [
            'timeout'   => 20
        ];

        if( '' !== $keyword ) {
            $this->wd_search_url .= '&description=' . $keyword;
        }

        if( '' !== $location ) {
            $this->wd_search_url .= '&location=' . $location; 
        }

        if( '' !== $full_time ) {
            $this->wd_search_url .= '&full_time=' . $full_time;
        }

        $response = wp_remote_get( $wd_search_url, $wd_search_args );
        $body = wp_remote_retrieve_body( $response );
        
        $serach_items = json_decode( $body );

        if( ! empty( $serach_items ) ) {
            foreach( $serach_items as $single_item ) {
                include WD_JOB_GITHUB_BASE_PATH .'/templates/job_list.php'; 
            }
        }
        else{
            echo "There is no matched job which you'\r sreaching";
        }
    }
}