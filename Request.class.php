<?php
class Request {

    private $get = [];
    private $post = [];
    private $server = [];
    private $cookie = [];
    private $file = [];
    private $header = [];
    private $content = [];

    protected function __construct($args = []) {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->server = $_SERVER;
        $this->cookie = $_COOKIE;
        $this->file = $_FILES;
        $this->header = apache_request_headers();
        $this->content = $this->getContent();
    }

    public function getQuery(string $var, $filter = null) {
        return $this->filter($this->get, $var, $filter);
    }

    public function getPost(string $var, $filter = null) {
        return $this->filter($this->post, $var, $filter);
    }

    public function getServer(string $var, $filter = null) {
        return $this->filter($this->server, $var, $filter);
    }

    public function getFile(string $var, $filter = null) {
        return $this->filter($this->file, $var, $filter);
    }

    public function getCookie(string $var, $filter = null) {
        return $this->filter($this->cookie, $var, $filter);
    }

    public function getHeader(string $var, $filter = null) {
        return $this->filter($this->header, $var, $filter);
    }

    public function getContent() {
        $file = fopen('php://input', 'r');
        $response = '';
        while ($data = fread($file, 1024)) {
            $response .= $data;
        }

        fclose($file);
        return $response;
    }

    public function getJson() {
        $json = json_decode($this->getContent(), true);
        return (json_last_error() == JSON_ERROR_NONE) ? $json : [];
    }

    public function getUri(): string {
        $self = $this->getServer('PHP_SELF'); //? str_replace('index.php/', '', $this->getServer('PHP_SELF')) : '';
        $uri = $this->getServer('REQUEST_URI') ? explode('?', $this->getServer('REQUEST_URI'))[0] : '';
        if ($self !== $uri) {
            $peaces = explode('/', $self);
            array_pop($peaces);
            $start = implode('/', $peaces);
            $search = '/' . preg_quote($start, '/') . '/';
            $uri = preg_replace($search, '', $uri, 1);
        }
        return $uri;
    }

    public function getMethod(): string {
        return $this->filter($this->server, 'REQUEST_METHOD');
    }

    public function isSecure(): bool {
        return (array_key_exists('HTTPS', $this->server) && $this->server['HTTPS'] !== 'off');
    }

    public function isXhr(): bool {
        return (array_key_exists('HTTP_X_REQUESTED_WITH', $this->server) && $this->server['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest');
    }

    protected function urlbuild() {
        return parse_url($this->getServer('REQUEST_SCHEME') . '://' . $this->getServer('SERVER_NAME') . $this->getServer('REQUEST_URI'));
    }

    private function filter(array $input, string $var, $filter = null) {
        $value = $input[$var] ?? false;
        if (!$filter) {
            return $value;
        }
        return filter_var($value, $filter);
    }

}
