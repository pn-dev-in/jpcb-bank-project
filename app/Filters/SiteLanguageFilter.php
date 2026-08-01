<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class SiteLanguageFilter implements FilterInterface
{
    private const LANGUAGES = ['en', 'hi', 'mr'];

    public function before(RequestInterface $request, $arguments = null)
    {
        helper('translation');

        $lang = $request->getGet('lang') ?? $request->getCookie('site_language') ?? session()->get('site_language') ?? 'en';
        $lang = in_array($lang, self::LANGUAGES, true) ? $lang : 'en';

        session()->set('site_language', $lang);
        service('response')->setCookie('site_language', $lang, YEAR);
        service('request')->setLocale($lang);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        helper('translation');

        $lang = current_site_language();
        if ($lang === 'en' || str_starts_with(trim($request->getUri()->getPath(), '/'), 'admin')) {
            return;
        }

        $contentType = $response->getHeaderLine('Content-Type');
        $body = $response->getBody();
        if ($body === '' || ($contentType && !str_contains($contentType, 'text/html'))) {
            return;
        }

        $dictionary = translation_dictionary($lang);
        if (empty($dictionary)) {
            return;
        }

        $translated = $this->translateHtml($body, $dictionary, $lang);
        $response->setBody($translated);
    }

    private function translateHtml(string $html, array $dictionary, string $lang): string
    {
        $previous = libxml_use_internal_errors(true);
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = true;
        $dom->formatOutput = false;

        $loaded = $dom->loadHTML('<?xml encoding="UTF-8">' . $html, LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        if (!$loaded) {
            return $html;
        }

        foreach ($dom->childNodes as $node) {
            if ($node->nodeType === XML_PI_NODE) {
                $dom->removeChild($node);
                break;
            }
        }

        $htmlTag = $dom->getElementsByTagName('html')->item(0);
        if ($htmlTag instanceof \DOMElement) {
            $htmlTag->setAttribute('lang', $lang);
        }

        $xpath = new \DOMXPath($dom);
        $skip = 'ancestor::script or ancestor::style or ancestor::noscript or ancestor::svg or ancestor::code or ancestor::pre or ancestor::textarea';
        foreach ($xpath->query('//text()[normalize-space() != "" and not(' . $skip . ')]') as $node) {
            $node->nodeValue = $this->translateValue($node->nodeValue, $dictionary);
        }

        foreach ($xpath->query('//*[@placeholder or @aria-label or @title or @alt]') as $node) {
            if (!$node instanceof \DOMElement) {
                continue;
            }

            foreach (['placeholder', 'aria-label', 'title', 'alt'] as $attribute) {
                if ($node->hasAttribute($attribute)) {
                    $node->setAttribute($attribute, $this->translateValue($node->getAttribute($attribute), $dictionary));
                }
            }
        }

        return html_entity_decode($dom->saveHTML(), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    private function translateValue(string $value, array $dictionary): string
    {
        $leading = preg_match('/^\s+/u', $value, $m) ? $m[0] : '';
        $trailing = preg_match('/\s+$/u', $value, $m) ? $m[0] : '';
        $key = trim(preg_replace('/\s+/', ' ', $value));

        if (isset($dictionary[$key])) {
            return $leading . $dictionary[$key] . $trailing;
        }

        $translated = $key;
        uksort($dictionary, static fn ($a, $b) => strlen($b) <=> strlen($a));
        foreach ($dictionary as $source => $translation) {
            if (strlen($source) < 4 || !str_contains($translated, $source)) {
                continue;
            }
            $translated = str_replace($source, $translation, $translated);
        }

        return $translated !== $key ? $leading . $translated . $trailing : $value;
    }
}
