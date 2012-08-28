<?php
	/**
	 *  IAM_BabelFish_Translate A class for translating text and URLs using Yahoo's BabelFish translation service
	 *  @desc IAM_BabelFish_Translate A class for translating text and URLs using Yahoo's BabelFish translation service
	 *  @package IAM_BabelFish_Translate
	 *  @author  Iván Ariel Melgrati <imelgrat@gmail.com>
	 *  @version 1.0
	 *  @copyright 2008
	 *
	 *  Requires PHP v 4.0+ with the cURL extension loaded
	 *
	 *  This library is free software; you can redistribute it and/or
	 *  modify it under the terms of the GNU Lesser General Public
	 *  License as published by the Free Software Foundation; either
	 *  version 2 of the License, or (at your option) any later version.
	 *
	 *  This library is distributed in the hope that it will be useful,
	 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
	 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
	 *  Lesser General Public License for more details.
	 */

	/**
	 * IAM_BabelFish_Translate
	 * 
	 * @package IAM_BabelFish_Translate
	 * @author Ivan Melgrati
	 * @copyright 2008
	 * @version 1.0
	 * @access public
	 */
	class IAM_BabelFish_Translate
	{
		/**
		* @var string $text Holds the text to translate
		* @access private
		*/		
		var $text = "";

		/**
		* @var string $sourceLang Translation source Language
		* @access private
		*/
		var $sourceLang = "en";

		/**
		* @var string $sourceLang Translation destination Language
		* @access private
		*/		
		var $destLang = "es";
		
		/**
		* @var string $url The URL to be translated
		* @access private
		*/		
		var $url = "";
		
		/**
		* @var array $allowed_lang_pairs List of all allows translation language pairs.
		* @access private
		*/	
		var $allowed_lang_pairs = array ("en_nl", "en_fr", "en_de", "en_it", "en_pt", "en_es", "nl_en", "nl_fr", "fr_nl", "fr_en", "fr_de", "fr_it", "fr_pt", "fr_es", 
		"de_en", "de_fr", "el_en","it_en", "it_fr", "pt_en", "pt_fr", "es_en", "es_fr");

		/**
		* Class Constructor 
		* @access public
		* @param String $source Translation Source Language
		* @param String $destination Translation Destination Language
		*/
		function IAM_BabelFish_Translate( $source = 'en', $destination = 'es' )
		{
			$this->setSourceLanguage( $source );
			$this->setDestinationLanguage( $destination );
			
			if ( !function_exists('http_build_query') )
			{
				function http_build_query( $data, $prefix = null, $sep = '', $key = '' )
				{
					$ret = array();
					foreach ( (array )$data as $k => $v )
					{
						$k = urlencode( $k );
						if ( is_int($k) && $prefix != null )
						{
							$k = $prefix . $k;
						}
						if ( !empty($key) )
						{
							$k = $key . "[" . $k . "]";
						}
		
						if ( is_array($v) || is_object($v) )
						{
							array_push( $ret, http_build_query($v, "", $sep, $k) );
						}
						else
						{
							array_push( $ret, $k . "=" . urlencode($v) );
						}
					}
					if ( empty($sep) )
					{
						$sep = ini_get( "arg_separator.output" );
					}
					return implode( $sep, $ret );
				}
			}			
		}

		/**
		* Get the Current translation source language
		* @access public
		* @return String Current translation source language
		*/
		function getSourceLanguage()
		{
			return $this->sourceLang;
		}

		/**
		* Set the Current translation source language
		* @access public
		* @param String $source Translation source language
		*/
		function setSourceLanguage( $source )
		{
			$this->sourceLang = $source;
		}

		/**
		* Get the Current translation destination language
		* @access public
		* @return String Current translation destination language
		*/
		function getDestinationLanguage()
		{
			return $this->destLang;
		}

		/**
		* Set the Current translation destination language
		* @access public
		* @param String $destination Translation destination language
		*/
		// Sets the to language in case you want to modify it along the way
		function setDestinationLanguage( $destination )
		{
			$this->destLang = $destination;
		}

		/**
		* Get Current text to be translated
		* @access public
		* @return String Current text to be translated
		*/		
		function getText()
		{
			return $this->text;
		}
		/**
		* Set text to be translated
		* @access public
		* @param String $text text to be translated
		*/	
		function setText($text)
		{
			$this->text = trim($text);
		}

		/**
		* Get Current url to be translated
		* @access public
		* @return String Current text to be translated
		*/		
		function getURL()
		{
			return $this->url;
		}
		/**
		* Set text to be translated
		* @access public
		* @param String $text text to be translated
		*/	
		function setURL($url)
		{
			$this->url = trim($url);
		}
				
		/**
		* Use cURL to get the translation (text or URL)
		* @access private
		* @param String $url URL where we send the request to
		* @param Array $postData Array containing the POST query parameters.
		*/		
		function fetchURL($url, $postData)
		{
			// Open cURL connection
			$handle = curl_init(); 
			// Set cURL Options
			curl_setopt( $handle, CURLOPT_COOKIEJAR, "cookie" );
			curl_setopt( $handle, CURLOPT_COOKIEFILE, "cookie" );
			curl_setopt( $handle, CURLOPT_URL, $url); // set the url to fetch
			curl_setopt( $handle, CURLOPT_HEADER, 0 ); // set headers (0 = no headers in result)
			curl_setopt( $handle, CURLOPT_RETURNTRANSFER, 1 ); // type of transfer (1 = to string)
			curl_setopt( $handle, CURLOPT_TIMEOUT, 10 ); // time to wait in
			curl_setopt( $handle, CURLOPT_POST, true);
			curl_setopt( $handle, CURLOPT_POSTFIELDS, http_build_query($postData) );
			
			// Execute the cURL call
			$result = curl_exec( $handle ); 
			
			// Close the cURL handle. Release connection
			curl_close( $handle ); 
			
			return $result;
		}		
		
		
		/**
		* Translate text using BabelFish's translation engine and return the translated string. If no text is provided, it uses the text stored in the $text attribute
		* @access public
		* @return String Translated Text
		* @param String $text Text to be translated
		*/	
		// Use cURL to fetch the translated text from BabelFish and Filter the output.
		function translateText( $text='' )
		{

			if ( !extension_loaded('curl') )
			{
				return ( 'You need to load/activate the cURL extension (http://www.php.net/cURL).' );
			}
			
			if(!in_array($this->sourceLang.'_'.$this->destLang, $this->allowed_lang_pairs))
			{
				return ( 'Translation not available between the selected Languages' );
			}
			
			if(trim($text)!='')
			{
				$this->text = trim($text);				
			}
			$data = array( "trtext" => utf8_encode($this->text), "lp" => $this->sourceLang.'_'.$this->destLang);
			
			// Fetch the translation using cURL
			$result = $this->fetchURL('http://ar.babelfish.yahoo.com/translate_txt', $data);

			// Strip out any unwanted text. Leave the result box.
			preg_match( '#<div id="result">(.*)</div>#sU', $result, $matches );

			// Strip any remaining HTML tags
			$content = strip_tags( $matches[1] );

			return $content;
		}
		
		/**
		* Translate a URL using BabelFish's translation engine and return the translated page. If no URL is provided, it uses the one stored in the $url attribute
		* @access public
		* @return String Translated URL
		* @param String $url URL to be translated
		*/	
		function translateURL( $url='' )
		{
			if ( !extension_loaded('curl') )
			{
				return ( 'You need to load/activate the cURL extension (http://www.php.net/cURL).' );
			}
			
			if(!in_array($this->sourceLang.'_'.$this->destLang, $this->allowed_lang_pairs))
			{
				return ( 'Translation not available between the selected Languages' );
			}
			
			if(trim($url)!='')
			{
				$this->url = trim($url);				
			}
			$data = array( ".intl" => "us", "lp" => $this->sourceLang.'_'.$this->destLang, "trurl"=>$this->url);
			
			// Fetch the translation using cURL
			$result = $this->fetchURL('http://66.163.168.225/babelfish/translate_url_content', $data);

			return $result;
		}		
	}

?>