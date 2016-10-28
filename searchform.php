<?php
/**
 * Template for displaying search forms in Mesopotamia
 *
 * @package Mesopotamia
 *
 *
 */
?>
<!--	<label>-->
<!--		<span class="screen-reader-text">--><?php //echo _x( 'Search for:', 'label', 'mesopotamia' ); ?><!--</span>-->
<!--	</label>-->

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="row">
		<div class="col-lg-12">
			<div class="input-group">
				<input type="search" class="search-field form-control input-search"
				       placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'mesopotamia' ); ?>"
				       value="<?php echo get_search_query(); ?>" name="s"
				       title="<?php echo esc_attr_x( 'Search for:', 'label', 'mesopotamia' ); ?>"/>
        <span class="input-group-btn">
	                <button class="btn btn-search search-submit" type="submit"><i class="fa fa-search"></i><span
			                class="screen-reader-text"><?php echo _x( 'Search', 'submit button', 'mesopotamia' ); ?></span>
	                </button>
        </span>
			</div><!-- /input-group -->
		</div><!-- /.col-lg-6 -->
	</div><!-- /.row -->
</form>
