<?php
namespace bareHands;

/**
 * A menu Element
 *
 * @author heho
 */
class MenuElement
{
	/**
	 * ID of menu element
	 *
	 * @var integer
	 */
	protected $id;

	/**
	 * name of menu element
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * path of menu element
	 *
	 * @var string
	 */
	protected $class;

	/**
	 * optional icon of menu element
	 *
	 * @var string
	 */
	protected $icon;

	/**
	 * optional short tect of menu element
	 *
	 * @var string
	 */
	protected $text;

	/**
	 * optional onClick Action
	 *
	 * @var string
	 */
	protected $action;

	/**
	 * optional childElements
	 *
	 * @var array of /bareHands/MenuElement
	 */
	protected $childElements = array();

	/**
	 *
	 * @param MenuElement $element A menu Element
	 */
	public function addChildElement(MenuElement $element)
	{
		array_push($this->childElements, $element);
	}

	/**
	 *
	 * @param integer $id Id of a menuElement
	 * @return bool returns true if an element was deleted
	 */
	public function deleteChildElementById($id)
	{
		foreach($this->childElements as $element)
		{
			if($element->getId() == $id)
			{
				$element = null;
				return true;
			}
			if($element->hasChildElements())
			{
				if($element->deleteChildElementById($id))
				{
					return true;
				}
			}
		}

		return false;
	}

	/**
	 *
	 * @return boolean returns true if element has childelements
	 */
	public function hasChildElements()
	{
		foreach($this->childElements as $element)
		{
			if($element !== null)
			{
				return true;
			}
		}

		return false;
	}

	/**
	 *
	 * @return string ID of menuElement
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 *
	 * @param string $id
	 * @return MenuElement
	 */
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}

	/**
	 *
	 * @return string Name of the menuElement
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 *
	 * @param string $name
	 * @return MenuElement
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	/**
	 *
	 * @return string class of the menuElement
	 */
	public function getClass()
	{
		return $this->class;
	}

	/**
	 *
	 * @param string $class
	 * @return MenuElement
	 */
	public function setClass($class)
	{
		$this->class = $class;
		return $this;
	}

	/**
	 *
	 * @return string Icon of the menuElement. Most likely a path
	 */
	public function getIcon()
	{
		return $this->icon;
	}

	/**
	 *
	 * @param string $icon
	 * @return MenuElement
	 */
	public function setIcon($icon)
	{
		$this->icon = $icon;
		return $this;
	}

	/**
	 *
	 * @return string action of the menuElement
	 */
	public function getAction()
	{
		return $this->action;
	}

	/**
	 *
	 * @param string $action
	 * @return MenuElement
	 */
	public function setAction($action)
	{
		$this->action = $action;
		return $this;
	}

	/**
	 *
	 * @return string menuElements text
	 */
	public function getText()
	{
		return $this->text;
	}

	/**
	 *
	 * @param string $text
	 * @return MenuElement 
	 */
	public function setText($text)
	{
		$this->text = $text;
		return $this;
	}

	/**
	 *
	 * @return array of menuElements
	 */
	public function getChildElements()
	{
		return $this->childElements;
	}

	/**
	 *
	 * @param array $elements array of menuElements
	 * @return MenuElement
	 */
	public function setChildElements(array $elements)
	{
		if($this->isValidChildElementsArray($elements))
		{
			$this->childElements = $elements;
			return $this;
		}
		else
		{
			throw new InvalidElementsException();
		}
	}

	public function isValidChildElementsArray(array $arrayOfMenuElements)
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
}
?>
