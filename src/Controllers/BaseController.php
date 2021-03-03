<?php

namespace Lambda\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\Validation\Exceptions\ValidationException;
use Config\Services;
use Lambda\Config\Lambda;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class BaseController extends Controller
{
    public $db;
    public $lambda;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        helper("lambda");
        $this->lambda = new Lambda();

        $this->lambda->schema_load_mode = lambda("schema_load_mode");
        $this->lambda->theme = lambda("theme");
        $this->lambda->domain = lambda("domain");
        $this->lambda->title = lambda("title");
        $this->lambda->subTitle = lambda("subTitle");
        $this->lambda->copyright = lambda("copyright");
        $this->lambda->favicon = lambda("favicon");
        $this->lambda->bg = lambda("bg");
        $this->lambda->logo = lambda("logo");
        $this->lambda->logoText = lambda("logoText");
        $this->lambda->super_url = lambda("super_url");
        $this->lambda->app_url = lambda("app_url");
        $this->lambda->has_language = lambda("has_language");
        $this->lambda->withCrudLog = lambda("withCrudLog");
        $this->lambda->languages = lambda("languages");
        $this->lambda->controlPanel = lambda("controlPanel");
        $this->lambda->default_language = lambda("default_language");
        $this->lambda->role_redirects = lambda("role-redirects");
        $this->lambda->user_data_fields = lambda("user_data_fields");
        $this->lambda->data_form_custom_elements = lambda("data_form_custom_elements");
        $this->lambda->password_reset_time_out = lambda("password_reset_time_out");
        $this->lambda->static_words = lambda("static_words");
        $this->lambda->notify = lambda("notify");
    }

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [
        "mix",
        "lambda",
        "static_words",
        "jwt",

    ];

    /**
     * Constructor.
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param LoggerInterface $logger
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------
        // E.g.: $this->session = \Config\Services::session();
    }

    public function getResponse(array $responseBody, int $code = ResponseInterface::HTTP_OK)
    {
        return $this
            ->response
            ->setStatusCode($code)
            ->setJSON($responseBody);
    }

    public function res($responseBody)
    {
        if(is_array($responseBody)) {
            return $this
                ->response
                ->setStatusCode(ResponseInterface::HTTP_OK)
                ->setJSON($responseBody);
        } else {
            return $this
                ->response
                ->setStatusCode(ResponseInterface::HTTP_OK)
                ->setBody($responseBody);
        }

    }


    public function err(array $responseBody)
    {
        return $this
            ->response
            ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
            ->setJSON($responseBody);
    }

    public function getRequestInput(IncomingRequest $request){
        $input = $request->getPost();
        if (empty($input)) {
            //convert request body to associative array
            $input = json_decode($request->getBody(), true);
        }
        return $input;
    }

    public function validateRequest($input, array $rules, array $messages = [])
    {
        $this->validator = Services::Validation()->setRules($rules);
        // If you replace the $rules array with the name of the group
        if (is_string($rules)) {
            $validation = config('Validation');

            // If the rule wasn't found in the \Config\Validation, we
            // should throw an exception so the developer can find it.
            if (!isset($validation->$rules)) {
                throw ValidationException::forRuleNotFound($rules);
            }

            // If no error message is defined, use the error message in the Config\Validation file
            if (!$messages) {
                $errorName = $rules . '_errors';
                $messages = $validation->$errorName ?? [];
            }

            $rules = $validation->$rules;
        }
        return $this->validator->setRules($rules, $messages)->run($input);
    }
}
