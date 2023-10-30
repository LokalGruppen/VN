

<?php



$options = $displayData;



$id = mt_rand(0, 99);


?>



<?php if (count($options)): ?>



    <div class="map mb-3" id="map<?php echo $id; ?>">

        <?php

        $options['id'] = $id;

        $layout = new JLayoutFile('vn.common.map.google');

        echo $layout->render($options);

        ?>

    </div>



<?php endif; ?>