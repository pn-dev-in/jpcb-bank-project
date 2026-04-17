<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    protected $siteSettings;
    protected $socialLinks;
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Load here all helpers you want to be available in your controllers that extend BaseController.
        // Caution: Do not put the this below the parent::initController() call below.
        $this->helpers = ['url', 'log', 'form'];

        // Caution: Do not edit this line.
        parent::initController($request, $response, $logger);

        $settingsModel = new \App\Models\SettingsModel();
        $this->siteSettings = $settingsModel->find(1);

        if (!$this->siteSettings) {
            $settingsModel->insert([
                'site_name' => 'JPCB',
                'phone' => '0257-2220055',
                'email' => 'info@jpcb.in',
                'footer_address' => 'Main Road, Jalgaon, Maharashtra'
            ]);

            $this->siteSettings = $settingsModel->find(1);
        }

        // 🔥 MAKE AVAILABLE IN ALL VIEWS
        \Config\Services::renderer()->setData(['siteSettings' => $this->siteSettings]);
        service('renderer')->setVar('siteSettings', $this->siteSettings);

        $socialModel = new \App\Models\SocialLinkModel();
        $this->socialLinks = $socialModel->where('status', 1)->orderBy('sort_order', 'asc')->findAll();
        service('renderer')->setVar('socialLinks', $this->socialLinks);

        // Preload any models, libraries, etc, here.
        // $this->session = service('session');
    }
}
