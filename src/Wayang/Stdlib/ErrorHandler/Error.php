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

use Wayang;

/**
 */
class Error extends Wayang\Error\Error implements ErrorInterface
{
	/**
	 * @param int $code
	 * @param string $message
	 * @param string $file
	 * @param int $line
	 * @param ErrorInterface|null $previous
	 */
	public function __construct(int $code, string $message, string $file, int $line, ErrorInterface $previous = null){
		parent::__construct($message, $code, $previous);
		$this->file = $file;
		$this->line = $line;
	}
}