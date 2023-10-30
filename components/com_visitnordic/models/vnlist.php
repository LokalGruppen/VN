<?php
/**
 * @version     1.0.0
 * @package     com_visitnordic
 * @copyright   Copyright (C) 2015. Alle rettigheder forbeholdes.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      CGOnline.dk <info@cgonline.dk> - http://www.cgonline.dk
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Visitnordic List Model.
 */
class VNModelList extends JModelList
{
    public function __construct($config = array())
    {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id', 'a.id',
                'state', 'a.state',
                'category', 'a.category',
                'language', 'a.language',
                'title', 'a.title',
                'alias', 'a.alias',
                'introtext', 'a.introtext',
                'text', 'a.text',
                'address', 'a.address',
                'zip', 'a.zip',
                'city', 'a.city',
                'region', 'a.region',
                'homepage', 'a.homepage',
                'email', 'a.email',
                'fax', 'a.fax',
                'phone', 'a.phone',
                'traffic', 'a.traffic',
                'mapquery', 'a.mapquery',
                'lattitude', 'a.lattitude',
                'longitude', 'a.longitude',
                'speaking', 'a.speaking',
                'links', 'a.links',
                'openinghours', 'a.openinghours',
                'sharing', 'a.sharing',
                'tags', 'a.tags',
                'intromedia', 'a.intromedia',
                'thumbnail', 'a.thumbnail',
                'images', 'a.images',
                'videos', 'a.videos',
                'related', 'a.related',
                'similar', 'a.similar',
                'nearby', 'a.nearby',
                'seealso', 'a.seealso',
                'recommended', 'a.recommended',
                'created', 'a.created',
                'created_by', 'a.created_by',
                'modified', 'a.modified',
                'modified_by', 'a.modified_by',
                //'classification'
            );
        }

        parent::__construct($config);
    }

    public function getItems()
    {
        $items = parent::getItems();
        $db = Factory::getDbo();

        foreach ($items as $item) {
            if (isset($item->category)) {
                $title = VNHelper::getCategoryNameByCategoryId($item->category);
                $item->category = !empty($title) ? $title : $item->category;
            }

            if (isset($item->images)) {
                $item->images = json_decode($item->images);
            }

            if (isset($item->videos)) {
                $item->videos = json_decode($item->videos);
            }

            if (isset($item->links)) {
                $item->links = json_decode($item->links);
            }

            if (isset($item->speaking)) {
                $item->speaking = json_decode($item->speaking);
            }

            if (isset($item->sharing)) {
                $item->sharing = json_decode($item->sharing);
            }

            if (isset($item->tags)) {
                $tags = explode(",", $item->tags);
                $item->tags = array();

                foreach ($tags as $tag) {
                    $query = $db->getQuery(true);
                    $query->select('id,title');
                    $query->from('`#__tags`');
                    $query->where('id = ' . intval($tag));

                    $db->setQuery($query);
                    $rows = (array) $db->loadObjectList();

                    foreach ($rows as $row) {
                        $id = $row->id;
                        $title = $row->title;

                        if ($id && $title) {
                            $item->tags[$id] = $title;
                        }
                    }
                }
            }
        }

        return $items;
    }

    protected function populateState($ordering = 'ordering', $direction = 'ASC')
    {
        $app = Factory::getApplication();
        $user = Factory::getUser();

        // Filter on state for those who do not have edit or edit.state rights
        if ((!$user->authorise('core.edit.state', 'com_visitnordic')) && (!$user->authorise('core.edit', 'com_visitnordic'))) {
            $this->setState('filter.state', 1);
        }

        // Filter on language if Multi language site
        if (JLanguageMultilang::isEnabled()) {
            $this->setState('filter.language', Factory::getLanguage()->getTag());
        }

        // Set layout
        $this->setState('layout', $app->input->getString('layout'));
    }

    protected function getStoreId($id = '')
    {
        // Compile the store id.
        $id .= ':' . serialize($this->getState('filter.state'));
        $id .= ':' . serialize($this->getState('filter.language'));

        return parent::getStoreId($id);
    }

    protected function getListQuery()
    {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        $query
            ->select(
                $this->getState('list.select', 'DISTINCT a.*')
            );

        $query->from($db->qn($this->modeltable) . ' AS a');

        // Join over Category
        $query->select('cat.title AS category_title');
        $query->join('LEFT', $db->quoteName('#__categories') . ' AS cat ON (cat.id = a.category)');

        // Join over Language
        $query->select('l.title AS language_title');
        $query->join('LEFT', $db->quoteName('#__languages') . ' AS l ON (l.lang_code = a.language)');

        // Join over Classifications
        //$query->select('GROUP_CONCAT(cmap.classification SEPARATOR \',\') AS classifications');
        //$query->join('LEFT', $db->quoteName('#__visitnordic_classification_map') .' AS cmap ON (cmap.data_id = a.id AND cmap.data_table = '. $db->q($this->modeltype) .')');
        //$query->join('LEFT', $db->quoteName('#__visitnordic_classifications') .' AS classi ON (classi.id = cmap.classification)');
        $query->group('a.id');

        // Join over Attributes
        $query->select('GROUP_CONCAT(amap.attribute SEPARATOR \',\') AS attributes');
        $query->group('a.id');
        $query->join('LEFT', $db->quoteName('#__visitnordic_attribute_map') . ' AS amap ON (amap.data_id = a.id AND amap.data_table = ' . $db->q($this->modeltype) . ')');
        $query->join('LEFT', $db->quoteName('#__visitnordic_attributes') . ' AS attr ON (attr.id = amap.attribute)');

        // Join over Region
        $query->select('regions.title AS region_title');
        $query->select('regions.city AS region_city');
        $query->select('regions.region AS region_region');
        $query->select('regions.country AS region_country');
        $query->join('LEFT', $db->quoteName('#__visitnordic_regions') . ' AS regions ON (regions.id = a.region)');

        // Filter by state
        if ($state = $this->getState('filter.state')) {
            $query->where('a.state = ' . $db->quote($state));
        }

        // Filter by language
        if ($language = $this->getState('filter.language')) {
            $query->where('a.language = ' . $db->quote($language));
        }

        // Filter by classification
        // Deprecated - Replaced by regular attributes
        //$classification = $this->getState('filter.classification');
        //if (is_numeric($classification))
        //{
        //    $query->where('classi.id = ' . (int) $classification);
        //}

        // Filter by a single tag.
        $tagId = $this->getState('filter.tag');
        if (is_numeric($tagId)) {
            $query->where($db->quoteName('tagmap.tag_id') . ' = ' . (int) $tagId);
            $query->join('LEFT', $db->quoteName('#__contentitem_tag_map', 'tagmap') . ' ON ' . $db->quoteName('tagmap.content_item_id') . ' = ' . $db->quoteName('a.id') . ' AND ' . $db->quoteName('tagmap.type_alias') . ' = ' . $db->quote('com_content.article'));
        }

        // Filter by search in title
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = ' . (int) substr($search, 3));
            } else {
                $search = $db->q('%' . $db->escape($search, true) . '%');

                $where = array();
                foreach ($this->filter_fields as $field) {
                    $parts = (array) explode('.', $field);
                    $fname = end($parts);
                    $where[$fname] = $db->qn($field) . ' LIKE ' . $search . '';
                }

                $query->where('(' . implode(' OR ', $where) . ')');
            }
        }

        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering', 'a.id');
        $orderDirn = $this->state->get('list.direction', 'desc');
        if ($orderCol && $orderDirn) {
            $query->order($db->escape($orderCol . ' ' . $orderDirn));
        }

        return $query;
    }

    protected function loadFormData()
    {
        $app = Factory::getApplication();
        $filters = $app->getUserState($this->context . '.filter', array());
        $error_dateformat = false;

        /*
		foreach ($filters as $key => $value)
		{
			if (strpos($key, '_dateformat') && !empty($value) && !$this->isValidDate($value))
			{
				$filters[$key]    = '';
				$error_dateformat = true;
			}
		}
		if ($error_dateformat)
		{
			$app->enqueueMessage(JText::_("COM_VISITNORDIC_SEARCH_FILTER_DATE_FORMAT"), "warning");
			$app->setUserState($this->context . '.filter', $filters);
		}
        */

        return parent::loadFormData();
    }

    private function isValidDate($date)
    {
        return preg_match("/^(19|20)\d\d[-](0[1-9]|1[012])[-](0[1-9]|[12][0-9]|3[01])$/", $date) && date_create($date);
    }

}
