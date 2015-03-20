<?php namespace Anunatak\Postal;

use Storage;
use File;
use parseCSV;
use Stringy\StaticStringy as S;

class Parser {

	protected $parser;

	public $data;
	
	/**
	 * Creates a new parser instance
	 */
	public function __construct( $force = false ) {

		// store an instance of parseCSV
		$this->parser = new parseCSV;

		// download the remote file
		$this->download( $force );

		// parse the downloaded file
		$this->parse();
		
	}

	/**
	 * Downloads the remote data file and saves it to the storage bin
	 * 
	 * @return void
	 */
	protected function download( $force = false ) {

		// the remote source
		$url 	= 'http://www.bring.no/hele-bring/produkter-og-tjenester/brev-og-postreklame/andre-tjenester/_attachment/159761?download=true';

		// does it already exist
		if ( ! Storage::exists('postal/data.txt') || $force ) {
			$data 	= @file_get_contents($url);
			Storage::disk('local')->put('postal/data.txt', $data);
		}

	}

	/**
	 * Parses the stored remote data
	 * 
	 * @return void
	 */
	protected function parse() {

		// only perform actions when we have a file
		if( Storage::exists('postal/data.txt') ) {

			// get the contents from storage
			$data = Storage::get('postal/data.txt');

			// add a header
			$data = "Code1\tPlace1\tCode2\tPlace2\tType\n". $data;

			// convert to utf-8
			$data = iconv('ISO-8859-1', "UTF-8", $data);

			// set parser settings
			$this->parser->encoding('UTF-8');
			$this->parser->delimiter = "\t";

			// parse the data
			$this->parser->parse( $data );

			// get the parsed csv
			$parsed = $this->parser->data;

			// empty arrays
			$codes = array();

			// loop items
			foreach($parsed as $parse) {
				
				$codes[] = array( 'code' => $parse['Code1'], 'place' => S::toTitleCase( $parse['Place1'] ) );
				$codes[] = array( 'code' => $parse['Code2'], 'place' => S::toTitleCase( $parse['Place2'] ) );
			}

			$this->data = $codes;

		}

	}
}