<?php
use Prodigy\Includes\Helpers\Prodigy_Template;
?>

<?php if ( $args['params']['is_enable_logo'] ) : ?>
    <div class="prodigy-logo-tool logo-container-js">
        <div class="prodigy-logo-tool__container opened">
			<?php Prodigy_Template::prodigy_get_template( 'single-product/logo/logo-block.php', $args['params'] ); ?>
        </div>
        <div class="prodigy-logo-tool__container container-js closed">
			<?php if ( $args['params']['is_logo_tool_multiple_locations'] ) : ?>
				<?php Prodigy_Template::prodigy_get_template( 'single-product/logo/logo-switcher.php' ); ?>
			<?php endif; ?>
			<?php Prodigy_Template::prodigy_get_template( 'single-product/logo/logo-block.php', $args['params'] ); ?>
        </div>
        <template id="logo-form-template">
            <div class="prodigy-logo-tool__container container-js closed">
				<?php if ( $args['params']['is_logo_tool_multiple_locations'] ) : ?>
					<?php Prodigy_Template::prodigy_get_template( 'single-product/logo/logo-switcher.php' ); ?>
				<?php endif; ?>
				<?php Prodigy_Template::prodigy_get_template( 'single-product/logo/logo-block.php', $args['params'] ); ?>
            </div>
        </template>
    </div>
<?php endif; ?>