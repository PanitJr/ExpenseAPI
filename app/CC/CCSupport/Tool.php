<?php

namespace App\CC\CCSupport;

interface Tool
{
	public function input($array);
	public function make();
	public function remove();
}