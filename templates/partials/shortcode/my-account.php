<?php

use Prodigy\Includes\Prodigy_Options;
use Prodigy\Includes\Prodigy_User as User;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php if ( Prodigy_Options::get_redemption_store_status() ) : ?>
	<li class="prodigy-navbar-account__wrap prodigy-custom-template <?php echo esc_attr( $container_class ); ?>"
		id="my-account">
		<div class="prodigy-navbar-account__wrap-inner prodigy-dropdown-account__inner-wrap">
			<?php if ( User::is_logged_in() ) : ?>
				<div class="prodigy-navbar-account d-flex p-0">
					<span class="prodigy-navbar-user">
						<?php if ( ! empty( $args['icon_utf'] ) ) : ?>
							<span class="divi-icon-output prodigy-navbar-account__icon"
									data-icon-type="<?php echo esc_attr( $args['icon_type'] ); ?>"
									data-icon-utf="<?php echo esc_url( $args['icon_utf'] ); ?>"
									data-icon-font-weight="<?php echo esc_attr( $args['icon_weight'] ); ?>"
									data-icon="<?php echo esc_attr( $args['icon_utf'] ); ?>">
							</span>
						<?php elseif ( empty( $args['icon_type'] ) ) : ?>
							<i class="<?php echo esc_attr( $args['icon_class'] ?? 'icon icon-user' ); ?> icon icon-user prodigy-navbar-account__icon"></i>
						<?php endif; ?>
						<?php if ( isset( $args['icon_type'] ) && $args['icon_type'] === 'icon' ) : ?>
							<i class="<?php echo esc_attr( $args['icon_class'] ?? '' ); ?> "></i>
						<?php elseif ( isset( $args['icon_type'] ) && $args['icon_type'] === 'svg' ) : ?>
							<img class="<?php echo esc_attr( $args['icon_svg_class'] ); ?>"
								src="<?php echo esc_attr( $args['my_account_icon_url'] ); ?>" alt="">
						<?php endif; ?>
					</span>
					<span class="prodigy-navbar-user__status">
						<?php echo esc_html( $args['heading_text'] ?? '' ); ?>
					</span>
				</div>
			<?php else : ?>
				<span class="prodigy-navbar-account d-flex p-0 user-login-js" role="button">
					<span class="prodigy-navbar-user">
						<?php if ( isset( $args['icon_type'] ) && $args['icon_type'] === 'icon' ) : ?>
							<i class="<?php echo esc_attr( $args['icon_class']['value'] ?? '' ); ?> "></i>
						<?php elseif ( isset( $args['icon_type'] ) && $args['icon_type'] === 'svg' ) : ?>
							<img class="<?php echo esc_attr( $args['icon_svg_class'] ); ?>"
								src="<?php echo esc_attr( $args['my_account_icon_url'] ); ?>" alt="">
						<?php endif; ?>

						<?php if ( empty( $args['icon_class']['value'] ) ) : ?>
							<i class="icon icon-user prodigy-navbar-account__icon"></i>
						<?php endif; ?>
					</span>
					<span class="prodigy-navbar-user__status"><?php esc_html_e( 'Login', 'prodigy' ); ?></span>
				</span>
			<?php endif; ?>
			<div class="prodigy-account__block prodigy-custom-template"
				style="display: <?php echo \Prodigy\Includes\Prodigy_User::is_logged_in() ? '' : 'none'; ?> ">
				<div class="prodigy-account__menu">
					<div class="prodigy-account__menu-header-dropdown">
						<div class="d-flex align-items-center w-100">
						<span class="prodigy-navbar-user prodigy-navbar-user--head">
							<svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
								xmlns="http://www.w3.org/2000/svg">
								<g id="Selected" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
									<g id="Account-menu" transform="translate(-1392, -97)">
										<g id="line-copy" transform="translate(1116, 97)">
											<g id="user--avatar-header" transform="translate(276, 0)">
												<path class="prodigy-custom-fill"
														d="M12,6 C9.92893219,6 8.25,7.67893219 8.25,9.75 C8.25,11.8210678 9.92893219,13.5 12,13.5 C14.0710678,13.5 15.75,11.8210678 15.75,9.75 C15.75,8.75543816 15.3549118,7.80161099 14.6516504,7.09834957 C13.948389,6.39508815 12.9945618,6 12,6 Z M12,12 C10.7573593,12 9.75,10.9926407 9.75,9.75 C9.75,8.50735931 10.7573593,7.5 12,7.5 C13.2426407,7.5 14.25,8.50735931 14.25,9.75 C14.2485947,10.9920581 13.2420581,11.9985947 12,12 L12,12 Z"
														id="Shape" fill="#49463D" fill-rule="nonzero"></path>
												<path class="prodigy-custom-fill"
														d="M12,1.5 C6.20101013,1.5 1.5,6.20101013 1.5,12 C1.5,17.7989899 6.20101013,22.5 12,22.5 C17.7989899,22.5 22.5,17.7989899 22.5,12 C22.4934695,6.20371729 17.7962827,1.50653047 12,1.5 L12,1.5 Z M7.5,19.782375 L7.5,18.75 C7.50136403,17.5079248 8.50792475,16.501364 9.75,16.5 L14.25,16.5 C15.4920752,16.501364 16.498636,17.5079248 16.5,18.75 L16.5,19.782375 C13.7196463,21.4058762 10.2803537,21.4058762 7.5,19.782375 L7.5,19.782375 Z M17.994375,18.69435 C17.9633542,16.6475088 16.2970733,15.0034894 14.25,15 L9.75,15 C7.70292667,15.0034894 6.03664578,16.6475088 6.005625,18.69435 C3.22118315,16.2080675 2.26057568,12.2609961 3.59110359,8.77324428 C4.92163151,5.28549247 8.26707658,2.98111916 12,2.98111916 C15.7329234,2.98111916 19.0783685,5.28549247 20.4088964,8.77324428 C21.7394243,12.2609961 20.7788168,16.2080675 17.994375,18.69435 L17.994375,18.69435 Z"
														id="Shape" fill="#49463D" fill-rule="nonzero"></path>
												<rect id="_Transparent_Rectangle_" x="0" y="0" width="24"
														height="24"></rect>
											</g>
										</g>
									</g>
								</g>
							</svg>
						</span>
							<div class="prodigy-data-user">
								<p class="prodigy-data-user__name"><?php echo sanitize_text_field( wp_unslash( $_COOKIE[ User::USER_INFO_COOKIE_NAME ] ?? '' ) ); ?>
									&nbsp;<?php echo sanitize_text_field( wp_unslash( $_COOKIE[ User::USER_INFO_COOKIE_LAST_NAME ] ?? '' ) ); ?></p>
								<p class="prodigy-data-user__email"><?php echo sanitize_email( wp_unslash( $_COOKIE[ User::USER_INFO_COOKIE_EMAIL ] ?? '' ) ); ?></p>
							</div>
						</div>
					</div>
					<div class="prodigy-account__menu-header-slide">
						<div class="prodigy-navbar-user__slide-title-wrap">
							<h3 class="prodigy-navbar-user__slide-title">
								<?php echo esc_html( $args['heading_text'] ?? '' ); ?>
							</h3>
							<button class="prodigy-account-slide__header-close icon icon-close" type="button"></button>
						</div>
					</div>
					<div class="prodigy-account__menu-body">
						<a href="<?php echo esc_url( $args['get_customer_account_url'] ); ?>"
							target="_blank"
							class="prodigy-account__menu-item">
						<span class="d-flex flex-column align-items-center justify-content-center">
							<svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
								xmlns="http://www.w3.org/2000/svg">
								<g id="Selected" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
									<g id="Account-menu" transform="translate(-1392, -97)">
										<g id="line-copy" transform="translate(1116, 97)">
											<g id="user--avatar" transform="translate(276, 0)">
												<path class="prodigy-custom-fill"
														d="M12,6 C9.92893219,6 8.25,7.67893219 8.25,9.75 C8.25,11.8210678 9.92893219,13.5 12,13.5 C14.0710678,13.5 15.75,11.8210678 15.75,9.75 C15.75,8.75543816 15.3549118,7.80161099 14.6516504,7.09834957 C13.948389,6.39508815 12.9945618,6 12,6 Z M12,12 C10.7573593,12 9.75,10.9926407 9.75,9.75 C9.75,8.50735931 10.7573593,7.5 12,7.5 C13.2426407,7.5 14.25,8.50735931 14.25,9.75 C14.2485947,10.9920581 13.2420581,11.9985947 12,12 L12,12 Z"
														id="Shape" fill="#49463D" fill-rule="nonzero"></path>
												<path class="prodigy-custom-fill"
														d="M12,1.5 C6.20101013,1.5 1.5,6.20101013 1.5,12 C1.5,17.7989899 6.20101013,22.5 12,22.5 C17.7989899,22.5 22.5,17.7989899 22.5,12 C22.4934695,6.20371729 17.7962827,1.50653047 12,1.5 L12,1.5 Z M7.5,19.782375 L7.5,18.75 C7.50136403,17.5079248 8.50792475,16.501364 9.75,16.5 L14.25,16.5 C15.4920752,16.501364 16.498636,17.5079248 16.5,18.75 L16.5,19.782375 C13.7196463,21.4058762 10.2803537,21.4058762 7.5,19.782375 L7.5,19.782375 Z M17.994375,18.69435 C17.9633542,16.6475088 16.2970733,15.0034894 14.25,15 L9.75,15 C7.70292667,15.0034894 6.03664578,16.6475088 6.005625,18.69435 C3.22118315,16.2080675 2.26057568,12.2609961 3.59110359,8.77324428 C4.92163151,5.28549247 8.26707658,2.98111916 12,2.98111916 C15.7329234,2.98111916 19.0783685,5.28549247 20.4088964,8.77324428 C21.7394243,12.2609961 20.7788168,16.2080675 17.994375,18.69435 L17.994375,18.69435 Z"
														id="Shape" fill="#49463D" fill-rule="nonzero"></path>
												<rect id="_Transparent_Rectangle_" x="0" y="0" width="24"
														height="24"></rect>
											</g>
										</g>
									</g>
								</g>
							</svg>
						</span>
							<p class="prodigy-account__menu-item-name"><?php esc_html_e( 'My Account', 'prodigy' ); ?></p>
						</a>
						<a href="<?php echo esc_url( $args['get_customer_orders_url'] ); ?>"
							target="_blank"
							class="prodigy-account__menu-item">
						<span class="d-flex flex-column align-items-center justify-content-center">
							<svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
								xmlns="http://www.w3.org/2000/svg">
								<g id="Selected" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
									<g id="Account-menu" transform="translate(-1392, -170)">
										<g id="report" transform="translate(1392, 170)">
											<rect class="prodigy-custom-fill" id="Rectangle" fill="#49463D"
													fill-rule="nonzero" x="7.5" y="13.5" width="6" height="1.5"></rect>
											<rect class="prodigy-custom-fill" id="Rectangle" fill="#49463D"
													fill-rule="nonzero" x="7.5" y="9.75" width="9" height="1.5"></rect>
											<rect class="prodigy-custom-fill" id="Rectangle" fill="#49463D"
													fill-rule="nonzero" x="7.5" y="17.25" width="3.75"
													height="1.5"></rect>
											<path class="prodigy-custom-fill"
													d="M18.75,3.75 L16.5,3.75 L16.5,3 C16.5,2.17157288 15.8284271,1.5 15,1.5 L9,1.5 C8.17157288,1.5 7.5,2.17157288 7.5,3 L7.5,3.75 L5.25,3.75 C4.42157288,3.75 3.75,4.42157288 3.75,5.25 L3.75,21 C3.75,21.8284271 4.42157288,22.5 5.25,22.5 L18.75,22.5 C19.5784271,22.5 20.25,21.8284271 20.25,21 L20.25,5.25 C20.25,4.42157288 19.5784271,3.75 18.75,3.75 Z M9,3 L15,3 L15,6 L9,6 L9,3 Z M18.75,21 L5.25,21 L5.25,5.25 L7.5,5.25 L7.5,7.5 L16.5,7.5 L16.5,5.25 L18.75,5.25 L18.75,21 Z"
													id="Shape" fill="#49463D" fill-rule="nonzero"></path>
											<rect id="_Transparent_Rectangle_" x="0" y="0" width="24"
													height="24"></rect>
										</g>
									</g>
								</g>
							</svg>
						</span>
							<p class="prodigy-account__menu-item-name"><?php esc_html_e( 'Orders', 'prodigy' ); ?></p>
						</a>
						<?php if ( $args['subscriptions'] ) : ?>
							<a href="<?php echo esc_url( $args['get_customer_subscriptions_url'] ); ?>"
								target="_blank"
								class="prodigy-account__menu-item">
								<span class="d-flex flex-column align-items-center justify-content-center">
									<svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
										xmlns="http://www.w3.org/2000/svg">
										<g id="Selected" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<g id="Account-menu" transform="translate(-1392, -243)">
												<g id="shopping--cart--plus" transform="translate(1392, 243)">
													<circle class="prodigy-custom-fill" id="Oval" fill="#49463D"
															fill-rule="nonzero" cx="7.5" cy="21" r="1.5"></circle>
													<circle class="prodigy-custom-fill" id="Oval" fill="#49463D"
															fill-rule="nonzero" cx="18" cy="21" r="1.5"></circle>
													<path class="prodigy-custom-fill"
															d="M3.73545,2.102925 C3.66534034,1.7523467 3.35751994,1.5 3,1.5 L0,1.5 L0,3 L2.385,3 L5.26455,17.397075 C5.33465966,17.7476533 5.64248006,18 6,18 L19.5,18 L19.5,16.5 L6.615,16.5 L6.015,13.5 L19.5,13.5 C19.851512,13.5 20.1558719,13.255886 20.23215,12.91275 L21.933375,5.25 L20.397825,5.25 L18.89865,12 L5.715,12 L3.73545,2.102925 Z"
															id="Path" fill="#49463D" fill-rule="nonzero"></path>
													<polygon class="prodigy-custom-fill" id="Path" fill="#49463D"
															fill-rule="nonzero"
															points="13.5 4.5 13.5 1.5 12 1.5 12 4.5 9 4.5 9 6 12 6 12 9 13.5 9 13.5 6 16.5 6 16.5 4.5"></polygon>
													<rect id="_Transparent_Rectangle_" x="0" y="0" width="24"
															height="24"></rect>
												</g>
											</g>
										</g>
									</svg>
								</span>
								<p class="prodigy-account__menu-item-name"><?php esc_html_e( 'Subscriptions', 'prodigy' ); ?></p>
							</a>
						<?php endif; ?>
						<?php if ( $args['customer_balance'] !== false && $args['customer_balance'] !== '' ) : ?>
							<a href="<?php echo esc_url( $args['get_customer_giftcards_url'] ); ?>"
								target="_blank"
								class="prodigy-account__menu-item">
								<span class="d-flex flex-column align-items-center justify-content-center">
									<svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
										xmlns="http://www.w3.org/2000/svg">
										<g id="Selected" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<g id="Account-menu" transform="translate(-1392, -316)">
												<g id="gift" transform="translate(1392, 316)">
													<path class="prodigy-custom-fill"
															d="M19.5,7.5 L17.428725,7.5 C18.4433158,6.00044219 18.0895163,3.96690301 16.6280817,2.8981294 C15.1666471,1.82935579 13.1215254,2.1085204 12,3.529875 C10.8762041,2.11580867 8.83654374,1.84101038 7.37858339,2.90724321 C5.92062305,3.97347603 5.56431782,6.0004874 6.571275,7.5 L4.5,7.5 C3.67200116,7.50103306 3.00103306,8.17200116 3,9 L3,12 C3.00103306,12.8279988 3.67200116,13.4989669 4.5,13.5 L4.5,21 C4.50103306,21.8279988 5.17200116,22.4989669 6,22.5 L18,22.5 C18.8279988,22.4989669 19.4989669,21.8279988 19.5,21 L19.5,13.5 C20.3279988,13.4989669 20.9989669,12.8279988 21,12 L21,9 C20.9989669,8.17200116 20.3279988,7.50103306 19.5,7.5 Z M12.75,5.625 C12.75,4.58946609 13.5894661,3.75 14.625,3.75 C15.6605339,3.75 16.5,4.58946609 16.5,5.625 C16.5,6.66053391 15.6605339,7.5 14.625,7.5 L12.75,7.5 L12.75,5.625 Z M9.375,3.75 C10.4100199,3.75123979 11.2487602,4.58998007 11.25,5.625 L11.25,7.5 L9.375,7.5 C8.33946609,7.5 7.5,6.66053391 7.5,5.625 C7.5,4.58946609 8.33946609,3.75 9.375,3.75 Z M4.5,9 L11.25,9 L11.25,12 L4.5,12 L4.5,9 Z M6,13.5 L11.25,13.5 L11.25,21 L6,21 L6,13.5 Z M18.0009,21 L12.75,21 L12.75,13.5 L18,13.5 L18.0009,21 Z M12.75,12 L12.75,9 L19.5,9 L19.5009,12 L12.75,12 Z"
															id="Shape" fill="#49463D" fill-rule="nonzero"></path>
													<rect id="_Transparent_Rectangle_" x="0" y="0" width="24"
															height="24"></rect>
												</g>
											</g>
										</g>
									</svg>
								</span>
								<p class="prodigy-account__menu-item-name"><?php esc_html_e( 'Gift Cards Balance', 'prodigy' ) . ':'; ?>
									<span>( $<?php echo get_option( User::CUSTOMER_BALANCE_OPTION ); ?>  )</span></p>
							</a>
						<?php endif; ?>
						<a href="<?php echo esc_url( $args['get_customer_addresses_url'] ); ?>"
							target="_blank"
							class="prodigy-account__menu-item">
						<span class="d-flex flex-column align-items-center justify-content-center">
							<svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
								xmlns="http://www.w3.org/2000/svg">
								<g id="Selected" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
									<g id="Account-menu" transform="translate(-1392, -389)">
										<g id="enterprise" transform="translate(1392, 389)">
											<rect class="prodigy-custom-fill" id="Rectangle" fill="#49463D"
													fill-rule="nonzero" x="6" y="6" width="1.5" height="3"></rect>
											<rect class="prodigy-custom-fill" id="Rectangle" fill="#49463D"
													fill-rule="nonzero" x="6" y="10.5" width="1.5" height="3"></rect>
											<rect class="prodigy-custom-fill" id="Rectangle" fill="#49463D"
													fill-rule="nonzero" x="10.5" y="6" width="1.5" height="3"></rect>
											<rect class="prodigy-custom-fill" id="Rectangle" fill="#49463D"
													fill-rule="nonzero" x="10.5" y="10.5" width="1.5" height="3"></rect>
											<rect class="prodigy-custom-fill" id="Rectangle" fill="#49463D"
													fill-rule="nonzero" x="6" y="15" width="1.5" height="3"></rect>
											<rect class="prodigy-custom-fill" id="Rectangle" fill="#49463D"
													fill-rule="nonzero" x="10.5" y="15" width="1.5" height="3"></rect>
											<path class="prodigy-custom-fill"
													d="M22.5,10.5 C22.5,9.67157288 21.8284271,9 21,9 L16.5,9 L16.5,3 C16.5,2.17157288 15.8284271,1.5 15,1.5 L3,1.5 C2.17157288,1.5 1.5,2.17157288 1.5,3 L1.5,22.5 L22.5,22.5 L22.5,10.5 Z M3,3 L15,3 L15,21 L3,21 L3,3 Z M16.5,21 L16.5,10.5 L21,10.5 L21,21 L16.5,21 Z"
													id="Shape" fill="#49463D" fill-rule="nonzero"></path>
											<rect id="_Transparent_Rectangle_" x="0" y="0" width="24"
													height="24"></rect>
										</g>
									</g>
								</g>
							</svg>
						</span>
							<p class="prodigy-account__menu-item-name"><?php esc_html_e( 'Addresses', 'prodigy' ); ?></p>
						</a>
						<a href="<?php echo esc_url( $args['get_customer_payment_methods_url'] ); ?>"
							target="_blank"
							class="prodigy-account__menu-item">
						<span class="d-flex flex-column align-items-center justify-content-center">
							<svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
								xmlns="http://www.w3.org/2000/svg">
								<g id="Selected" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
									<g id="Account-menu" transform="translate(-1392, -462)">
										<g id="purchase" transform="translate(1392, 462)">
											<path class="prodigy-custom-fill"
													d="M21,4.5 L3,4.5 C2.17157288,4.5 1.5,5.17157288 1.5,6 L1.5,18 C1.5,18.8284271 2.17157288,19.5 3,19.5 L21,19.5 C21.8284271,19.5 22.5,18.8284271 22.5,18 L22.5,6 C22.5,5.17157288 21.8284271,4.5 21,4.5 Z M21,6 L21,8.25 L3,8.25 L3,6 L21,6 Z M3,18 L3,9.75 L21,9.75 L21,18 L3,18 Z"
													id="Shape" fill="#49463D" fill-rule="nonzero"></path>
											<rect class="prodigy-custom-fill" id="Rectangle" fill="#49463D"
													fill-rule="nonzero" x="4.5" y="15" width="7.5" height="1.5"></rect>
											<rect id="_Transparent_Rectangle_" x="0" y="0" width="24"
													height="24"></rect>
										</g>
									</g>
								</g>
							</svg>
						</span>
							<p class="prodigy-account__menu-item-name"><?php esc_html_e( 'Payment Methods', 'prodigy' ); ?></p>
						</a>
					</div>
					<div class="prodigy-account__menu-footer">
						<a href="<?php echo esc_url( $args['get_customer_profile_settings_url'] ); ?>"
							target="_blank"
							class="prodigy-account__menu-item">
						<span class="d-flex flex-column align-items-center justify-content-center">
							<svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
								xmlns="http://www.w3.org/2000/svg">
								<g id="Selected" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
									<g id="Account-menu" transform="translate(-1267, -652)">
										<g id="settings" transform="translate(1267, 652)">
											<path class="prodigy-custom-fill"
													d="M20.25,12.57 C20.25,12.3825 20.25,12.195 20.25,12 C20.25,11.805 20.25,11.6175 20.25,11.4225 L21.69,10.1625 C22.2380405,9.67945598 22.3583903,8.87184549 21.975,8.25 L20.205,5.25 C19.9373257,4.78637394 19.4428488,4.50054911 18.9075,4.5 C18.7444876,4.49875115 18.5823616,4.52408333 18.4275,4.575 L16.605,5.19 C16.290345,4.98090554 15.9621193,4.79299006 15.6225,4.6275 L15.24,2.7375 C15.0984473,2.02482634 14.466462,1.51607823 13.74,1.53 L10.23,1.53 C9.50353795,1.51607823 8.87155272,2.02482634 8.73,2.7375 L8.3475,4.6275 C8.00544981,4.79295003 7.67472681,4.98086083 7.3575,5.19 L5.5725,4.545 C5.41597285,4.50421768 5.25387973,4.48902145 5.0925,4.5 C4.55715121,4.50054911 4.06267425,4.78637394 3.795,5.25 L2.025,8.25 C1.66395036,8.87026017 1.79284818,9.65936637 2.3325,10.1325 L3.75,11.43 C3.75,11.6175 3.75,11.805 3.75,12 C3.75,12.195 3.75,12.3825 3.75,12.5775 L2.3325,13.8375 C1.77693801,14.3144933 1.64695921,15.122898 2.025,15.75 L3.795,18.75 C4.06267425,19.2136261 4.55715121,19.4994509 5.0925,19.5 C5.25551245,19.5012488 5.41763842,19.4759167 5.5725,19.425 L7.395,18.81 C7.70965497,19.0190945 8.03788067,19.2070099 8.3775,19.3725 L8.76,21.2625 C8.90155272,21.9751737 9.53353795,22.4839218 10.26,22.47 L13.8,22.47 C14.526462,22.4839218 15.1584473,21.9751737 15.3,21.2625 L15.6825,19.3725 C16.0245502,19.20705 16.3552732,19.0191392 16.6725,18.81 L18.4875,19.425 C18.6423616,19.4759167 18.8044876,19.5012488 18.9675,19.5 C19.5028488,19.4994509 19.9973257,19.2136261 20.265,18.75 L21.975,15.75 C22.3360496,15.1297398 22.2071518,14.3406336 21.6675,13.8675 L20.25,12.57 Z M18.9075,18 L16.335,17.13 C15.7327985,17.6400811 15.0445477,18.0388094 14.3025,18.3075 L13.77,21 L10.23,21 L9.6975,18.3375 C8.96131622,18.0611833 8.2767884,17.6631431 7.6725,17.16 L5.0925,18 L3.3225,15 L5.3625,13.2 C5.22382267,12.4236442 5.22382267,11.6288558 5.3625,10.8525 L3.3225,9 L5.0925,6 L7.665,6.87 C8.26720153,6.35991893 8.95545233,5.9611906 9.6975,5.6925 L10.23,3 L13.77,3 L14.3025,5.6625 C15.0386838,5.93881666 15.7232116,6.33685691 16.3275,6.84 L18.9075,6 L20.6775,9 L18.6375,10.8 C18.7761773,11.5763558 18.7761773,12.3711442 18.6375,13.1475 L20.6775,15 L18.9075,18 Z"
													id="Shape" fill="#49463D" fill-rule="nonzero"></path>
											<path class="prodigy-custom-fill"
													d="M12,16.5 C9.51471863,16.5 7.5,14.4852814 7.5,12 C7.5,9.51471863 9.51471863,7.5 12,7.5 C14.4852814,7.5 16.5,9.51471863 16.5,12 C16.5121548,13.197159 16.0419532,14.3488274 15.1953903,15.1953903 C14.3488274,16.0419532 13.197159,16.5121548 12,16.5 Z M12,9 C11.1987743,8.98133509 10.4248198,9.29140816 9.85811399,9.85811399 C9.29140816,10.4248198 8.98133509,11.1987743 9,12 C8.98133509,12.8012257 9.29140816,13.5751802 9.85811399,14.141886 C10.4248198,14.7085918 11.1987743,15.0186649 12,15 C12.8012257,15.0186649 13.5751802,14.7085918 14.141886,14.141886 C14.7085918,13.5751802 15.0186649,12.8012257 15,12 C15.0186649,11.1987743 14.7085918,10.4248198 14.141886,9.85811399 C13.5751802,9.29140816 12.8012257,8.98133509 12,9 Z"
													id="Shape" fill="#49463D" fill-rule="nonzero"></path>
											<rect id="_Transparent_Rectangle_" x="0" y="0" width="24"
													height="24"></rect>
										</g>
									</g>
								</g>
							</svg>
						</span>
							<p class="prodigy-account__menu-item-name"><?php esc_html_e( 'Settings', 'prodigy' ); ?></p>
						</a>
						<a href="#" class="prodigy-account__menu-item">
						<span class="d-flex flex-column align-items-center justify-content-center">
							<svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
								xmlns="http://www.w3.org/2000/svg">
								<g id="Selected" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
									<g id="Account-menu" transform="translate(-1392, -535)">
										<g id="logout" transform="translate(1392, 535)">
											<path class="prodigy-custom-fill"
													d="M4.5,22.5 L13.5,22.5 C14.3280331,22.4990494 14.9990494,21.8280331 15,21 L15,18.75 L13.5,18.75 L13.5,21 L4.5,21 L4.5,3 L13.5,3 L13.5,5.25 L15,5.25 L15,3 C14.9990494,2.17196695 14.3280331,1.5009506 13.5,1.5 L4.5,1.5 C3.67196695,1.5009506 3.0009506,2.17196695 3,3 L3,21 C3.0009506,21.8280331 3.67196695,22.4990494 4.5,22.5 Z"
													id="Path" fill="#49463D" fill-rule="nonzero"></path>
											<polygon class="prodigy-custom-fill" id="Path" fill="#49463D"
													fill-rule="nonzero"
													points="15.4395 15.4395 18.129 12.75 7.5 12.75 7.5 11.25 18.129 11.25 15.4395 8.5605 16.5 7.5 21 12 16.5 16.5"></polygon>
											<rect id="_Transparent_Rectangle_" x="0" y="0" width="24"
													height="24"></rect>
										</g>
									</g>
								</g>
							</svg>
						</span>
							<p class="prodigy-account__menu-item-name user-logout-js"><?php esc_html_e( 'Log Out', 'prodigy' ); ?></p>
						</a>
					</div>
					<div class="prodigy-account__menu-footer-user-info">
					<span class="prodigy-navbar-user prodigy-navbar-user--footer">
						<svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
							xmlns="http://www.w3.org/2000/svg"
						>
							<g id="Selected" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<g id="Account-menu" transform="translate(-1392, -97)">
									<g id="line-copy" transform="translate(1116, 97)">
										<g id="user--avatar-footer" transform="translate(276, 0)">
											<path class="prodigy-custom-fill"
													d="M12,6 C9.92893219,6 8.25,7.67893219 8.25,9.75 C8.25,11.8210678 9.92893219,13.5 12,13.5 C14.0710678,13.5 15.75,11.8210678 15.75,9.75 C15.75,8.75543816 15.3549118,7.80161099 14.6516504,7.09834957 C13.948389,6.39508815 12.9945618,6 12,6 Z M12,12 C10.7573593,12 9.75,10.9926407 9.75,9.75 C9.75,8.50735931 10.7573593,7.5 12,7.5 C13.2426407,7.5 14.25,8.50735931 14.25,9.75 C14.2485947,10.9920581 13.2420581,11.9985947 12,12 L12,12 Z"
													id="Shape" fill="#49463D" fill-rule="nonzero"></path>
											<path class="prodigy-custom-fill"
													d="M12,1.5 C6.20101013,1.5 1.5,6.20101013 1.5,12 C1.5,17.7989899 6.20101013,22.5 12,22.5 C17.7989899,22.5 22.5,17.7989899 22.5,12 C22.4934695,6.20371729 17.7962827,1.50653047 12,1.5 L12,1.5 Z M7.5,19.782375 L7.5,18.75 C7.50136403,17.5079248 8.50792475,16.501364 9.75,16.5 L14.25,16.5 C15.4920752,16.501364 16.498636,17.5079248 16.5,18.75 L16.5,19.782375 C13.7196463,21.4058762 10.2803537,21.4058762 7.5,19.782375 L7.5,19.782375 Z M17.994375,18.69435 C17.9633542,16.6475088 16.2970733,15.0034894 14.25,15 L9.75,15 C7.70292667,15.0034894 6.03664578,16.6475088 6.005625,18.69435 C3.22118315,16.2080675 2.26057568,12.2609961 3.59110359,8.77324428 C4.92163151,5.28549247 8.26707658,2.98111916 12,2.98111916 C15.7329234,2.98111916 19.0783685,5.28549247 20.4088964,8.77324428 C21.7394243,12.2609961 20.7788168,16.2080675 17.994375,18.69435 L17.994375,18.69435 Z"
													id="Shape" fill="#49463D" fill-rule="nonzero"></path>
											<rect id="_Transparent_Rectangle_" x="0" y="0" width="24"
													height="24"></rect>
										</g>
									</g>
								</g>
							</g>
						</svg>
					</span>
						<div class="prodigy-data-user">
							<p class="prodigy-data-user__name"><?php echo sanitize_text_field( wp_unslash( $_COOKIE[ User::USER_INFO_COOKIE_NAME ] ?? '' ) ); ?>
								&nbsp;<?php echo sanitize_text_field( wp_unslash( $_COOKIE[ User::USER_INFO_COOKIE_LAST_NAME ] ?? '' ) ); ?></p>
							<p class="prodigy-data-user__email"><?php echo sanitize_email( wp_unslash( $_COOKIE[ User::USER_INFO_COOKIE_EMAIL ] ?? '' ) ); ?></p>
						</div>
					</div>
				</div>
			</div>
			<div class="prodigy-account-right__slide-menu-backdrop"></div>
		</div>
	</li>
<?php endif; ?>
