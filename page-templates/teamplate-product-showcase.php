<?php

/**
 * Template Name: Product Showcase
 */
get_header();
?>
<style>
    html{
        scroll-behavior: smooth;
    }
    :root {
        --primary: #0F8C7E; --secondary: #F0FDFA; --dark: #111111;
    }
</style>
<?php
get_template_part( 'page-templates/product-showcase/hero' );
get_template_part( 'page-templates/product-showcase/statistics' );
get_template_part( 'page-templates/product-showcase/layouts' );
get_template_part( 'page-templates/product-showcase/features' );
get_template_part( 'page-templates/product-showcase/offers' );
get_template_part( 'page-templates/product-showcase/backend-screenshots' );
get_template_part( 'page-templates/product-showcase/pricing' );
get_template_part( 'page-templates/product-showcase/money-back' );
get_template_part( 'page-templates/deals-parts/faq' );
get_footer();
?>