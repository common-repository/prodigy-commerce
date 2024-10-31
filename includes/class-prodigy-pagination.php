<?php

namespace Prodigy\Includes;

use Prodigy\Includes\Helpers\Prodigy_Template;

defined( 'ABSPATH' ) || exit;

/**
 * Class Prodigy_Pagination
 */
class Prodigy_Pagination {

	/**
	 * @param int $number
	 * @param int $number_per_page
	 *
	 * @return false|float
	 */
	public static function calculate_count_pages( int $number, int $number_per_page ) {
		if ( ! empty( $number_per_page ) ) {
			return ceil( $number / $number_per_page );
		}
	}

	/**
	 * @param array $data
	 * @param int   $pages_number
	 * @param int   $range
	 *
	 * @return void
	 */
	public static function prodigy_pagination( array $data, int $pages_number = 1, int $range = 4 ) {
		if ( ! empty( $pages_number ) ) {
			$showitems = ( $range * 2 ) + 1;
			if ( isset( $pages_number, $data['page_number'] ) && 1 != $pages_number ) {
				if ( (int) $data['page_number'] > 2 && (int) $data['page_number'] > $range + 1 && $showitems < $pages_number ) {
					$first = self::get_url_for_page( 1 );
					echo wp_kses_post(
						sprintf(
							'<a aria-label="%1$s" class="prodigy-pagination__nav" href="%2$s">&laquo;</a>',
							__( 'First', 'prodigy' ),
							esc_attr( $first )
						)
					);
				}

				if ( $data['page_number'] > 1 && $showitems < $pages_number ) {
					$prev = self::get_url_for_page( (int) $data['page_number'] - 1 );
					echo wp_kses_post(
						sprintf(
							'<a aria-label="%1$s" class="prodigy-pagination__nav prodigy-pagination__nav-prev" href="%2$s">&lsaquo;</a>',
							__( 'Previous', 'prodigy' ),
							esc_attr( $prev )
						)
					);
				}

				$max_range = (int) $data['page_number'] + $range + 1;
				$min_range = (int) $data['page_number'] - $range - 1;
				for ( $i = 1; $i <= $pages_number; $i++ ) {
					if ( 1 !== $pages_number && ( ! ( $i >= $max_range || $i <= $min_range ) || $pages_number <= $showitems ) ) {
						$url = self::get_url_for_page( $i );
						if ( (int) $data['page_number'] === $i ) {
							echo wp_kses_post(
								sprintf(
									'<span class="prodigy-pagination__item prodigy-pagination__item--active">%1$s</span>',
									esc_attr( $i )
								)
							);
						} else {
							echo wp_kses_post(
								sprintf(
									'<a class="prodigy-pagination__item" href="%1$s">%2$s</a>',
									esc_attr( $url ),
									esc_attr( $i )
								)
							);
						}
					}
				}

				if ( $data['page_number'] < $pages_number && $showitems < $pages_number ) {
					$next = self::get_url_for_page( (int) $data['page_number'] + 1 );
					echo wp_kses_post(
						sprintf(
							'<a aria-label="%1$s" class="prodigy-pagination__nav prodigy-pagination__nav-next" href="%2$s">&rsaquo;</a>',
							__( 'Next', 'prodigy' ),
							esc_attr( $next )
						)
					);
				}

				if ( $data['page_number'] < $pages_number - 1 && (int) $data['page_number'] + $range - 1 < $pages_number && $showitems < $pages_number ) {
					$last = self::get_url_for_page( $data['pages'] );
					echo wp_kses_post(
						sprintf(
							'<a aria-label="%1$s" class="prodigy-pagination__nav" href="%2$s">&raquo;</a>',
							__( 'Last', 'prodigy' ),
							esc_attr( $last )
						)
					);
				}

				echo "</div>\n";
			}
		}
	}

	/**
	 * Get current page number.
	 *
	 * @param array $query
	 *
	 * @return int
	 */
	public static function get_current_page( array $query ): int {
		$page = 1;
		if ( isset( $query['pg'] ) ) {
			parse_str( $query['pg'], $array );
			foreach ( $array as $key => $param ) {
				if ( $key === 'pg' ) {
					$page = $param;
				}
			}
		}

		return (int) $page;
	}

	/**
	 * @param int $page
	 *
	 * @return string
	 */
	private static function get_url_for_page( int $page ): string {

		if ( wp_doing_ajax() && is_admin() ) {
			$current_url = isset( $_SERVER['HTTP_REFERER'] ) ? sanitize_url( wp_unslash( $_SERVER['HTTP_REFERER'] ) ) : '';
			return add_query_arg(
				array(
					'pg' => $page,
				),
				$current_url
			);
		}

		if ( wp_doing_ajax() ) {
			$current_url = isset( $_GET['current_url'] ) ? sanitize_url( wp_unslash( $_GET['current_url'] ) ) : '';
		} else {
			$current_url = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_url( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
		}

		if ( $page <= 1 ) {
			return remove_query_arg( array( 'pg', 'another_param' ), $current_url );
		}

		$query = add_query_arg(
			array(
				'pg'   => $page,
				'sort' => $_GET['sort'] ?? '',
			),
			wp_parse_url( $current_url, PHP_URL_QUERY )
		);

		if ( ! empty( $query ) && strpos( $query, '?' ) !== 0 ) {
			return '?' . $query;
		}

		return $query;
	}
}
