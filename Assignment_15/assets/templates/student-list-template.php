<?php use WeStudentInfo\Metawrapper; ?>

<?php foreach( $students as $student ): ?>
    <div class="wsi-list-product">
        <div class="title">
            <?php printf( '%s', __( 'Sutdent full name: ' . $student->first_name . ' ' . $student->last_name, 'we-student-info' ) ); ?>
        </div>
        <div class="text">
            <div class="description">
                <?php printf( '<p>%s</p>', __( 'Class : ' . $student->s_class, 'we-student-info' ) ); ?>
                <?php printf( '<p>%s</p>', __( 'Roll No : ' . $student->roll, 'we-student-info' ) ); ?>
                <?php printf( '<p>%s</p>', __( 'Reg No : ' . $student->reg_no, 'we-student-info' ) ); ?>
              </div>
        </div>

        <div class="preview">
            <?php 
                $additonal = $this->get_student_meta( $student->id, 'marks' );
                
                if ( empty( $additonal ) ) {
                    printf( '<p>%s</p>', __( 'No marks found', 'we-student-info' ) );
                } else {
                    printf( '<h3>%s</h3>', __( 'Total marks:', 'we-student-info' ) );
                    echo '<hr>';
                    foreach( $additonal[0] as $subject => $marks ) {
                        printf( '<p>%s : %d</p>', __( $subject, 'we-student-info' ), __( $marks, 'we-student-info' ) );
                    }
                }
            ?>
        </div>
    </div>
<?php endforeach; ?>
