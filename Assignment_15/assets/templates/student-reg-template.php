<h1 id="submit-success"> <?php echo esc_html__( 'Student Registration Form', 'we-student-info' ); ?> 
  <small><?php echo esc_html__( 'Every student should fulfill all the input fields', 'we-student-info' ); ?></small>
</h1>
<section class="we-contact-wrap">
  <form action="" class="we-contact-form" method="POST" id="student-regi-form">
    <div class="col-sm-6">
        <?php if ( isset( $_REQUEST['register_submit'] ) && '' == $_REQUEST['first_name'] ): ?>
        <p class="description sform-required" id="tagline-description"><?php echo esc_html__( "This field can't be empty", "we-student-info" ); ?></p>
        <?php endif; ?>
        <div class="input-block">
            <label for="first_name"><?php echo esc_html__( 'First Name', 'we-student-info' ); ?></label>
            <input type="text" class="we-form-control form-required" name="first_name" id="first_name" value="">
        </div>
    </div>
    <div class="col-sm-6">
        <?php if ( isset( $_REQUEST['register_submit'] ) && '' == $_REQUEST['last_name'] ): ?>
        <p class="description sform-required" id="tagline-description"><?php echo esc_html__( "This field can't be empty", "we-student-info" ); ?></p>
        <?php endif; ?>
        <div class="input-block">
            <label for="last_name"><?php echo esc_html__( 'Last Name', 'we-student-info' ); ?></label>
            <input type="text" class="we-form-control" name="last_name" id="last_name" value="">
        </div>
    </div>
    <div class="col-sm-12">
        <?php if ( isset( $_REQUEST['register_submit'] ) && '' == $_REQUEST['s_class'] ): ?>
        <p class="description sform-required" id="tagline-description"><?php echo esc_html__( "This field can't be empty", "we-student-info" ); ?></p>
        <?php endif; ?>
        <div class="input-block">
            <label for="s_class"><?php echo esc_html__( 'Class', 'we-student-info' ); ?></label>
            <input type="text" class="we-form-control" name="s_class" id="s_class" value="">
        </div>
    </div>
    <div class="col-sm-12">
        <?php if ( isset( $_REQUEST['register_submit'] ) && '' == $_REQUEST['s_roll'] ): ?>
        <p class="description sform-required" id="tagline-description"><?php echo esc_html__( "This field can't be empty", "we-student-info" ); ?></p>
        <?php endif; ?>
        <div class="input-block">
            <label for="s_roll"><?php echo esc_html__( 'Roll', 'we-student-info' ); ?></label>
            <input type="text" class="we-form-control" name="s_roll" id="s_roll" value="">
        </div>
    </div>
    <div class="col-sm-12">
        <?php if ( isset( $_REQUEST['register_submit'] ) && '' == $_REQUEST['reg_no'] ): ?>
        <p class="description sform-required" id="tagline-description"><?php echo esc_html__( "This field can't be empty", "we-student-info" ); ?></p>
        <?php endif; ?>
        <div class="input-block textarea">
            <label for="reg_no"><?php echo esc_html__( 'Reg NO', 'we-student-info' ); ?></label>
            <input type="text" class="we-form-control" name="reg_no" id="reg_no" value="">
        </div>
    </div>
    <div class="col-sm-12">
      <p><?php echo esc_html__( 'Please add subject Marks', 'we-student-info' ); ?></p>
    </div>
    <div class="col-sm-12">
        <?php if ( isset( $_REQUEST['register_submit'] ) && '' == $_REQUEST['english'] ): ?>
        <p class="description sform-required" id="tagline-description"><?php echo esc_html__( "This field can't be empty", "we-student-info" ); ?></p>
        <?php endif; ?>
        <div class="input-block textarea">
            <label for="english"><?php echo esc_html__( 'English', 'we-student-info' ); ?></label>
            <input type="number" class="we-form-control" name="english" id="english" value="">
        </div>
    </div>
    <div class="col-sm-12">
        <?php if ( isset( $_REQUEST['register_submit'] ) && '' == $_REQUEST['dsaal'] ): ?>
        <p class="description sform-required" id="tagline-description"><?php echo esc_html__( "This field can't be empty", "we-student-info" ); ?></p>
        <?php endif; ?>
        <div class="input-block textarea">
            <label for="dsaal"><?php echo esc_html__( 'Data structures and algorithms', 'we-student-info' ); ?></label>
            <input type="number" class="we-form-control" name="dsaal" id="dsaal" value="">
        </div>
    </div>
    <div class="col-sm-12">
        <?php if ( isset( $_REQUEST['register_submit'] ) && '' == $_REQUEST['pfundamantal'] ): ?>
        <p class="description sform-required" id="tagline-description"><?php echo esc_html__( "This field can't be empty", "we-student-info" ); ?></p>
        <?php endif; ?>
        <div class="input-block textarea">
            <label for="pfundamental"><?php echo esc_html__( 'Programming fundamentals', 'we-student-info' ); ?></label>
            <input type="number" class="we-form-control" name="pfundamantal" id="pfundamantal" value="">
        </div>
    </div>
    <div class="col-sm-12">
        <?php if ( isset( $_REQUEST['register_submit'] ) && '' == $_REQUEST['dpattern'] ): ?>
        <p class="description sform-required" id="tagline-description"><?php echo esc_html__( "This field can't be empty", "we-student-info" ); ?></p>
        <?php endif; ?>
        <div class="input-block textarea">
            <label for="dpattern"><?php echo esc_html__( 'Design patterns', 'we-student-info' ); ?></label>
            <input type="number" class="we-form-control" name="dpattern" id="dpattern" value="">
        </div>
    </div>
    <div class="col-sm-12">
        <?php if ( isset( $_REQUEST['register_submit'] ) && '' == $_REQUEST['sarchitecture'] ): ?>
        <p class="description sform-required" id="tagline-description"><?php echo esc_html__( "This field can't be empty", "we-student-info" ); ?></p>
        <?php endif; ?>
        <div class="input-block textarea">
            <label for="sarchitecture"><?php echo esc_html__( 'Software architecture', 'we-student-info' ); ?></label>
            <input type="number" class="we-form-control" name="sarchitecture" id="sarchitecture" value="">
        </div>
    </div>
    <div class="col-sm-12">
      <input type="submit" name="register_submit" class="square-button" value="<?php echo esc_attr__( 'Save', 'we-student-info' ); ?>">
    </div>
  </form>
</section>
