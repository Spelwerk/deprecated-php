<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 15/02/2017
 * Time: 09:58
 */
global $sitemap;

$admin = new Admin();

$world = null;

if(isset($sitemap->id) && isset($sitemap->hash)) {
    $world = new World($sitemap->id, $sitemap->hash);

} else if (isset($sitemap->id)) {
    $world = new World($sitemap->id);

}

?>

<script src="/js/world.js"></script>

<?php $admin->createWorld($world); ?>
