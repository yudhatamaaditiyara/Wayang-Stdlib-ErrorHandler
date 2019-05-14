<?php
/**
 * Copyright (C) 2019 Yudha Tama Aditiyara
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
namespace Wayang\Stdlib\ErrorHandler;

/**
 */
class PhpErrorHandler implements PhpErrorHandlerInterface
{
	/**
	 * @var int
	 */
	protected $levels;

	/**
	 * @var callable
	 */
	protected $callback;

	/**
	 * @var bool
	 */
	protected $isRegistered = false;

	/**
	 * @param callable $callback
	 * @param int $levels
	 * @param bool $register
	 */
	public function __construct(callable $callback, int $levels = E_ALL, bool $register = true) {
		$this->callback = $callback;
		$this->levels = $levels;
		if ($register) {
			$this->register();
		}
	}

	/**
	 * @return int
	 */
	public function getLevels(): int{
		return $this->levels;
	}

	/**
	 * @return callable
	 */
	public function getCallback(): callable{
		return $this->callback;
	}

	/**
	 * @return bool
	 */
	public function isRegistered(): bool{
		return $this->isRegistered;
	}

	/**
	 * @return bool
	 */
	public function register(): bool{
		if ($this->isRegistered) {
			return false;
		}
		$error = null;
		$handle = function(int $severity, string $message, string $file, int $line)use(&$error){
			call_user_func($this->callback, $error = new ErrorException($severity, $message, $file, $line, $error));
		};
		set_error_handler($handle, $this->levels);
		$this->isRegistered = true;
		return true;
	}

	/**
	 * @return bool
	 */
	public function restore(): bool{
		if (!$this->isRegistered) {
			return false;
		}
		restore_error_handler();
		$this->isRegistered = false;
		return true;
	}
}