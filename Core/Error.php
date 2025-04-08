<?php

/**
 * Error and exception handler
 */

namespace Core;

class Error
{
    /**
     * Errors are turned into exceptions
     */
    public static function errorHandler(
        int $level, string $message, string $file, int $line
    ): void
    {
        if (error_reporting() !== 0) {
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
    }

    public static function exceptionHandler(\Exception $exception): void
    {
        // HTTP status codes are treated
        $code = $exception->getCode();
        if ($code !== 404) {
            $code = 500;
        }
        http_response_code($code);

        // Error information is formatted
        $exceptionClass = get_class($exception);
        $exceptionInfo =<<<EXCEPTION
            <section id="error">
                <p>Uncaught exception: $exceptionClass</p>
                <p>Message: {$exception->getMessage()}</p>
                <p>Stack trace: {$exception->getTraceAsString()}</p>
                <p>Thrown in: {$exception->getFile()} on line {$exception->getLine()}</p>
            </section>
        EXCEPTION;

        // The information is either shown or logged
        if (\App\Config::SHOW_ERRORS) {
            View::render("Errors/$code.php", [
                'pageTitle' => 'Error',
                'errorInfo' => $exceptionInfo
            ]);
        } else {
            $log = dirname(__DIR__) . '/logs/' . date('Y-m-d') . '.html';
            ini_set('error_log', $log);
            error_log("$exceptionInfo<hr>");

            View::render("Errors/$code.php", [
                'pageTitle' => 'Error'
            ]);
        }
    }
}