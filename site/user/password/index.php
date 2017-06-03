<?php global $sitemap;

switch($sitemap->index) {
    default:
        require_once('./site/user/password/reset.php');
        break;

    case 'verify':
        require_once('./site/user/password/verify.php');
        break;
}
?>