<?php
/**
 * Url Router. Class to help you use custom urls with slugs for content and/or folders
 *
 * @author    Steve GUNS <steve@b-en-e.com>
 * @copyright 2011 B&E DeZign
 * @package
 * @category  Components.Yii
 *
 * This class allows more easy control over a specific urls.
 * Functionality includes:
 * - Aliases possible on both controller and on action level (for translation for example)
 * - Slugs for both the "folder" as the "content"
 * - The "ID" part can be both at the end or the beginning of the content slug
 * - For url creation functionality you can specify models to obtain title & id from or strings.
 *
 * Some examples (original url followed by the routed version after):
 * /forum/15/some-forum-name/index
 *    "forum/index". $_REQUEST => id = 15, 'folderSlug' = 'some-forum-name', 'contentSlug' => 'index'
 *    'index' is the name for "actionIndex" and thus recognized as an action (contentSlugAction needs to be TRUE).
 * /forum/15/some-forum-name/some-topic-name
 *    "forum/routeRequest". $_REQUEST => id = 15, 'folderSlug' = 'some-forum-name', 'contentSlug' => 'some-topic-name'
 *    Since no action is recognized it will go to the general "routeRequest", which is defined as the actionRoute
 * /forum/15/some-forum-name/some-topic-name/new
 *    Same as above but redirected to the "new" action (if it is part of the custom actions array)
 *
 * If there is an even amount of url parts left after the parsing those are considered <variable>=<value> pairs and will be added to GET/REQUEST
 *
 * Note that if you want dedicated routes for the controller that don't fit in the /controller/slug/slug schema it might
 * be best to define these as normal routes before the url class. They will be correctly recognized if you add the action
 * to the "actions" array though
 */

class UrlRouter extends CBaseUrlRule
{
	const FOLDER_SLUG   = 1;
	const CONTENT_SLUG  = 2;
	const CONTENT_ID    = 3;
	const CUSTOM_ACTION = 4;

	/**
	 * Create URL
	 */

	/**
	 * The parameter name for the "folder" object
	 * @var string
	 */
	public $folderParameter    = 'f';

	/**
	 * The parameter name for the "content" object
	 */
	public $contentParameter   = 'c';

	/**
	 * If folder/content contain an object, this indicates what property should be fetched to obtain the title.
	 * @var string
	 */
	public $titleProperty      = 'title';

	/**
	 * If the folder/content argument contain an object, this is the property to obtain the ID
	 * @var string
	 */
	public $idProperty         = 'id';

	/**
	 * If TRUE, the rest of the URL parts will be collected as if they were GET variables (during creating they will
	 * also append these as URL parts)
	 * @var BOOL
	 */
	public $collectParameters = TRUE;

	/**
	 * Parse URL
	 */

	/**
	 * If TRUE, the ID is assumed to be at the end (the last part). If FALSE, the content slug starts with the ID
	 * @var bool
	 */
	public $postfixId = FALSE;

	/**
	 * Character used for the separator
	 * @var string   default '-'
	 */
	public $separator = '-';

	/**
	 * An array of <contentType> => array(<config>) entries. Take a look at {@see $defaultConfig} for the
	 * possible configuration settings
	 * @var array
	 */
	public $map = array();

	/**
	 * Defines aliases for controllers (for localized URLs and so on)
	 * Format is <controller> => array(<alternativeName>, ...)
	 * @var array
	 */
	public $aliases = array();

	/**
	 * Every map entry will be combined with this to add the things you don't specify
	 *
	 * @var array
	 */
	public $defaultConfig = array
	(
		// If set, this will override the controller that is returned (by default it is the array key, or the alias)
		// 'controller'      => 'custom',

		// The REQUEST key that will be set as the content ID. Defaults to 'id'
		'idKey'              => 'id',

		// The default action for an index
		'actionIndex'        => 'index',

		// The default action for anything that has a contentSlug but no custom action
		'defaultAction'      => 'routeRequest',

		// If TRUE, the contentSlug can be the name of an action. Note that only actionIndex, defaultAction and the "actions"
		// are considered to be an action. The rest is a regular slug
		// For example: "15-index" will return action index for id 15
		'contentSlugAction'  => TRUE,

		// Custom actions. Contains a set of 'urlPart' => 'targetAction' types. Note: Out of laziness, make sure to add
		// the action itself if it is different from the actionIndex or actionRoute or it wont be recognized ('post' => 'post')
		// For example: Makes both words point to the post action array('new' => 'post', 'nouveau' => 'post'),
		'actions'            => array(),

		// List of actions that should not be processed for the given controller
		'ignoreActions'      => array(),

		// The different parts of the URL, usually folder slug, content slug and optionally a custom action
		// As mentioned in contentSlugAction, only known actions are considered valid. Anything that is not in that list
		// will be skipped as custom action
		'urlFormat'          => array(self::CONTENT_ID, self::FOLDER_SLUG, self::CONTENT_SLUG, self::CUSTOM_ACTION),

		// If this is true it indicates the titles are slugs already and should not be modified again
		'preSlugged'         => FALSE,
	);

	// Original entry controller
	protected $_sController = FALSE;
	// Currently active configuration
	protected $_aConfig     = NULL;


	public function init()
	{
		foreach ($this->map as $sType => $aConfig)
		{
			$this->map[$sType] = array_merge($this->defaultConfig, $aConfig);
		}
	}

	/**
	 * Create a URL.
	 * Special considerations:
	 * - Controller: If you specify a controller that is an alias or the original for the controller that was used
	 *   "incoming", the incoming controller will be used instead. This allows you to specify the "default" controller
	 *   and the translated version is used outgoing.
	 * - Parameters:
	 *   * 'f'      - either the model to use or the name of the folder. [{@see $folderParameter} to modify]
	 *   * 'c'      - either the content title or the model to use for the content. [{@see $contentParameter} to modify]
	 *   * 'id'     - the ID to use if you are specifying the titles as a string
	 *   * 'action' - if specified, contains the "custom action" to add
	 *   *
	 *
	 *
	 * @param $oManager
	 * @param $sRoute
	 * @param $aParams
	 * @param $sAmpersand
	 * @return bool
	 *
	 */
	public function createUrl($oManager, $sRoute, $aParams, $sAmpersand)
	{
		$this->init();

		$aParts = explode('/', $sRoute);
		$sController = array_shift($aParts);
		if (($sType = $this->_findType(strtolower($sController))) == FALSE)
			// No match
			return FALSE;

		// If the resulting "type" is the same as the one that we came in with, then use that one.
		// (It can be a translation and so on
		if ($sType == $this->_sController)
			$sController = $sType;

		$this->_aConfig = $aConfig = $this->map[$sType];
		$sFolder = $sContent = '';
		$nId = isset($aParams['id']) ? $aParams['id'] : FALSE;

		// If no action is specified, but the route contains a 2nd part, use that as action
		if (isset($aParts[0]) && !isset($aParams['action']))
			$aParams['action'] = $aParts[0];

		// Check if we have a content specified
		if (isset($aParams[$this->contentParameter]))
		{
			$sContent = $aParams[$this->contentParameter];
			if (!is_string($aParams[$this->contentParameter]))
			{
				// It's an object, fetch the ID first before getting rid of it
				if (!$nId) $nId = $aParams[$this->contentParameter]->{$this->idProperty};
				$sContent = $aParams[$this->contentParameter]->{$this->titleProperty};
			}
		}

		// Do we have a folder specified?
		if (isset($aParams[$this->folderParameter]))
		{
			$sFolder = $aParams[$this->folderParameter];
			if (!is_string($aParams[$this->folderParameter]))
			{
				// It's an object, fetch the ID first before getting rid of it
				if (!$nId) $nId = $aParams[$this->folderParameter]->{$this->idProperty};
				$sFolder = $aParams[$this->folderParameter]->{$this->titleProperty};
			}
		}

		if ($sFolder && !$sContent)
		{
			// Assume a mistake and reverse the arguments
			$sContent = $sFolder;
			$sFolder = NULL;
		}

		if ($sContent && !$sFolder)
		{
			$sAction = $aConfig['actionIndex'];
			if (isset($aParams['action']))
			{
				$sAction = $aParams['action'];
				unset($aParams['action']);
			}

			// Only content is given, so this is an "index" action
			$aParts = array
			(
				self::FOLDER_SLUG  => $this->slugify($sContent),
				self::CONTENT_SLUG => $this->_makeContentSlug($nId, $sAction),
			);
		}
		elseif ($sContent && $sContent)
		{
			// Both content and folder specified, assemble normal URL
			$aParts = array
			(
				self::FOLDER_SLUG  => $this->slugify($sFolder),
				self::CONTENT_SLUG => $this->_makeContentSlug($nId, $this->slugify($sContent)),
			);
		}
		else
			// Not for us.
			return FALSE;

		$aParts[self::CONTENT_ID] = $nId;

		if (isset($aParams['action']))
			$aParts[self::CUSTOM_ACTION] = $aParams['action'];

		$aResult = array($sController);
		foreach ($aConfig['urlFormat'] as $nType)
			if (isset($aParts[$nType]))
				$aResult[] = $aParts[$nType];

		if ($this->collectParameters)
		{
			// Get rid of all the internally used parameters
			unset($aParams[$this->contentParameter], $aParams[$this->folderParameter], $aParams['contentSlug'], $aParams['folderSlug']);
			unset($aParams['id'], $aParams['title']);

			// If anything remains, add them as url parts
			foreach($aParams as $sKey => $sVariable)
			{
				$aResult[] = $sKey;
				$aResult[] = $sVariable;
			}
		}

		return implode('/', $aResult);
	}

	public function parseUrl($oManager, $oRequest, $sPathInfo, $sRawPathInfo)
	{
		$this->init();

		$aParts = explode('/', $sPathInfo);
		$sType = array_shift($aParts);
		if (($sType = $this->_findType(strtolower($sType))) == FALSE)
			// No match
			return FALSE;

		// Still here so its a match
		$this->_aConfig = $aConfig = $this->map[$sType];
		$bCustomAction = FALSE;
		$sAction = $aConfig['actionIndex'];
		$aVariables = array();
		foreach ($aConfig['urlFormat'] as $nType)
		{
			$sPart = array_shift($aParts);
			if (!empty($sPart))
				switch ($nType)
				{
					case self::CONTENT_ID :
						$aVariables[$aConfig['idKey']] = $sPart;
						break;

					case self::FOLDER_SLUG :
						// It can only be a folder slug if there are parts remaining!
						if (count($aParts))
						{
							$aVariables['folderSlug'] = $sPart;
							if (!$bCustomAction)
								$sAction = $aConfig['actionIndex'];
							break;
						}
						// No parts left, this cannot be the folder slug. Assume content and fall through!

					case self::CONTENT_SLUG :
						$aPieces = $this->_splitContentSlug($sPart);
						if (count($aPieces) == 2)
						{
							// id and slug found, assign
							$aVariables[$aConfig['idKey']] = $aPieces[0];
							$aVariables['contentSlug'] = $aPieces[1];
						}
						else
							// Not splittable, perhaps its just an action name (regular route)
							$aVariables['contentSlug'] = $sPart;

						// No custom action was defined yet, so check if we might have a known action
						if (!$bCustomAction)
						{
							$sAction = $aConfig['defaultAction'];
							if ($aConfig['contentSlugAction'])
							{
								// The content slug can contain an action so see if its a known one.
								$sSlug = $aVariables['contentSlug'];
								if ($sSlug == $aConfig['actionIndex'] || $sSlug == $aConfig['defaultAction'])
									$sAction = $sSlug;
								elseif (array_key_exists($sSlug, $aConfig['actions']))
									$sAction = $aConfig['actions'][$sSlug];
							}
						}
						break;

					case self::CUSTOM_ACTION :
						// Note that a custom action was already specified, can't override anymore
						$bCustomAction = TRUE;
						if (array_key_exists($sPart, $aConfig['actions']))
						{
							if (array_key_exists($sPart, $aConfig['actions']))
								$sAction = $aConfig['actions'][$sPart];
						}
						else
							// Not a valid custom action, put it back
							array_unshift($aParts, $sPart);
						break;
				}
		}

		// See if we have an alternate controller specified
		$this->_sController = $sType;
		if (isset($aConfig['controller']))
			$this->_sController = $aConfig['controller'];

		foreach ($aVariables as $sKey => $sValue)
			$_GET[$sKey] = $_REQUEST[$sKey] = $sValue;

		// If we have an even amount of parts left, assume they are parameters too
		if ($this->collectParameters && count($aParts) && count($aParts) % 2 == 0)
		{
			$sKey = array_shift($aParts);
			$sValue = array_shift($aParts);
			$_GET[$sKey] = $_REQUEST[$sKey] = $sValue;
		}

		return $this->_sController . '/' . $sAction;
	}

	/**
	 * Links the "type" (controller) to an entry in the map or an alias
	 * @param string $sPart
	 * @return bool|string
	 */
	protected function _findType($sPart)
	{
		if (isset($this->map[$sPart]))
			// Direct match, the easiest
			return $sPart;

		foreach ($this->aliases as $sContentKey => $aAliases)
			if (in_array($sPart, $aAliases))
				return $sContentKey;

		return FALSE;
	}

	/**
	 * Splits the content slug in an ID and a slug, depending on the settings
	 *
	 * @param $sContentSlug
	 * @return array|FALSE
	 */
	protected function _splitContentSlug($sSlug)
	{
		if (in_array(self::CONTENT_ID, $this->_aConfig['urlFormat']))
			// The ID is supposed to be separately added, so no splitting
			return $sSlug;

		$nPos = $this->postfixId ? strrpos($sSlug, $this->separator) : strpos($sSlug, $this->separator);
		if ($nPos === FALSE)
			return FALSE;

		return array(substr($sSlug, 0, $nPos), substr($sSlug, $nPos + 1));
	}

	protected function _makeContentSlug($sId, $sSlug)
	{
		if (in_array(self::CONTENT_ID, $this->_aConfig['urlFormat']))
			// The ID is supposed to be separately added
			return $sSlug;

		$aParts = $this->postfixId ? array($sSlug, $sId) : array($sId, $sSlug);
		return implode($this->separator, $aParts);
	}

	/**
	 * "Slugify" the given string
	 *
	 * @return string
	 */
	public function slugify($sContent)
	{
		if ($this->_aConfig['preSlugged'])
			return $sContent;

		// Replace all non letters or digits with -
		$sContent = preg_replace('/\W+/', $this->separator, $sContent);

		// Trim and lowercase
		return strtolower(trim($sContent, $this->separator));
	}
}
