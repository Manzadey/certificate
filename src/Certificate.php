<?php

namespace Manzadey\Certificate;

use DateTime;

class Certificate
{
    /**
     * @var string
     */
    protected $url;
    /**
     * @var array
     */
    protected $context = [
        'ssl' => [
            'capture_peer_cert' => true
        ]
    ];
    /**
     * @var string
     */
    protected $errors = '';
    /**
     * @var string
     */
    protected $info = '';

    /**
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $this->generateUrl($url);
        $this->setup();
    }

    /**
     * @param string $url
     *
     * @return string
     */
    private function generateUrl(string $url) : string
    {
        return "ssl://{$url}:443";
    }

    private function setup() : void
    {
        $context = stream_context_create($this->context);
        $fp      = stream_socket_client($this->url, $this->errors, $err_str, 30, STREAM_CLIENT_CONNECT, $context);
        $cert    = stream_context_get_params($fp);

        if (empty($err_no) || !empty($cert['options'])) {
            $this->info = openssl_x509_parse($cert['options']['ssl']['peer_certificate']);
        } else {
            throw new \Exception('Error');
        }
    }

    /**
     * @return bool
     */
    private function emptyErrors() : bool
    {
        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function domain() : string
    {
        return $this->all()['subject']['CN'];
    }

    /**
     * @return string
     */
    public function validFrom() : string
    {
        return date('d.m.Y H:i:s', $this->all()['validFrom_time_t']);
    }

    /**
     * @return string
     */
    public function validTo() : string
    {
        return date('d.m.Y H:i:s', $this->all()['validTo_time_t']);
    }

    /**
     * @return string
     */
    public function experationDate() : string
    {
        return (new DateTime($this->validFrom()))->diff(new DateTime($this->validTo()))->format('%r%a');
    }

    /**
     * @return string
     */
    public function expiresDate() : string
    {
        return (new DateTime)->diff(new DateTime($this->validTo()))->format('%r%a');
    }

    /**
     * @return string
     */
    public function issuer() : string
    {
        return $this->all()['issuer']['O'];
    }

    /**
     * @return string
     */
    public function all() : array
    {
        return $this->info;
    }
}