<?php

namespace FTahir\ESQuery;

use FTahir\ESQuery\ParametersTrait;

interface QueryInterface {
	public function getType();
	public function getBuild();
}