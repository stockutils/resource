<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 11/26/2016
 * Time: 11:23 PM
 */
namespace Minute\S3 {

    use App\Controller\Stock\Resource\Listing;
    use Aws\S3\S3Client;
    use Minute\Aws\Client;
    use Minute\Cache\FileCache;
    use Minute\Cache\QCache;
    use Minute\Config\Config;
    use Minute\Error\AwsError;

    class S3Iterator {
        /**
         * @var Config
         */
        private $config;
        /**
         * @var QCache
         */
        private $cache;

        /**
         * S3Iterator constructor.
         *
         * @param Config $config
         * @param QCache $cache
         */
        public function __construct(Config $config, FileCache $cache) {
            $this->config = $config;
            $this->cache  = $cache;
        }

        public function getBucket($url, $ext = '') {
            $results = $this->cache->get("s3-$url-$ext", function () use ($url, $ext) {
                if ($config = $this->config->get(Listing::Key . '/s3config', $this->config->get(Client::AWS_KEY . '/services/s3'))) {
                    try {
                        $params = ['credentials' => ['key' => $config['key'], 'secret' => $config['secret']], 'version' => 'latest', 'http' => ['verify' => false],
                                   'region' => $config['region'] ?? 'us-east-1'];
                        if ($s3 = new S3Client($params)) {
                            $host = ltrim(parse_url($url, PHP_URL_PATH), '/');
                            list($bucket, $path) = explode('/', $host, 2);

                            if ($objects = $s3->getIterator('ListObjects', array('Bucket' => $bucket, 'Prefix' => $path))) {
                                foreach ($objects as $object) {
                                    if ($object['Size'] > 0) {
                                        $fn   = $object['Key'];
                                        $name = basename($fn);

                                        if (empty($ext) || preg_match("/\\.($ext)$/", $name)) {
                                            $url    = $config['cdn'] ? sprintf('%s/%s/%s', $config['cdn'], $path, $object['Key']) : $s3->getObjectUrl($bucket, $object['Key']);
                                            $result = ['name' => $this->fix_name(pathinfo($name, PATHINFO_FILENAME)), 'url' => $url];

                                            if (preg_match("!$path/(\\w+)!", dirname($fn), $matches)) {
                                                $result['category'] = $matches[1];
                                            }

                                            $results[] = $result;
                                        }
                                    }
                                }
                            }
                        }
                    } catch (\Exception $e) {
                        throw new AwsError("Error connecting to S3: " . $e->getMessage(), $e);
                    }
                }

                return $results ?? [];
            }, 86400);

            return $results ?? [];
        }

        private function fix_name($name) {
            return ucfirst(strtolower(join(' ', preg_split('/[\W\_]+/', $name))));
        }
    }
}