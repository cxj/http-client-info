<?php
/**
 * Retrieve information about web browser (client).
 *
 * @package cxj/http-client-info
 * @author      Chris Johnson <cxjohnson@gmail.com>
 * @copyright   2016, Chris Johnson.
 * @license     MIT
 */

namespace Cxj\Http;

/**
 * Service for obtaining web client IP address, V4 or V6.
 */
class ClientInfo
{
    /**
     * Constructor.
     */
    public function __construct()
    {}

    /**
     * Attempts to return the IPv4 address of the client browser making
     * this request.
     *
     * @return mixed|string - the IPv4 address or false if unable to determine.
     */
    public function getIpV4Address()
    {
        $address = $this->extractAddress(FILTER_FLAG_IPV4);

        return $address;
    }

    /**
     * Attempts to return the IPv6 address of the client browser making
     * this request.
     *
     * @return bool|string - the IPv6 address or false if unable to determine.
     */
    public function getIpV6Address()
    {
        $address = $this->extractAddress(FILTER_FLAG_IPV6);

        return $address;
    }

    /**
     * @param $ipVersion
     *
     * @internal param array $headers
     * @return bool|mixed
     */
    protected function extractAddress($ipVersion)
    {
        $headers = $this->getHeaders();

        // Get forwarded address if it exists.  There are two possible headers
        // which may contain it, X-Forwarded-For or HTTP_X_FORWARDED_FOR.

        if (array_key_exists('X-Forwarded-For', $headers)
            && filter_var(
                $headers['X-Forwarded-For'],
                FILTER_VALIDATE_IP,
                $ipVersion
            )
        ) {
            $address = $headers['X-Forwarded-For'];
        }
        elseif (array_key_exists('HTTP_X_FORWARDED_FOR', $headers)
            && filter_var(
                $headers['HTTP_X_FORWARDED_FOR'],
                FILTER_VALIDATE_IP,
                $ipVersion
            )
        ) {
            $address = $headers['HTTP_X_FORWARDED_FOR'];
        }
        // No forwarded address found, it should be in REMOTE_ADDR.
        else {
            if (isset($_SERVER['REMOTE_ADDR'])) {
                $address = filter_var(
                    $_SERVER['REMOTE_ADDR'],
                    FILTER_VALIDATE_IP,
                    $ipVersion
                );
            }
            else {
                $address = false;
            }
        }

        return $address;
    }

    /**
     * @return array HTTP headers.
     */
    protected function getHeaders()
    {
        // Get headers if we can or else use the SERVER global.
        if (function_exists('apache_request_headers')) {
            $headers = apache_request_headers();
        }
        else {
            $headers = $_SERVER;
        }

        return $headers;
    }
}
