<?php

declare(strict_types=1);

namespace Pointeger\Cookie\ViewModel;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\View\Element\Template;

/**\
 * Class CustomCookie
 * @package Pointeger\Cookie\ViewModel
 */
class CustomCookie implements ArgumentInterface
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
     * @var Template
     */
    protected $template;

    /**
     * CustomCookie constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param Template $template
     */
    public function __construct(ScopeConfigInterface $scopeConfig, Template $template)
    {
        $this->scopeConfig = $scopeConfig;
        $this->template = $template;
    }

    /**
     * @return mixed
     */
    public function renderCmsBlock()
    {
        if ($blockIdentifier = $this->scopeConfig->getValue('web/cookie/cookie_identifier')) {
            try {
                return $this->template->getLayout()
                    ->createBlock('Magento\Cms\Block\Block')
                    ->setBlockId($blockIdentifier)
                    ->toHtml();
            } catch (\Exception $e) {
                $e->getMessage();
            }
        }
    }
}
