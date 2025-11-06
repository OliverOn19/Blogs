<?php
/**
 * The template for displaying the footer.
 *
*/
?>
	

    <?php /* PAGE PRELOADER */ ?>
    <?php
        if (tonsberg_redux('mt_preloader_status')) {
            echo '<div class="tonsberg_preloader_holder">
                    <div class="globe-wrapper">
                      <div class="globe-loader fa fa-globe">
                        <i class="fa fa-fighter-jet"></i>
                      </div>
                    </div>
                </div>';
        } 
    ?>

    
    <!-- BEGIN: FLOATING SOCIAL BUTTON -->
    <?php if ( class_exists( 'ReduxFrameworkPlugin' ) ) { ?>
        <?php echo tonsberg_floating_social_button(); ?>
    <?php } ?>
    <!-- END: FLOATING SOCIAL BUTTON -->

    <?php if ( class_exists( 'ReduxFrameworkPlugin' ) ) { ?>
        <!-- BACK TO TOP BUTTON -->
        <a class="back-to-top modeltheme-is-visible modeltheme-fade-out" href="<?php echo esc_url('#0'); ?>">
            <i class="fa fa-long-arrow-up" aria-hidden="true"></i>
        </a>
    <?php } else { ?>
        <?php if (tonsberg_redux('mt_backtotop_status') == true) { ?>
            <!-- BACK TO TOP BUTTON -->
            <a class="back-to-top modeltheme-is-visible modeltheme-fade-out" href="<?php echo esc_url('#0'); ?>">
                <i class="fa fa-long-arrow-up" aria-hidden="true"></i>
            </a>
        <?php } ?>
    <?php } ?>

    <!-- FOOTER -->
    <footer>

        <!-- FOOTER TOP -->
        <div class="row footer-top">
            <div class="container">
            <?php          
                //FOOTER ROW #1
                echo tonsberg_footer_row1();
                //FOOTER ROW #2
                echo tonsberg_footer_row2();
                //FOOTER ROW #3
                echo tonsberg_footer_row3();
             ?>
            </div>
        </div>

        <!-- FOOTER BOTTOM -->
        <div class="footer-div-parent">
            <div class="container footer">
                <div class="container_inner_footer">
                    <div class="row">
                        <div class="col-md-12">
                        	<p class="copyright text-center">
                                <?php if ( class_exists( 'ReduxFrameworkPlugin' ) ) { ?>
                                    <?php echo wp_kses_post(tonsberg_redux('mt_footer_text')); ?>
                                <?php }else{ ?>
                                    <span class="copyright_left"><?php echo esc_html__('Tonsberg Theme by ModelTheme. All Rights Reserved', 'tonsberg'); ?></span>
                                    <span class="copyright_right"><?php echo esc_html__('Elite Author on ThemeForest', 'tonsberg'); ?></span>
                                <?php } ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>


<?php wp_footer(); ?>
</body>
</html>