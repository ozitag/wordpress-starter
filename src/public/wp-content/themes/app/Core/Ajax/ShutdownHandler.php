<?php

namespace Core\Ajax;

class ShutdownHandler
{
    public static function init()
    {
        if (!defined('WP_ENV') || WP_ENV !== 'production') {

            // Cancel default WP shutdown function
            if (!defined('WP_SANDBOX_SCRAPING')) {
                define('WP_SANDBOX_SCRAPING', true);
            }

            register_shutdown_function([ShutdownHandler::class, 'handle']);
        }
    }

    public static function handle()
    {
        $error = error_get_last();
        if (!$error) {
            return;
        }

        $error_types_to_handle = array(
            E_ERROR,
            E_PARSE,
            E_USER_ERROR,
            E_COMPILE_ERROR,
            E_RECOVERABLE_ERROR,
        );

        if (!isset($error['type']) || !in_array($error['type'], $error_types_to_handle, true)) {
            return;
        }

        $stacktrace = null;
        $message = $error['message'];

        if (preg_match('/Uncaught Error: (.+?) in .+?Stack trace:(.+?)$/si', $message, $regexData)) {
            $message = $regexData[1];
            $stacktrace = $regexData[2];
        }

        if (!empty($stacktrace)) {
            if (preg_match_all('/#\d+\s(.+?)\n/si', $stacktrace, $stacktraceRegex)) {
                $stacktrace = [];
                foreach ($stacktraceRegex[1] as $ind => $item) {
                    if ($ind < count($stacktraceRegex[1]) - 2) {
                        $stacktrace[] = trim($item);
                    }
                }
            }
        }

        $response = new ServerErrorResponse('Server Error', [
            'message' => $message,
            'file' => $error['file'],
            'line' => $error['line'],
            'stacktrace' => $stacktrace
        ]);

        AjaxProcessor::sendResponse($response);
    }
}