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
class ErrorHandler implements ErrorHandlerInterface
{
	/**
	 * @var PhpErrorHandlerInterface
	 */
	protected $handler;

	/**
	 * @var array
	 */
	protected $stack = [];

	/**
	 * @var ErrorInterface
	 */
	protected $error;

	/**
	 * @param int $levels
	 * @param bool $register
	 */
	public function __construct(int $levels = E_ALL, bool $register = true){
		$this->handler = new PhpErrorHandler(function(ErrorInterface $e){
			$this->error = $this->stack[] = $e;
		}, $levels, $register);
	}

	/**
	 * @return bool
	 */
	public function isError(): bool{
		return $this->error !== null;
	}

	/**
	 * @return ErrorInterface
	 */
	public function getError(): ?ErrorInterface{
		return $this->error;
	}

	/**
	 * @return array
	 */
	public function getStack(): array{
		return $this->stack;
	}

	/**
	 * @return int
	 */
	public function getLevels(): int{
		return $this->handler->getLevels();
	}

	/**
	 * @return bool
	 */
	public function isRegistered(): bool{
		return $this->handler->isRegistered();
	}

	/**
	 * @return bool
	 */
	public function register(): bool{
		return $this->handler->register();
	}

	/**
	 * @return bool
	 */
	public function restore(): bool{
		return $this->handler->restore();
	}
}