<?php
namespace Lambda\Request;



class Request{
    protected $request;

    public function __construct()
    {
        $this->request = \Config\Services::request();
    }

    /**
     * @return RequestInterface
     */
    public function input()
    {
        $input = $this->request->getGetPost();
        if (empty($input)) {
            //convert request body to associative array
            $input = json_decode($this->request->getBody(), true);
        }
        return $input;
    }

    public function getFile($name)
    {
        $file = $this->request->getFile($name);

        return $file;
    }

}


