<?php
namespace bareHands;

/**
 * The Menu
 *
 * @author heho
 */
class Menu
{
	/**
	 * name of the menu
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * contains array of MenuElements
	 * 
	 * @var array of /bareHands/MenuElement
	 */
	protected $menuElements = array();
	
	/**
	 * Contains registered Loaders
	 * 
	 * @var array
	 */
	protected $menuLoaders = array();

	/*
	 * Contains registered Savers
	 *
	 * @var array
	 */
	protected $menuSavers = array();

	/**
	 * Contains the registered Renderer
	 *
	 * @var \bareHands\MenuRenderer
	 */
	protected $menuRenderer;

	/**
	 * Contains a menu Settings Object
	 *
	 * @var MenuSettings
	 */
	protected $menuSettings;

	/**
	 *
	 * @param string $name Name of the created Menu
	 */
	public function __construct($name)
	{
		$this->name = $name;
	}

	/**
	 *
	 * @return string name of the menu
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 *
	 * @param string $name
	 * @return Menu
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	/**
	 *
	 * @param \bareHands\MenuLoader $loader A valid menu loader
	 * @return /bareHands/Menu
	 */
	public function registerLoader(MenuLoader $loader)
	{
		array_push($this->menuLoaders, $loader);
		return $this;
	}

	/**
	 *
	 * @param \bareHands\MenuSaver $saver A valid menu saver
	 * @return /bareHands/Menu
	 */
	public function registerSaver(MenuSaver $saver)
	{
		array_push($this->menuSavers, $saver);
		return $this;
	}

	/**
	 *
	 * @param \bareHands\MenuRenderer $renderer A valid menu renderer
	 * @return /bareHands/Menu
	 */
	public function registerRenderer(MenuRenderer $renderer)
	{
		$menu->Renderer = $renderer;
		return $this;
	}

	/**
	 *
	 * @param MenuElement $element A menu Element
	 * @return /bareHands/Menu
	 */
	public function addMenuElement(MenuElement $element)
	{
		array_push($this->menuElements, $element);
		return $this;
	}

	/**
	 *
	 * @param integer $id Id of a menuElement
	 * @return /bareHands/Menu
	 * @throws /bareHands/NotExistingElementException
	 */
	public function deleteMenuElementById($id)
	{
		foreach($this->menuElements as $element)
		{
			if($element->getId() == $id)
			{
				$element = null;
				return $this;
			}
			if($element->hasChildElements())
			{
				if($element->deleteChildElementById($id))
				{
					return $this;
				}
			}
		}

		throw new NotExistingElementException();
	}

	/**
	 *
	 * @return /bareHands/MenuElement
	 */
	public function getMenuElements()
	{
		return $this->menuElements;
	}

	/**
	 *
	 * @param array $elements Array of menuElements
	 * @return /bareHands/Menu
	 */
	public function setMenuElements(array $elements)
	{
		if($this->isValidMenuElementsArray($elements))
		{
			$this->menuElements = $elements;
			return $this;
		}
		else
		{
			throw new InvalidElementsException();
		}
	}

	/**
	 * Validates recursive that every Element of an array is a menu element
	 *
	 * @param array $arrayOfMenuElements
	 * @return bool is true when Array is valid
	 */
	public function isValidMenuElementsArray(array $arrayOfMenuElements)
	{
		foreach($arrayOfMenuElements as $element)
		{
			if(!($element instanceof \bareHands\MenuElement))
			{
				return false;
			}
			if($element->hasChildElements)
			{
				$childElements = $element->getChildElements();
				if(!$element->isValidChildElementsArray($childElements))
				{
					return false;
				}
			}
		}
		return true;
	}

	/**
	 *
	 * @param string $saverName Name of a registered Saver
	 * @param array $options save options
	 * @return /bareHands/Menu
	 * @throws NotExistingSaverException
	 */
	public function save($saverName, $options = null)
	{
		foreach($this->menuSavers as $saver)
		{
			if($saver->name = $saverName)
			{
				$saver->save($this->menuElements, $options);
				return $this;
			}
		}

		throw new NotExistingSaverException();
	}

	/**
	 *
	 * @param string $loaderName
	 * @param array $options
	 * @return /bareHands/Menu
	 * @throws NotExistingLoaderException
	 */
	public function load($loaderName, $options = null)
	{
		foreach($this->menuLoaders as $loader)
		{
			if($loader->name = $loaderName)
			{
				$menuElements = $loader->load($options);
				return $this;
			}
		}

		throw new NotExistingLoaderException();
	}

	/**
	 *
	 * @param array $options
	 * @return /bareHands/Menu
	 * @throws NoRegisteredRendererException
	 */
	public function render($options = null)
	{
		if(!isset($this->menuRenderer))
		{
			throw new NoRegisteredRendererException();
			return;
		}

		$this->menuRenderer->render($options, $settings);
		return $this;
	}
}
?>
