<?php

if (!function_exists('site_languages')) {
    function site_languages(): array
    {
        return [
            'en' => ['name' => 'English', 'locale' => 'en-IN'],
            'hi' => ['name' => 'Hindi', 'locale' => 'hi-IN'],
            'mr' => ['name' => 'Marathi', 'locale' => 'mr-IN'],
        ];
    }
}

if (!function_exists('current_site_language')) {
    function current_site_language(): string
    {
        $lang = session()->get('site_language') ?? service('request')->getCookie('site_language') ?? 'en';
        return array_key_exists($lang, site_languages()) ? $lang : 'en';
    }
}

if (!function_exists('language_url')) {
    function language_url(string $lang): string
    {
        $request = service('request');
        $params = $request->getGet();
        $params['lang'] = $lang;

        return current_url() . '?' . http_build_query($params);
    }
}

if (!function_exists('translation_dictionary')) {
    function translation_dictionary(string $lang): array
    {
        static $cache = [];

        if ($lang === 'en') {
            return [];
        }

        if (isset($cache[$lang])) {
            return $cache[$lang];
        }

        try {
            $rows = \Config\Database::connect()
                ->table('site_translations')
                ->select('source_text, translation')
                ->where('language', $lang)
                ->where('status', 1)
                ->where('translation !=', '')
                ->get()
                ->getResultArray();
        } catch (\Throwable $e) {
            return $cache[$lang] = [];
        }

        $dictionary = [];
        foreach ($rows as $row) {
            $source = trim(preg_replace('/\s+/', ' ', (string) $row['source_text']));
            if ($source !== '') {
                $dictionary[$source] = (string) $row['translation'];
            }
        }

        return $cache[$lang] = $dictionary;
    }
}

if (!function_exists('translate_text')) {
    function translate_text(?string $text, ?string $lang = null): string
    {
        $text = (string) $text;
        $lang = $lang ?? current_site_language();
        if ($lang === 'en' || trim($text) === '') {
            return $text;
        }

        $leading = preg_match('/^\s+/u', $text, $m) ? $m[0] : '';
        $trailing = preg_match('/\s+$/u', $text, $m) ? $m[0] : '';
        $key = trim(preg_replace('/\s+/', ' ', $text));
        $dictionary = translation_dictionary($lang);

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

        return $translated !== $key ? $leading . $translated . $trailing : $text;
    }
}
