<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\Stock\Resource {

    use Minute\Config\Config;
    use Minute\Routing\RouteEx;
    use Minute\S3\S3Iterator;
    use Minute\View\Helper;
    use Minute\View\View;

    class Listing {
        const Key = 'resource';
        /**
         * @var Config
         */
        private $config;
        /**
         * @var S3Iterator
         */
        private $s3Iterator;

        /**
         * Listing constructor.
         *
         * @param Config $config
         * @param S3Iterator $s3Iterator
         */
        public function __construct(Config $config, S3Iterator $s3Iterator) {
            $this->config     = $config;
            $this->s3Iterator = $s3Iterator;
        }

        public function index(string $type) {
            $listing = $this->getListing($type);

            print json_encode($listing, JSON_PRETTY_PRINT);
        }

        public function getListing($type) {
            $files = [];

            if ($urls = $this->config->get(self::Key . "/resources/$type/urls")) {
                foreach ($urls as $url) {
                    $ext   = $type == 'music' ? 'mp3' : ($type == 'fonts' ? 'swf' : ($type == 'sfx' ? 'mp3' : ($type == 'videos' ? 'mp4' : '')));
                    $files = array_merge($files, $this->s3Iterator->getBucket($url, $ext));
                }
            }

            return array_values($files) ?: [];
        }
    }
}