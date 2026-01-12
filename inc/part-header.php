<?php 
$email = velocitytheme_option('email');
$nowa = velocitytheme_option('nowa');
if (!empty($nowa)) {
    if (substr($nowa, 0, 1) === '0') {
        $nowa    = '62' . substr($nowa, 1);
    } else if (substr($nowa, 0, 1) === '+') {
        $nowa    = '' . substr($nowa, 1);
    }
}
?>
<div class="bg-colortheme">
    <div class="container d-flex flex-wrap gap-2 justify-content-start align-items-center bg-transparent py-md-0 p-1">
        <?php if( !empty( $nowa ) ): ?>
        <span class="px-2 my-1 header-contact-item d-inline-flex"><a class="text-white" href="https://wa.me/<?php echo $nowa;?>">
            <span class="d-flex justify-content-start align-items-center">
                <span class="bg-light rounded-5 text-dark d-inline-flex align-items-center justify-content-center" style="width:24px;height:24px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                        <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                    </svg>
                </span>
                <span class="ps-2">+<?php echo $nowa;?></span>
            </span>
        </a></span>
        <?php endif; ?>
        <?php if( !empty( $email ) ): ?>
        <span class="px-2 my-1 header-contact-item d-inline-flex"><a class="text-white" href="mailto:<?php echo $email;?>" target="_blank">
            <span class="d-flex justify-content-start align-items-center">
                <span class="bg-light rounded-5 text-dark d-inline-flex align-items-center justify-content-center" style="width:24px;height:24px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                        <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414z"/>
                        <path d="M0 4.697v7.104l5.803-3.558z"/>
                        <path d="M6.761 8.83 0 12.97A2 2 0 0 0 2 14h12a2 2 0 0 0 2-1.03l-6.761-4.14L8 9.586z"/>
                        <path d="M10.197 8.243 16 11.801V4.697z"/>
                    </svg>
                </span>
                <span class="ps-2"><?php echo $email;?></span>
            </span>
        </a></span>
        <?php endif; ?>
    </div>
</div>

<div class="bg-white shadow-sm">
<div class="container">
    <div class="row px-0 align-items-center py-2">
        <div class="col-md-2 col-7">
        <?php if (has_custom_logo()) :?>
            <div class="custom-logo-container text-start">
                <?php the_custom_logo();?>
            </div>
        <?php endif;?>
        </div>
        <div class="col-md-10 col-5">
            <nav id="main-navi" class="navbar navbar-expand-md d-block px-2 py-1 border-0" aria-labelledby="main-nav-label">
                <h2 id="main-nav-label" class="screen-reader-text">
                    <?php esc_html_e('Main Navigation', 'justg'); ?>
                </h2>

                <div class="fl-menu">
                    <div class="offcanvas offcanvas-start" tabindex="-1" id="navbarNavOffcanvas">
                        <div class="offcanvas-header justify-content-end pt-3">
                            <button type="button" class="btn-close btn-close-dark text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div><!-- .offcancas-header -->

                        <!-- The WordPress Menu goes here -->
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location'  => 'primary',
                                'container_class' => 'offcanvas-body',
                                'container_id'    => '',
                                'menu_class'      => 'navbar-nav justify-content-end flex-md-wrap flex-grow-1',
                                'fallback_cb'     => '',
                                'menu_id'         => 'primary-menu',
                                'depth'           => 4,
                                'walker'          => new justg_WP_Bootstrap_Navwalker(),
                            )
                        ); ?>

                    </div><!-- .offcanvas -->

                    <div class="menu-header d-md-none position-relative text-end" data-bs-theme="dark">
                        <button class="navbar-toggler text-dark p-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarNavOffcanvas" aria-controls="navbarNavOffcanvas" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'justg'); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/> </svg>
                        </button>
                    </div>
                </div>
            </nav><!-- .site-navigation -->
        </div>
    </div>
</div>
</div>
