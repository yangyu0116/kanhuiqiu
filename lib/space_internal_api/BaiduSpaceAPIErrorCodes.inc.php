<?php
/***************************************************************************
 * 
 * Copyright (c) 2009 Baidu.com, Inc. All Rights Reserved
 * $Id: BaiduSpaceAPIErrorCodes.inc.php,v 1.1 2010/03/18 09:06:36 mahongxu Exp $ 
 * 
 **************************************************************************/
 
/**
 * @file BaiduSpaceAPIErrorCodes.inc.php
 * @author zhujt(zhujianting@baidu.com)
 * @date 2009/02/26 13:37:44
 * @version $Revision: 1.1 $ 
 * @brief Error codes and descriptions for the Baidu Space API.
 * If the developer is going to add his own error codes, to retain compatibility 
 * with Baidu Space, you may wish to begin your error codes at 10000 and above
 *  
 **/

define('API_EC_SUCCESS', 0);

/**
 * general errors
 **/
define('API_EC_UNKNOWN', 1);
define('API_EC_SERVICE', 2);
define('API_EC_METHOD', 3);
define('API_EC_TOO_MANY_CALLS', 4);
define('API_EC_BAD_IP', 5);

/**
 * param errors
 **/
define('API_EC_PARAM', 100);
define('API_EC_PARAM_API_KEY', 101);
define('API_EC_PARAM_SESSION_KEY', 102);
define('API_EC_PARAM_CALL_ID', 103);
define('API_EC_PARAM_SIGNATURE', 104);
define('API_EC_PARAM_TOO_MANY', 105);
define('API_EC_PARAM_USER_ID', 110);
define('API_EC_PARAM_USER_FIELD', 111);
//define('API_EC_PARAM_SOCIAL_FIELD', 112);
//define('API_EC_PARAM_SUBCATEGORY', 141);
//define('API_EC_PARAM_TITLE', 142);
//define('API_EC_PARAM_BAD_JSON', 144);

/**
 * user permission errors
 **/
define('API_EC_PERMISSION', 200);
define('API_EC_PERMISSION_USER', 210);
//define('API_EC_PERMISSION_ALBUM', 220);
//define('API_EC_PERMISSION_PHOTO', 221);
//define('API_EC_PERMISSION_MESSAGE', 230);
//define('API_EC_PERMISSION_MARKUP_OTHER_USER', 240);
//define('API_EC_PERMISSION_STATUS_UPDATE', 250);

/**
 * data store API errors
 **/
define('API_EC_DATA_UNKNOWN_ERROR', 800); // should never happen
define('API_EC_DATA_INVALID_OPERATION', 801);
define('API_EC_DATA_QUOTA_EXCEEDED', 802);
define('API_EC_DATA_OBJECT_NOT_FOUND', 803);
define('API_EC_DATA_OBJECT_ALREADY_EXISTS', 804);
define('API_EC_DATA_DATABASE_ERROR', 805);

/**
 * application info errors
 **/
define('API_EC_NO_SUCH_APP', 900);

/**
 * batch API errors
 **/
define('API_EC_BATCH_ALREADY_STARTED', 950);
define('API_EC_BATCH_NOT_STARTED', 951);
define('API_EC_BATCH_TOO_MANY_ITEMS', 952);
define('API_EC_BATCH_METHOD_NOT_ALLOWED_IN_BATCH_MODE', 953);

/**
 * Notification & Feeds API errors
 **/
define('API_EC_TITLE_DATA_REQUIRED', 10000);
define('API_EC_TITLE_DATA_FORMAT', 10001);
define('API_EC_TITLE_DATA_MISS_PARAM', 10002);

define('API_EC_TITLE_TEMPLATE_REQUIRED', 10020);
define('API_EC_TITLE_TEMPLATE_NOT_FOUND', 10021);

define('API_EC_BODY_DATA_REQUIRED', 10040);
define('API_EC_BODY_DATA_FORMAT', 10041);
define('API_EC_BODY_DATA_MISS_PARAM', 10042);

define('API_EC_BODY_TEMPLATE_REQUIRED', 10060);
define('API_EC_BODY_TEMPLATE_NOT_FOUND', 10061);

define('API_EC_NOTE_SENDER_ONLY', 10080);
define('API_EC_NOTE_EXCEED_LIMIT', 10081);
define('API_EC_FEED_EXCEED_LIMIT', 10082);


$GLOBALS['api_error_descriptions'] = array(API_EC_SUCCESS             => 'Success',
										  API_EC_UNKNOWN             => 'An unknown error occurred',
										  API_EC_SERVICE             => 'Service temporarily unavailable',
										  API_EC_METHOD              => 'Unknown method',
										  API_EC_TOO_MANY_CALLS      => 'Application request limit reached',
										  API_EC_BAD_IP              => 'Unauthorized source IP address',
										  API_EC_PARAM               => 'Invalid parameter',
										  API_EC_PARAM_API_KEY       => 'Invalid API key',
										  API_EC_PARAM_SESSION_KEY   => 'Session key invalid or no longer valid',
										  API_EC_PARAM_CALL_ID       => 'Call_id must be greater than previous',
										  API_EC_PARAM_SIGNATURE     => 'Incorrect signature',
										  API_EC_PARAM_TOO_MANY      => 'The number of parameters exceeded the maximum for this operation',
										  API_EC_PARAM_USER_ID       => 'Invalid user id',
										  API_EC_PARAM_USER_FIELD    => 'Invalid user info field',
										  //API_EC_PARAM_SOCIAL_FIELD  => 'Invalid user field',
										  //API_EC_PARAM_SUBCATEGORY   => 'Invalid subcategory',
										  //API_EC_PARAM_TITLE         => 'Invalid title',
										  //API_EC_PARAM_BAD_JSON      => 'Malformed JSON string',
										  API_EC_PERMISSION          => 'Permissions error',
										  API_EC_PERMISSION_USER     => 'User not visible',
										  //API_EC_PERMISSION_ALBUM    => 'Album or albums not visible',
										  //API_EC_PERMISSION_PHOTO    => 'Photo not visible',
										  //API_EC_PERMISSION_MESSAGE  => 'Permissions disallow message to user',
										  //API_EC_PERMISSION_MARKUP_OTHER_USER => 'Desktop applications cannot set FBML for other users',
										  //API_EC_PERMISSION_STATUS_UPDATE => 'Updating status requires the extended permission status_update',
										  API_EC_DATA_UNKNOWN_ERROR		=> 'Unknown data store API error',
										  API_EC_DATA_INVALID_OPERATION	=> 'Invalid operation',
										  API_EC_DATA_QUOTA_EXCEEDED	=> 'Data store allowable quota was exceeded',
										  API_EC_DATA_OBJECT_NOT_FOUND	=> 'Specified object cannot be found',
										  API_EC_DATA_OBJECT_ALREADY_EXISTS => 'Specified object already exists',
										  API_EC_DATA_DATABASE_ERROR	=> 'A database error occurred. Please try again',
										  //API_EC_REF_SET_FAILED		=> 'Unknown failure in storing ref data. Please try again.',
										  API_EC_NO_SUCH_APP			=> 'No such application exists',
										  API_EC_BATCH_ALREADY_STARTED	=> 'begin_batch already called, please make sure to call end_batch first',
										  API_EC_BATCH_NOT_STARTED		=> 'end_batch called before start_batch',
										  API_EC_BATCH_TOO_MANY_ITEMS		=> 'Each batch API can not contain more than 20 items',
										  API_EC_BATCH_METHOD_NOT_ALLOWED_IN_BATCH_MODE => 'This method is not allowed in batch mode',
										  API_EC_TITLE_DATA_REQUIRED	=> 'title_data param is required',
										  API_EC_TITLE_DATA_FORMAT		=> 'title_data is not a valid json format',
										  API_EC_TITLE_DATA_MISS_PARAM	=> 'title_data miss some value for template var',

										  API_EC_TITLE_TEMPLATE_REQUIRED	=> 'title template id is required',
										  API_EC_TITLE_TEMPLATE_NOT_FOUND	=> 'title template not found',

										  API_EC_BODY_DATA_REQUIRED		=> 'body_data param is required',
										  API_EC_BODY_DATA_FORMAT		=> 'body_data is not a valid json format',
										  API_EC_BODY_DATA_MISS_PARAM	=> 'body_data miss some value for template var',

										  API_EC_BODY_TEMPLATE_REQUIRED	=> 'body template id is required',
										  API_EC_BODY_TEMPLATE_NOT_FOUND	=> 'body template not found',
										  API_EC_NOTE_SENDER_ONLY		=> 'Only sender can receive the notification when the app has not pass audit',
										  API_EC_NOTE_EXCEED_LIMIT		=> 'Notification limit perday has been exceed for this user',
										  API_EC_FEED_EXCEED_LIMIT		=> 'Feed limit perday has been exceed for this user',

								);

class BaiduSpaceAPIException extends Exception
{
	public function __construct($errcode, $errmsg = null)
	{
		if( empty($errmsg) )
		{
			if( isset($GLOBALS['api_error_descriptions']) &&
				isset($GLOBALS['api_error_descriptions'][$errcode]) )
			{
				$errmsg = $GLOBALS['api_error_descriptions'][$errcode];
			}
			else
			{
				$errmsg = 'unrecognized exception';
			}
		}
		parent::__construct($errmsg, $errcode);
	}
}


/* vim: set ts=4 sw=4 sts=4 tw=100 noet: */
?>
