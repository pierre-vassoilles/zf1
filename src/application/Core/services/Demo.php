<?php
class Core_Service_Demo
{
	/**
	 * Returns "Hello" with the input string
	 * @param string $string
	 * @return string
	 */
	public function test($string)
	{
		return "Hello " . $string . " !";
	}
	
	/**
	 * Calculator - Add two ints
	 * @param integer $a
	 * @param integer $b
	 * @return integer
	 */
	public function calc($a, $b)
	{
		return (int)$a+(int)$b;
	}
	
}
