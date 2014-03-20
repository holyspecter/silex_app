<?php

class PostsTest extends \PHPUnit_Framework_TestCase
{
	public function testValidate()
	{
		$post = new Posts();
		$this->assertFalse($post->validate);

		return $post;
	}
}