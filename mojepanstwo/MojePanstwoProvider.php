<?php

namespace daweb\mojepanstwo;

/**
 * Service https://api.mojepanstwo.pl 
 * 
 * Description API https://mojepanstwo.pl/api/technical_info
 * 
 * @author Dawid Bednarz <dawid@daweb.vdl.pl>
 * @copyright (c) Jun 9, 2015, Dawid Bednarz <dawid@daweb.vdl.pl>
 * @license BSD-3-Clause
 */
class MojePanstwoProvider extends MojePanstwoAPI {

    /**
     * conditions query string
     * @var array 
     */
    public $query;

    /**
     * route to special api
     * @var string
     */
    protected $route;

    /**
     * response code with result curl
     * @var integer
     */
    public $responseCode = NULL;

    /**
     * result of curl execute
     * @var string 
     */
    protected $output;

    /**
     * add query array conditions for request
     * @param array $conditions assoc array with conditions
     * @return MojePanstwoProvider
     */
    public function conditions($conditions) {

        $this->addQueryString('conditions', $conditions);

        return $this;
    }

    /**
     * add query arrafields
     * @return MojePanstwoProvider
     */
    public function fields($fields) {

        $this->addQueryString('fields', $fields);

        return $this;
    }

    /**
     * add query string full text search fields for request
     * @param string $q value of condition
     * @return MojePanstwoProvider
     */
    public function fullSearchText($q) {

        $this->addQueryString("q", $q);

        return $this;
    }

    /**
     * add query string order for request
     * @param string $order
     */
    public function order($order) {

        $this->addQueryString("order", $order);

        return $this;
    }

    /**
     * add query string offset for request
     * @param integer $offset
     * @return MojePanstwoProvider
     */
    public function offset($offset) {

        $this->addQueryString("offset", $offset);

        return $this;
    }

    /**
     * add query string limit for request
     * @param integer $limit
     * @return MojePanstwoProvider
     */
    public function limit($limit) {

        $this->addQueryString("limit", $limit);

        return $this;
    }

    /**
     * add query string page for request
     * @param integer $page
     * @return MojePanstwoProvider
     */
    public function page($page) {

        $this->addQueryString("page", $page);

        return $this;
    }

    /**
     * set route api and return new object 
     * @param integer $num
     * @return MojePanstwoProvider
     * @throws MojePanstwoProviderException
     */
    public function search($num) {

        $that = new $this;

        $route = $that->getRoute($num);

        if (is_null($route)) {
            throw new MojePanstwoProviderException('Nieprawidłowa ścieżka api');
        }
        $that->route = $route;

        return $that;
    }

    /**
     * add single query
     * @param string $name
     * @param string | array $value
     */
    protected function addQueryString($name, $value) {

        $this->query[$name] = $value;
    }

    protected function createUrl() {

        return self::APIUrl . $this->route . '?' . http_build_query($this->query);
    }

    /**
     * execute curl request to api 
     * @return boolean
     */
    public function getResult() {

        $curl = curl_init();
        $cookie = tempnam("/tmp", "CURLCOOKIE");
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_URL => $this->createUrl(),
            CURLOPT_TIMEOUT => 30,
            CURLOPT_COOKIEJAR => $cookie,
            CURLOPT_USERAGENT => $_SERVER['HTTP_USER_AGENT'],
            CURLOPT_HTTPHEADER => ['Accept: application/json']
        ));

        $this->output = curl_exec($curl);

        $this->responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if (is_null($this->output))
            return false;
        return true;
    }

    /**
     * output curl
     * @return string
     */
    public function toJSON() {
            return $this->output;
    }

    /**
     * convert output curl to object 
     * @return stdClass
     */
    public function toObject() {
        if (!is_null($this->output))
            return json_decode($this->output);
        return null;
    }

    /**
     * convert output curl to array
     * @return array
     */
    public function toArray() {
        if (!is_null($this->output))
            return json_decode($this->output, true);
        return null;
    }

}

class MojePanstwoProviderException extends \Exception {
    
}
