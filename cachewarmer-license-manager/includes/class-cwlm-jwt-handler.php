<?php
/**
 * JWT Token Management.
 *
 * @package CacheWarmer_License_Manager
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CWLM_JWT_Handler {

    private string $secret;
    private int $expiry_days;

    public function __construct() {
        $this->secret      = defined( 'CWLM_JWT_SECRET' ) ? CWLM_JWT_SECRET : '';
        $this->expiry_days = defined( 'CWLM_JWT_EXPIRY_DAYS' ) ? (int) CWLM_JWT_EXPIRY_DAYS : 30;
    }

    /**
     * JWT Token generieren.
     *
     * @param array<string, mixed> $payload Payload-Daten.
     */
    public function generate( array $payload ): string {
        $header = $this->base64url_encode( wp_json_encode( [
            'alg' => 'HS256',
            'typ' => 'JWT',
        ] ) );

        $payload['iat'] = time();
        $payload['exp'] = time() + ( $this->expiry_days * 86400 );

        $payload_encoded = $this->base64url_encode( wp_json_encode( $payload ) );

        $signature = $this->base64url_encode(
            hash_hmac( 'sha256', "{$header}.{$payload_encoded}", $this->secret, true )
        );

        return "{$header}.{$payload_encoded}.{$signature}";
    }

    /**
     * JWT Token validieren und Payload zurückgeben.
     *
     * @return array<string, mixed>|false
     */
    public function validate( string $token ): array|false {
        $parts = explode( '.', $token );
        if ( count( $parts ) !== 3 ) {
            return false;
        }

        [ $header, $payload, $signature ] = $parts;

        $expected_sig = $this->base64url_encode(
            hash_hmac( 'sha256', "{$header}.{$payload}", $this->secret, true )
        );

        if ( ! hash_equals( $expected_sig, $signature ) ) {
            return false;
        }

        $payload_data = json_decode( $this->base64url_decode( $payload ), true );

        if ( ! $payload_data || ! isset( $payload_data['exp'] ) ) {
            return false;
        }

        if ( $payload_data['exp'] < time() ) {
            return false;
        }

        return $payload_data;
    }

    /**
     * Token-Ablaufdatum zurückgeben.
     */
    public function get_expiry_date(): string {
        return gmdate( 'Y-m-d\TH:i:s\Z', time() + ( $this->expiry_days * 86400 ) );
    }

    private function base64url_encode( string $data ): string {
        return rtrim( strtr( base64_encode( $data ), '+/', '-_' ), '=' );
    }

    private function base64url_decode( string $data ): string {
        return base64_decode( strtr( $data, '-_', '+/' ) );
    }
}
