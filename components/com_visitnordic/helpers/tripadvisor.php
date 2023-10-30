<?php
/**
 * @version     1.0.0
 * @package     com_visitnordic
 * @copyright   Copyright (C) 2015. Alle rettigheder forbeholdes.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      CGOnline.dk <info@cgonline.dk> - http://www.cgonline.dk
 */

defined('_JEXEC') or die;

class VNTripAdvisor
{
    private $api_key = '';
    private $api_url = 'http://api.tripadvisor.com/api/partner/2.0/%s/%s?key=%s';
    private $cache_dir = './';
    private $cache_expiry = 60; // Seconds

    public function __construct($api_key)
    {
        $this->api_key = $api_key;
        $this->cache_dir = JPATH_CACHE . '/tripadvisor-api';

        @mkdir($this->cache_dir . '/', null, true);
        @mkdir($this->cache_dir . '/data/', null, true);
    }

    public function get($location_id)
    {
        $this->updateIfNeeded($location_id);

        $file = $this->cache_dir . '/data/' . $location_id . '.json';
        $data = file_get_contents($file);

        return json_decode($data);
    }

    public function updateIfNeeded($location_id)
    {
        $filename = $this->cache_dir . '/data/' . $location_id . '.json';

        $file_mtime = @filemtime($filename);
        $now = time();
        $file_mtime_offset = $now - $file_mtime;

        if ($file_mtime_offset > $this->cache_expiry) {
            file_put_contents($this->cache_dir . "/api.log", "[$now] Updating $filename because its $file_mtime_offset seconds old.\n", FILE_APPEND);
            $this->update($location_id);
            return;
        }

        file_put_contents($this->cache_dir . "/api.log", "[$now] Skipping Update because its $file_mtime_offset seconds old.\n", FILE_APPEND);
    }

    public function update($location_id)
    {
        $file = $this->cache_dir . '/data/' . $location_id . '.json';
        $url = $this->buildApiUrl('location', $location_id);

        $data = file_get_contents($url);
        file_put_contents($file, $data);
    }

    public function buildApiUrl($type, $params)
    {
        return sprintf($this->api_url, $type, $params, $this->api_key);
    }
}
