<?php

namespace scanSites\ScanBundle\Controller;

use GuzzleHttp\Stream\GuzzleStreamWrapper;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Tests\Functional\app\AppKernel;

class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($url)
    {
        $html = [
            'max_execution_time' => ini_get('max_execution_time'),
            'memory_limit' => ini_get('memory_limit'),
        ];
        define('MAX_PAGES', 2);
        $intCachedLinks = [];
        if (isset($_GET['domains'])) {
            $html['items'] = [];
            $domain = $_GET['domains'];
            $domain = str_replace('http://', '', $domain);
            $domain = str_replace('https://', '', $domain);
            $domain = str_replace('/', '', $domain);
            $html['domain'] = $domain;
            $data = $this->getData($domain, '/');
            $html['items'][] = $data;
            if (isset($data['intLinks'])) {
                foreach ($data['intLinks'] as $n => $item) {
                    if ($n < MAX_PAGES) {
                        $html['items'][] = $this->getData($domain, $item);
                    }
                }
            }
        }
        return $this->render('ScanBundle:Default:index.html.twig',$html);
    }

    private function getData($domain, $thisUrl) {
        $outLinks = [];
        $intLinks = [];
        $tempLinksArray = [];
        /** @var \GuzzleHttp\ClientInterface $guzzle */
        $guzzle = $this->get('guzzle.client');

        try {
            $response = $guzzle->get('http://' . $domain . $thisUrl);
            if ($response->getStatusCode() == 200) {
                $code = (string) $response->getBody();
                preg_match_all('/<a.*?href="([^"]+)".*?>/', $code, $urls);
                foreach ($urls[1] as $url) {
                    if ($url != '/' && substr($url, 0, 1) != '#') {
                        if (
                            substr($url, 0, strlen('http://' . $domain)) == 'http://' . $domain ||
                            (substr($url, 0, 1) == '/' && substr($url, 1, 1) != '/') ||
                            strpos($url, '/') == false
                        ) {
                            $newUrl = urldecode(str_replace('http://' . $domain, '', $url));
                            if (substr($newUrl, 0, 1) != '/') {
                                $newUrl = '/' . $newUrl;
                            }
                            $isInt = true;
                            try {
                                $test = $guzzle->get('http://' . $domain . $newUrl);
                                $len = strlen('http://' . $domain);
                                if (substr($test->getEffectiveUrl(), 0, $len) != 'http://' . $domain) {
                                    $isInt = false;
                                    if (!in_array($test->getEffectiveUrl(), $tempLinksArray)) {
                                        $outLinks[] = [
                                            'url' => urldecode($url),
                                            'redirectedTo' => $test->getEffectiveUrl(),
                                            'code' => $test->getStatusCode()
                                        ];
                                        $tempLinksArray[] = urldecode($url);
                                    }
                                }
                            } catch (\Exception $e) {
                                $outLinks[] = [
                                    'url' => urldecode($url),
                                    'redirectedTo' => '?',
                                    'code' => 'error'
                                ];
                            }
                            if (!in_array($newUrl, $intLinks) && !empty($newUrl) && $isInt == true) {
                                $intLinks[] = $newUrl;
                            }
                        } else {
                            if (!in_array(urldecode($url), $tempLinksArray)) {
                                $tempLinksArray[] = urldecode($url);
                                $outLinks[] = ['url' => urldecode($url)];
                            }
                        }
                    }

                }
                sort($intLinks);

                return [
                    'thisPage' => $thisUrl,
                    'intLinks' => $intLinks,
                    'outLinks' => $outLinks,
                    'relsCount' => substr_count($code, 'rel="noindex nofollow"')
                ];
            } else {

                return ['error' => 'Ошибка ' . $response->getStatusCode() . ': ' . $response->getReasonPhrase()];
            }
        } catch (\Exception $e) {
            return ['error' => 'Ошибка ' . $e->getCode() . ': ' . $e->getMessage()];
        }
    }
}
