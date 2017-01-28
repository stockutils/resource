<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 7/8/2016
 * Time: 7:57 PM
 */
namespace Minute\Menu {

    use App\Model\MAffiliateInfo;
    use Minute\Affiliate\AffiliateInfo;
    use Minute\Cache\QCache;
    use Minute\Config\Config;
    use Minute\Event\ImportEvent;
    use Minute\Session\Session;

    class ResourceMenu {
        public function __construct(){
        }

        public function adminLinks(ImportEvent $event) {
            $links = [
                'stock-resources' => ['title' => 'Stock resources', 'icon' => 'fa-music', 'priority' => 65, 'href' => '/admin/stock/resources'],
            ];

            $event->addContent($links);
        }
    }
}