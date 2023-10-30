<?php
require_once JPATH_BASE.'/vendor/autoload.php';
use \Gumlet\ImageResize;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

defined('_JEXEC') or die;

class VNHelper
{
    public static function getCollection($id = 0)
    {
        if ((int) $id) {
            $model = JModelLegacy::getInstance('Collection', 'VisitnordicModel');
            return $model->getData((int) $id);
        }

        return false;
    }

    public static function getCategoryNameByCategoryId($category_id)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);

        $query
            ->select('title')
            ->from('#__categories')
            ->where('id = ' . intval($category_id));

        $db->setQuery($query);
        return $db->loadResult();
    }

    public static function getLanguageCode($tag = null)
    {
        if (!$tag) {
            $tag = Factory::getLanguage()->getTag();
        }

        $tag = strtolower($tag);

        if ($tag == 'zh-cn') {
            return 'cn';
        }
        if ($tag == 'zh-tw') {
            return 'zh';
        }
        if ($tag == 'en-gb') {
            return 'en';
        }

        $parts = explode('-', $tag);
        return $parts[0];
    }
}

class VNHTMLHelper
{

    private static $cacheVideoFolder = 'cache/videos/';
    private static $cacheVideoTimeout = 15778463;

    private static $cacheImageFolder = 'cache/';

    public static function repeatableToArray($input = '')
    {
        $items = array();

        if (is_string($input)) {
            $input = json_decode($input, true);
        }

        if (!is_array($input) && !is_object($input)) {
            return $items;
        }

        foreach ($input as $key => $values) {
            for ($i = 0; $i < count($values); $i++) {
                if (!isset($items[$i])) {
                    $items[$i] = new stdClass();
                }

                $items[$i]->$key = $values[$i];
            }
        }

        return $items;
    }

    public static function cleanLinks($links = array())
    {
        foreach ($links as $key => $link) {
            if (empty($link->href)) {
                unset($links[$key]);
                continue;
            }

            $link->href = static::cleanLink($link->href);
        }

        return $links;
    }

    public static function cleanLink($link = '')
    {
        if (substr(strtolower($link), 0, 4) !== 'http') {
            $link = 'http://' . $link;
        }

        return $link;
    }

    public static function cleanPhonenumber($phone = '', $trim = false)
    {
        if ($trim) {
            $phone = preg_replace('/\s+/', '', $phone);
        }

        if (substr(strtolower($phone), 0, 1) !== '+') {
            $phone = '+' . $phone;
        }

        return $phone;
    }

    public static function cleanImages($images = array())
    {
        foreach ($images as $key => $image) {
            $image->type = 'image';

            if (empty($image->source)) {
                unset($images[$key]);
                continue;
            }

            if (!isset($image->title)) {
                $image->title = '';
            }
            $image->title = nl2br($image->title);

            if (!isset($image->text)) {
                $image->text = '';
            }
            $image->text = nl2br($image->text);

            if (!isset($image->credit)) {
                $image->credit = '';
            }
            $image->credit = nl2br($image->credit);
        }

        return $images;
    }

    public static function cleanVideos($videos = array())
    {
        foreach ($videos as $key => $video) {
            $video->type = 'video';

            if (!$video->source) {
                unset($videos[$key]);
                continue;
            }

            if (!isset($video->title)) {
                $video->title = '';
            }
            $video->title = nl2br($video->title);

            if (!isset($video->text)) {
                $video->text = '';
            }
            $video->text = nl2br($video->text);

            if (!isset($video->credit)) {
                $video->credit = '';
            }
            $video->credit = nl2br($video->credit);

            // Original url
            $video->url = $video->source;

            // Get thumbnail of video
            $type = VisitnordicVideoHelper::getType($video->url);
            $thumb = '';
            $url = '';
            if ($type) {
                $fnc = 'get' . $type . 'Thumbnail';
                $thumb = call_user_func(array('VisitnordicVideoHelper', $fnc), $video->url);

                $fnc = 'get' . $type . 'Link';
                $url = call_user_func(array('VisitnordicVideoHelper', $fnc), $video->url);
            }
            if ($url) {
                $video->url = $url;
            }
            if (!$thumb) {
                $thumb = VisitnordicVideoHelper::nothumb();
            }
            $video->source = $thumb;
        }

        return $videos;
    }

    public static function getResizedImage($file, $width = null, $height = null, $refresh = false)
    {
        /* Check if file is a remote image */
        if (filter_var($file, FILTER_VALIDATE_URL) && !file_exists(JPATH_ROOT.'/images/'.md5($file).'.jpg')) {
            $newfile = md5($file).'.jpg';
            if(@copy($file, JPATH_ROOT.'/images/'.$newfile)) {
                chmod(JPATH_ROOT . '/images/' . $newfile, 0755);
                $file = 'images/' . $newfile;
            }
        }

        if(!file_exists(JPATH_ROOT.'/'.$file)) {
            return $file;
        }

        $fileData = pathinfo($file);

        if (!empty($width) || !empty($height)) {
            if (empty($height)) {
                $cacheFileName = $fileData['filename'].'-'.$width;
            } elseif (empty($width)) {
                $cacheFileName = $fileData['filename'].'-'.$height;
            } else {
                $cacheFileName = $fileData['filename'].'-'.$width.'x'.$height;
            }
            $cacheFileName = $cacheFileName.'.jpg';
        } else {
            $cacheFileName = $fileData['basename'];
        }

        $cacheFilePath = self::$cacheImageFolder.$cacheFileName;

        if (file_exists(JPATH_ROOT.'/'.$cacheFilePath) && !$refresh) {
            return Factory::getApplication()->get('cdn') ? Factory::getApplication()->get('cdn').$cacheFilePath : $cacheFilePath;
        }

        try {
            $resizeImage = new \Gumlet\ImageResize($file);
            if (!empty($width) || !empty($height)) {
                if (empty($height)) {
                    $resizeImage->resizeToWidth($width, true);
                } elseif (empty($width)) {
                    $resizeImage->resizeToHeight($height, true);
                } else {
                    $resizeImage->crop($width, $height, ImageResize::CROPCENTER);
                }
            }
            $resizeImage->save($cacheFilePath, IMAGETYPE_JPEG, 100, 0755);

            $log = new Logger('loghandler');
            $log->pushHandler(new StreamHandler(JPATH_ROOT.'/errors.log', Logger::WARNING));

            $optimizerChain = Spatie\ImageOptimizer\OptimizerChainFactory::create();
            $optimizerChain->useLogger($log)->optimize($cacheFilePath);

        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return Factory::getApplication()->get('cdn') ? Factory::getApplication()->get('cdn').$cacheFilePath : $cacheFilePath;
    }

    public static function getUrlDomain($url, $maxlength = 50)
    {
        $host = @parse_url($url, PHP_URL_HOST);

        if (!$host) {
            $host = $url;
        }

        if (substr($host, 0, 4) == "www.") {
            $host = substr($host, 4);
        }

        if (strlen($host) > $maxlength) {
            $host = substr($host, 0, $maxlength) . '...';
        }

        return $host;
    }

    public static function truncate($string, $length = 30, $suffix = '...', $striptags = false)
    {
        if ($striptags) {
            $string = strip_tags($string, (is_string($striptags) ? $striptags : null));
        }


        if (strlen($string) > $length) {
            $string = mb_strimwidth($string, 0, $length, $suffix, 'utf-8');
        }

        return $string;
    }
}

class VNViewHelper
{
    public static function setMetaData($type, $view = null, $item, $params)
    {
        $app = Factory::getApplication();
        $doc = Factory::getDocument();

        $meta_title = $item->meta_title;
        $meta_description = $item->meta_description;
        $robots = $item->robots;

        $city = @$item->city;  // fallback
        $code = VNHelper::getLanguageCode();
        if (@$item->region && $item->region->id != 9999) {
            $key = ($code == 'en' ? 'country' : 'country-' . $code);
            if (isset($item->region->$key) && $item->region->$key) {
                $city = $item->region->$key;
            }
        }

        if (!empty($meta_title)) {
            $title = JText::sprintf('COM_VISITNORDIC_' . strtoupper($type) . '_META_TITLE1', $meta_title, $app->get('sitename'));
        } else if ($item->title && $city) {
            $title = JText::sprintf('COM_VISITNORDIC_' . strtoupper($type) . '_META_TITLE2', $item->title, $city, $app->get('sitename'));
        } else if ($item->title) {
            $title = JText::sprintf('COM_VISITNORDIC_' . strtoupper($type) . '_META_TITLE1', $item->title, $app->get('sitename'));
        } elseif ($app->get('sitename_pagetitles', 0) == 1) {
            $title = JText::sprintf('JPAGETITLE', $app->get('sitename'));
        } elseif ($app->get('sitename_pagetitles', 0) == 2) {
            $title = JText::sprintf('JPAGETITLE', $app->get('sitename'));
        }

        $title = str_ireplace('##CITY##', (string) $city, $title);
        $title = str_ireplace('##TITLE##', $item->title, $title);

        $doc->setTitle($title);

        if (!empty($meta_description)) {
            $meta_description = JText::sprintf('COM_VISITNORDIC_' . strtoupper($type) . '_META_DESC1', $meta_description, $app->get('sitename'));
        } else {
            //$meta_description = $params->get('menu-meta_description');
            $meta_description = JText::sprintf('COM_VISITNORDIC_' . strtoupper($type) . '_META_DESC1', ($type == 'collection' ? @$item->intro_description : @$item->description), $app->get('sitename'));
        }

        $doc->setDescription($meta_description);

        if ($params->get('menu-meta_keywords')) {
            $doc->setMetadata('keywords', $params->get('menu-meta_keywords'));
        }

        if ($robots) {
            switch ($robots) {
                case 1:
                    $doc->setMetadata('robots', 'Index, Follow');
                    break;
                case 2:
                    $doc->setMetadata('robots', 'No index, Follow');
                    break;
                case 2:
                    $doc->setMetadata('robots', 'Index, No follow');
                    break;
                case 2:
                    $doc->setMetadata('robots', 'No index, No follow');
                    break;
            }
        } else if ($params->get('robots')) {
            $doc->setMetadata('robots', $view->get('robots'));
        }
    }
}
