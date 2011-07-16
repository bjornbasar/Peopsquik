<?php 
class Core_Handler
{
	/**
	 * The Exception handler
	 *
	 * @param Exception $e
	 */
	public static function exceptionHandler($exception)
	{
		$errorMessage = $exception->getMessage() . "<br/>\nfile: " . $exception->getFile() . "<br/>\nline: " . $exception->getLine();
		//error_log(strip_tags(date('[Y-m-d H:i:s]') . "\n" . $errorMessage) . "\n\n", 3, APP_LOG . 'exceptions-' . date('Ymd'));
		exit($errorMessage);
	}

	/**
	 * The Error Handler
	 *
	 * @param int $errorNo
	 * @param string $errorStr
	 * @param string $errorFile
	 * @param int $errorLine
	 * @return boolean
	 */
	public static function errorHandler($errorNo, $errorStr, $errorFile, $errorLine)
	{
		switch ($errorNo)
		{
			case E_USER_WARNING:
			case E_WARNING:
				$errorMessage = "<b>WARNING</b> [$errorNo]<br/>\n<i>$errorStr</i><br />\n";
				$errorMessage .= "Code is on line $errorLine in file $errorFile";
				$die = false;
				//error_log(strip_tags(date('[Y-m-d H:i:s]') . "\n" . $errorMessage) . "\n\n", 3, APP_LOG . 'errors-' . date('Ymd'));
				break;

			case E_USER_NOTICE:
			case E_NOTICE:
				$errorMessage = "<b>NOTICE</b> [$errorNo]<br/>\n<i>$errorStr</i><br />\n";
				$errorMessage .= "Code is on line $errorLine in file $errorFile";
				$die = false;
				break;

			default:
				$errorMessage = "<b>ERROR $errorNo</b><br/>\n<i>$errorStr</i><br/>\n";
				$errorMessage .= "Code is on line $errorLine in file $errorFile";
				$die = true;
				//error_log(strip_tags(date('[Y-m-d H:i:s]') . "\n" . $errorMessage) . "\n\n", 3, APP_LOG . 'errors-' . date('Ymd'));
				break;
		}

		if ($die)
		{
			echo $errorMessage;
			echo '<br/>';
			//            $trace = debug_backtrace();
			//	        echo '<pre>'; debug_print_backtrace(); echo '</pre>';
			array_walk(debug_backtrace(), 'Core_Helper::prettyBacktrace', count(debug_backtrace()));
			exit;
		}


		// Don't execute PHP internal error handler
		return true;
	}
}