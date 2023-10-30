<?php

$item = $displayData;

/*
$key = '34b970edd35c41eaa42eff296e559d73';
$api = 'http://api.tripadvisor.com/api/partner/2.0/map/42.33141,-71.099396?key=$key';

$test = new VNTripAdvisor($key);

$data = $test->get('245024');

 foreach ($data->reviews as $review) :
     var_dump($review);
endforeach;
*/

$data = new stdClass();
$data->title = '';
$data->text = $item->tripadvisor;

?>

<?php if (!empty($item->tripadvisor)): ?>
    <?php
    $layout = new JLayoutFile('vn.common.text');
    echo $layout->render($data);
    ?>
<?php endif; ?>


