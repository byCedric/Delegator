<?php namespace ByCedric\Delegator;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Contracts\ArrayableInterface;

class Delegator extends \Illuminate\Http\JsonResponse
{	
	/**
	 * The real status code.
	 * It can be switched of, because of client limitations.
	 * 
	 * @var integer
	 */
	protected $code = 200;

	/**
	 * The response message.
	 * 
	 * @var string
	 */
	protected $message = 'ok';

	/**
	 * The limit of the collection.
	 * 
	 * @var integer
	 */
	protected $limit = 0;

	/**
	 * The switch to include the limit attribute in the response.
	 * 
	 * @var boolean
	 */
	protected $use_limit = false;

	/**
	 * The offset of the collection.
	 * 
	 * @var integer
	 */
	protected $offset = 0;

	/**
	 * The switch to include the offset attribute in the response.
	 * 
	 * @var boolean
	 */
	protected $use_offset = false;

	/**
	 * The count of all type of collection.
	 * 
	 * @var integer
	 */
	protected $count = 0;

	/**
	 * The switch to include the count attribute in the response.
	 * 
	 * @var boolean
	 */
	protected $use_count = false;

	/**
	 * The success rate of the response.
	 * 
	 * @var boolean
	 */
	protected $error = false;

	/**
	 * The fake http status code switch.
	 * 
	 * @var boolean
	 */
	protected $mock_code = false; 

	public function __construct( $data = null, $status = 200, $headers = array(), $options = 0 )
	{
		parent::__construct($data, $status, $headers, $options);
		$this->data($data);
	}

	/**
	 * Build meta data for the response.
	 * It always contains "success", "code" & "message".
	 * When the data is just a single item, it also contains the "result".
	 * And when the data is a collection, it contains "results" instead of "result".
	 * It also contains "limit", "offset" and "count" when you provide the correct data.
	 * 
	 * @param  array $data
	 * @return \ByCedric\Delegator\Delegator
	 */
	protected function meta( $data = array() )
	{
		$meta = array(
			'success'	=> !$this->error,
			'code' 		=> $this->code,
			'message' 	=> $this->message,
		);

		if( empty($data) || array_keys($data) !== range(0, count($data) - 1) )
		{
			$meta['result'] = $data;
			return $meta;
		}

		if( $this->use_limit == true )
		{
			$meta['limit'] = $this->limit;
		}

		if( $this->use_offset == true )
		{
			$meta['offset'] = $this->offset;	
		}

		if( $this->use_count == true )
		{
			$meta['count'] = $this->count;	
		}

		$meta['results'] = $data;
		return $meta;
	}

	/**
	 * Set the status code for the current response.
	 * 
	 * @param  integer $code
	 * @return \ByCedric\Delegator\Delegator
	 */
	public function code( $code = 200 )
	{
		$this->code = $code;
		
		if( $this->mock_code )
		{
			$this->setStatusCode(200);
		}
		else
		{
			$this->setStatusCode($code);
		}

		return $this;
	}

	/**
	 * Set the message for the current response.
	 * 
	 * @param  string $message
	 * @return \ByCedric\Delegator\Delegator
	 */
	public function message( $message = '' )
	{
		$this->message = $message;
		return $this;
	}

	/**
	 * Set the data for the current response.
	 * Also wrap it in meta data.
	 * 
	 * @param  mixed $data
	 * @return \ByCedric\Delegator\Delegator
	 */
	public function data( $data = null )
	{
		if( $data instanceof ArrayableInterface )
		{
			$data = $data->toArray();
		}

		$data = $this->meta($data);
		$this->setData($data);
		return $this;
	}

	/**
	 * Set a JSONP callback.
	 * 
	 * @param  string $callback
	 * @return \ByCedric\Delegator\Delegator
	 */
	public function callback( $callback = null )
	{
		$this->setCallback($callback);
		return $this;
	}

	/**
	 * Set the limit of the query.
	 * It is most useful when using a collection of a specific type.
	 * You can easily define the max amount of items to retrieve at once.
	 * 
	 * @param  integer|boolean $limit
	 * @return \ByCedric\Delegator\Delegator
	 */
	public function limit( $limit = 0 )
	{
		$this->limit = (int) $limit;

		if( is_bool($limit) && $limit == false )
		{
			$this->use_limit = false;
		}
		else
		{
			$this->use_limit = true;
		}

		return $this;
	}

	/**
	 * Set the offset of the query.
	 * It is most useful when using a collection of a specific type.
	 * You can easily define the current offset of the collection.
	 * 
	 * @param  integer|boolean $offset
	 * @return \ByCedric\Delegator\Delegator
	 */
	public function offset( $offset = 0 )
	{
		$this->offset = (int) $offset;

		if( is_bool($offset) && $offset == false )
		{
			$this->use_offset = false;
		}
		else
		{
			$this->use_offset = true;
		}

		return $this;
	}

	/**
	 * Set the total count of the query.
	 * It is most useful when using a collection of a specific type.
	 * You can easily define the total amount of items in existence.
	 *  
	 * @param  integer|boolean $count
	 * @return \ByCedric\Delegator\Delegator
	 */
	public function count( $count = 0 )
	{
		$this->count = (int) $count;

		if( is_bool($count) && $count == false )
		{
			$this->use_count = false;
		}
		else
		{
			$this->use_count = true;
		}

		return $this;
	}

	/**
	 * Set the response as an error.
	 * When using errors, please enter a human readable message.
	 * This way the API user can detect the problem and fix it.
	 * 
	 * @param  string  $message
	 * @param  integer $code
	 * @return \ByCedric\Delegator\Delegator
	 */
	public function error( $message, $code )
	{
		$this->error = true;
		
		return $this
			->code($code)
			->message($message)
		;
	}

	/**
	 * Fake the status code of the response.
	 * When this is set to true, the header will always be status 200.
	 * Only the given code is the real one.
	 * It is primarily used for client-side limitations.
	 * 
	 * @param  boolean $switch
	 * @return \ByCedric\Delegator\Delegator
	 */
	public function mockCode( $switch = true )
	{
		if( $switch && !$this->mock_code )
		{
			$this->mock_code = true;
			$this->setStatusCode(200);
		}
		else if( !$switch && $this->mock_code )
		{
			$this->mock_code = false;
			$this->setStatusCode($this->code);
		}

		return $this;
	}

}
