<footer class="site-footer p-0" id="colophon">
    <div class="card m-0 bg-colortheme rounded-0 border-0 shadow py-5">
        <div class="container bg-transparent">
        <?php if (is_active_sidebar('footer-widget-1')) : ?>
            <div class="velocity-footer">
                <div class="row footer-widget text-start pt-4">
                    <?php for ($x = 1; $x <= 4; $x++) {
                        if (is_active_sidebar('footer-widget-' . $x)) : ?>
                            <div class="col-md">
                                <?php dynamic_sidebar('footer-widget-' . $x); ?>
                            </div>
                        <?php endif; ?>
                    <?php } ?>
                </div>
            </div>
        <?php endif; ?>
        </div>
    </div>

    <div class="site-info bg-light text-center text-dark py-3">
        <div class="container bg-transparent">
            <small>Copyright © <?php echo date("Y"); ?> <?php echo get_bloginfo('name'); ?>. All Rights Reserved.</small><br/>
            <small class="opacity-50">Design by <a class="text-dark" href="https://velocitydeveloper.com" target="_blank" rel="noopener noreferrer"> Velocity Developer </a></small>
        </div>
    </div>
    <!-- .site-info -->
</footer>