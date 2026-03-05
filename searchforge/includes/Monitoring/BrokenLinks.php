<?php

namespace SearchForge\Monitoring;

use SearchForge\Admin\Settings;

defined( 'ABSPATH' ) || exit;

class BrokenLinks {

	/**
	 * Scan tracked pages for broken outbound links.
	 *
	 * @param int $max_pages Maximum pages to scan per run.
	 * @return array List of broken links found.
	 */
	public static function scan( int $max_pages = 20 ): array {
		global $wpdb;

		$pages = $wpdb->get_col(
			$wpdb->prepare(
				"SELECT DISTINCT page_path FROM {$wpdb->prefix}sf_snapshots
				WHERE source = 'gsc' AND snapshot_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
				ORDER BY page_path ASC
				LIMIT %d",
				$max_pages
			)
		);

		if ( empty( $pages ) ) {
			return [];
		}

		$site_url = untrailingslashit( home_url() );
		$broken   = [];

		foreach ( $pages as $page_path ) {
			$url      = $site_url . $page_path;
			$response = wp_remote_get( $url, [
				'timeout'    => 15,
				'user-agent' => 'SearchForge/' . SEARCHFORGE_VERSION,
				'sslverify'  => false,
			] );

			if ( is_wp_error( $response ) ) {
				continue;
			}

			$status_code = wp_remote_retrieve_response_code( $response );
			if ( $status_code >= 400 ) {
				$broken[] = [
					'page_path'   => $page_path,
					'url'         => $url,
					'status_code' => $status_code,
					'type'        => 'page',
				];
				continue;
			}

			$body = wp_remote_retrieve_body( $response );
			$links = self::extract_links( $body, $site_url );

			foreach ( $links as $link ) {
				$link_response = wp_remote_head( $link, [
					'timeout'     => 10,
					'redirection' => 3,
					'user-agent'  => 'SearchForge/' . SEARCHFORGE_VERSION,
					'sslverify'   => false,
				] );

				if ( is_wp_error( $link_response ) ) {
					$broken[] = [
						'page_path'   => $page_path,
						'url'         => $link,
						'status_code' => 0,
						'type'        => 'outbound',
						'error'       => $link_response->get_error_message(),
					];
					continue;
				}

				$link_status = wp_remote_retrieve_response_code( $link_response );
				if ( $link_status >= 400 ) {
					$broken[] = [
						'page_path'   => $page_path,
						'url'         => $link,
						'status_code' => $link_status,
						'type'        => 'outbound',
					];
				}
			}
		}

		if ( ! empty( $broken ) ) {
			self::store_results( $broken );
		}

		return $broken;
	}

	/**
	 * Extract outbound links from HTML content.
	 */
	private static function extract_links( string $html, string $site_url ): array {
		$links = [];

		if ( ! preg_match_all( '/<a\s[^>]*href=["\']([^"\'#]+)["\'][^>]*>/i', $html, $matches ) ) {
			return $links;
		}

		$seen = [];
		foreach ( $matches[1] as $href ) {
			$href = html_entity_decode( $href );

			// Skip anchors, mailto, tel, javascript.
			if ( preg_match( '/^(mailto:|tel:|javascript:)/i', $href ) ) {
				continue;
			}

			// Make relative URLs absolute.
			if ( str_starts_with( $href, '/' ) ) {
				$href = $site_url . $href;
			}

			// Only check HTTP(S) URLs.
			if ( ! str_starts_with( $href, 'http' ) ) {
				continue;
			}

			// Deduplicate.
			if ( isset( $seen[ $href ] ) ) {
				continue;
			}
			$seen[ $href ] = true;

			$links[] = $href;

			// Limit per page.
			if ( count( $links ) >= 50 ) {
				break;
			}
		}

		return $links;
	}

	/**
	 * Store broken link results as alerts.
	 */
	private static function store_results( array $broken ): void {
		global $wpdb;

		$wpdb->insert( "{$wpdb->prefix}sf_alerts", [
			'alert_type' => 'broken_links',
			'title'      => sprintf(
				__( '%d broken link(s) detected', 'searchforge' ),
				count( $broken )
			),
			'severity'   => count( $broken ) > 5 ? 'high' : 'medium',
			'data'       => wp_json_encode( $broken ),
			'created_at' => current_time( 'mysql', true ),
			'is_read'    => 0,
		] );
	}

	/**
	 * Get most recent broken link scan results.
	 */
	public static function get_latest(): array {
		global $wpdb;

		$result = $wpdb->get_row(
			"SELECT data, created_at FROM {$wpdb->prefix}sf_alerts
			WHERE alert_type = 'broken_links'
			ORDER BY created_at DESC LIMIT 1",
			ARRAY_A
		);

		if ( ! $result || empty( $result['data'] ) ) {
			return [];
		}

		return json_decode( $result['data'], true ) ?: [];
	}
}
