<?php 


if ( ! function_exists('__'))
{
	/**
	 * Kohana translation/internationalization function. The PHP function
	 * [strtr](http://php.net/strtr) is used for replacing parameters.
	 *
	 *    __('Welcome back, :user', array(':user' => $username));
	 *
	 * [!!] The target language is defined by [I18n::$lang].
	 *
	 * @uses    I18n::get
	 * @param   string  $string text to translate
	 * @param   array   $values values to replace in the translated text
	 * @param   string  $lang   source language
	 * @return  string
	 */
	function __($string, array $values = NULL, $lang = 'en-us')
	{
		if ($lang !== \Kohana\I18n::$lang)
		{
			// The message and target languages are different
			// Get the translation for this message
			$string = \Kohana\I18n::get($string);
		}

		return empty($values) ? $string : strtr($string, $values);
	}
}
