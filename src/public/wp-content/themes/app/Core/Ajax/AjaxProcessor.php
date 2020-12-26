<?php

namespace Core\Ajax;

class AjaxProcessor
{
    public static function sendResponse(Response $response)
    {
        header('Content-Type: application/json');
        http_response_code($response->getStatusCode());

        $data = $response->getData();
        echo json_encode($data);

        die;
    }

    public static function registerAction(string $actionName, string $actionClass)
    {
        $function = function () use ($actionClass) {
            self::process($actionClass);
        };

        add_action('wp_ajax_' . $actionName, $function);
        add_action('wp_ajax_nopriv_' . $actionName, $function);
    }

    public static function process($jobClass)
    {
        ShutdownHandler::init();

        try {
            /** @var Action $class */
            $class = new $jobClass;

            if ($class instanceof Action == false) {
                throw new \Exception('Invalid action');
            }

            $validateError = $class->request()->validate();
            if (!empty($validateError)) {
                $response = new InvalidRequestResponse($validateError);
            } else {
                $response = $class->execute();

                if (!$response) {
                    $response = new SuccessResponse();
                }
            }
        } catch (\Exception $exception) {
            $response = new ServerErrorResponse($exception->getMessage());
        }

        self::sendResponse($response);
    }
}