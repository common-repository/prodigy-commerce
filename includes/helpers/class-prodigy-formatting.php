<?php

namespace Prodigy\Includes\Helpers;

/**
 * Prodigy Template Helper
 *
 * @version    3.0.2
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Formatting {

	/**
	 * @param float|null $price
	 *
	 * @return string
	 */
	public static function prodigy_price_format( $price ): string {
		return number_format( (float) $price, 2 );
	}

	/**
	 * Format content to display shortcodes.
	 *
	 * @param string $raw_string Raw string.
	 *
	 * @return string
	 */
	public static function prodigy_format_content( string $raw_string ): string {
		return apply_filters( 'prodigy_format_content', apply_filters( 'prodigy_short_description', $raw_string ), $raw_string );
	}


	/**
	 * Truncates text.
	 *
	 * Cuts a string to the length of $length and replaces the last characters
	 * with the ending if the text is longer than length.
	 *
	 * ### Options:
	 *
	 * - `ending` Will be used as Ending and appended to the trimmed string
	 * - `exact` If false, $text will not be cut mid-word
	 * - `html` If true, HTML tags would be handled correctly
	 *
	 * @param string  $text String to truncate.
	 * @param integer $length Length of returned string, including ellipsis.
	 * @param array   $options An array of html attributes and options.
	 *
	 * @return string Trimmed string.
	 * @access public
	 */
	public static function prodigy_truncate( string $text, $length = 100, $options = array() ): string {
		$default = array(
			'ending' => '...',
			'exact'  => true,
			'html'   => true,
		);
		$options = array_merge( $default, $options );
		extract( $options );
		/**
		 * @var bool $exact
		 * @var bool $html
		 * @var string $ending
		 */

		if ( $html ) {
			if ( mb_strlen( preg_replace( '/<.*?>/', '', $text ) ) <= $length ) {
				return $text;
			}
			$totalLength = mb_strlen( wp_strip_all_tags( (string) $ending ) );
			$openTags    = array();
			$truncate    = '';

			preg_match_all( '/(<\/?([\w+]+)[^>]*>)?([^<>]*)/', $text, $tags, PREG_SET_ORDER );
			foreach ( $tags as $tag ) {
				if ( ! preg_match( '/img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param/s', $tag[2] ) ) {
					if ( preg_match( '/<[\w]+[^>]*>/s', $tag[0] ) ) {
						array_unshift( $openTags, $tag[2] );
					} elseif ( preg_match( '/<\/([\w]+)[^>]*>/s', $tag[0], $closeTag ) ) {
						$pos = array_search( $closeTag[1], $openTags );
						if ( $pos !== false ) {
							array_splice( $openTags, $pos, 1 );
						}
					}
				}
				$truncate .= $tag[1];

				$contentLength = mb_strlen( preg_replace( '/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $tag[3] ) );
				if ( $contentLength + $totalLength > $length ) {
					$left           = $length - $totalLength;
					$entitiesLength = 0;
					if ( preg_match_all( '/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $tag[3], $entities, PREG_OFFSET_CAPTURE ) ) {
						foreach ( $entities[0] as $entity ) {
							if ( $entity[1] + 1 - $entitiesLength <= $left ) {
								--$left;
								$entitiesLength += mb_strlen( $entity[0] );
							} else {
								break;
							}
						}
					}

					$truncate .= mb_substr( $tag[3], 0, $left + $entitiesLength );
					break;
				} else {
					$truncate    .= $tag[3];
					$totalLength += $contentLength;
				}
				if ( $totalLength >= $length ) {
					break;
				}
			}
		} elseif ( mb_strlen( $text ) <= $length ) {
				return $text;
		} else {
			$truncate = mb_substr( $text, 0, $length - mb_strlen( $ending ) );
		}
		if ( ! $exact ) {
			$spacepos = mb_strrpos( $truncate, ' ' );
			if ( isset( $spacepos ) ) {
				if ( $html ) {
					$bits = mb_substr( $truncate, $spacepos );
					preg_match_all( '/<\/([a-z]+)>/', $bits, $droppedTags, PREG_SET_ORDER );
					if ( ! empty( $droppedTags ) ) {
						foreach ( $droppedTags as $closingTag ) {
							if ( ! in_array( $closingTag[1], $openTags ) ) {
								array_unshift( $openTags, $closingTag[1] );
							}
						}
					}
				}
				$truncate = mb_substr( $truncate, 0, $spacepos );
			}
		}
		$truncate .= $ending;

		if ( $html ) {
			foreach ( $openTags as $tag ) {
				$truncate .= '</' . $tag . '>';
			}
		}

		return $truncate;
	}

	/**
	 * The Function returns only the schema and host
	 *
	 * @param string $url
	 *
	 * @return bool|string
	 */
	public static function prodigy_format_site_url( string $url ) {
		if ( filter_var( $url, FILTER_VALIDATE_URL ) ) {
			$parse_url = wp_parse_url( $url );

			return $parse_url['scheme'] . '://' . $parse_url['host'];
		}

		return false;
	}


	/**
	 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
	 * Non-scalar values are ignored.
	 *
	 * @param string|array $data Data to sanitize.
	 * @param string       $type
	 *
	 * @return string|array
	 */
	public static function prodigy_sanitize_field( $data = '', $type = 'text' ): string {
		if ( is_array( $data ) ) {
			return array_map( 'prodigy_sanitize_field', $data, $type );
		}
		if ( ! is_scalar( $data ) ) {
			return $data;
		}
		switch ( $type ) {
			case 'textarea':
				$data = sanitize_textarea_field( $data );
				break;
			case 'email':
				$data = sanitize_email( $data );
				break;
			case 'color':
				$data = sanitize_hex_color( $data );
				break;
			default:
				$data = sanitize_text_field( $data );
				break;
		}

		return $data;
	}
}
