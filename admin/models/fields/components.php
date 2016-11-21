<?php
/*
* @package    User Notify Component
* @copyright  (C) 2016 RJCreations. All rights reserved.
* @license    GNU General Public License version 3 or later; see LICENSE.txt
*/

defined('JPATH_BASE') or die;

JFormHelper::loadFieldClass('list');

class JFormFieldComponents extends JFormFieldList
{
	protected $type = 'Components';

	protected function getOptions ()
	{
		// Initialise variables.
		$options = array();
		$name = (string) $this->element['name'];

		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select('DISTINCT(extension) AS value')
			->from('#__categories');

		// Get the options.
		$db->setQuery($query);

		try
		{
			$options = $db->loadObjectList();
		}
		catch (RuntimeException $e)
		{
			JError::raiseWarning(500, $e->getMessage());
		}

		foreach ($options as $opt) {
			$opt->text = $opt->value;
		}

		// Merge any additional options in the XML definition.
		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}

}