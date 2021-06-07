<div class="layout">
    <div class="profile">
    <div class="profile__picture">
        <img src="<?php echo $author_avatar; ?>" alt="<?php echo esc_attr( $display_name ); ?>" />
    </div>
    <div class="profile__header">
        <div class="profile__account">
        <h4 class="profile__username"><?php echo esc_html__( $display_name, 'we-author-bio' ); ?></h4>
        </div>
        <div class="profile__edit">
            <a class="profile__button" href="<?php echo esc_url( get_author_posts_url( $author->ID ) ); ?>"><?php echo esc_html__( 'View Posts', 'we-author-bio' ); ?></a>
        </div>
    </div>
    <div class="profile__stats">
        <div class="profile__stat">
        <div class="profile__icon profile__icon--gold">
        </div>
        <div class="profile__value">
            <a href="<?php echo $twitter; ?>" target="_blank">
                <img class="profile__image" src="<?php echo esc_url( WDAB_ASSETS . '/icons/twitter.png' ); ?>">
            </a>
            <div class="profile__key"><a target="_blank" href="<?php echo $twitter; ?>"><?php echo esc_html__( 'Twitter', 'we-author-bio' ); ?></a></div>
        </div>
        </div>
        <div class="profile__stat">
        <div class="profile__icon profile__icon--blue">
        </div>
        <div class="profile__value">
            <a href="<?php echo $github; ?>" target="_blank">
                <img class="profile__image" src="<?php echo esc_url( WDAB_ASSETS . '/icons/github.png' ); ?>">
            </a>
            <div class="profile__key"><a target="_blank" href="<?php echo $github; ?>"><?php echo esc_html__( 'GitHub', 'we-author-bio' ); ?></a></div>
        </div>
        </div>
        <div class="profile__stat">
        <div class="profile__icon profile__icon--pink">
        </div>
        <div class="profile__value">
            <a href="<?php echo $linkedin; ?>" target="_blank">
                <img class="profile__image" src="<?php echo esc_url( WDAB_ASSETS . '/icons/linkedin.png' ); ?>">
            </a>
            <div class="profile__key"><a target="_blank" href="<?php echo $linkedin; ?>"><?php echo esc_html__( 'LinkedIn', 'we-author-bio' ); ?></a></div>
        </div>
        </div>
    </div>
    </div>
</div>