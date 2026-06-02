<?php

namespace App\Helpers;

use Carbon\Carbon;
use DOMDocument;

class Helper
{
    public static function extractImgSrc(string $html): ?string
    {
        if (strpos($html, '<img') === false) {
            return null;
        }

        preg_match('/<img[^>]+src=["\']([^"\']+)["\']/', $html, $matches);
        $src = $matches[1] ?? null;

        if (!$src) {
            return null;
        }

        // Déjà une URL complète
        if (str_starts_with($src, 'http://') || str_starts_with($src, 'https://')) {
            return $src;
        }

        // URL relative → reconstruction
        $base = 'https://www.hekok.org';
        $src  = ltrim($src, '/');

        return "{$base}/{$src}";
    }

    public static function getTitle($pays, $titre)
    {
        // Si le titre contient déjà le pays, on le retourne tel quel
        if (stripos($titre, $pays) !== false) {
            return $titre;
        }

        // Sinon on préfixe le titre avec le pays
        return "$pays :: $titre";
    }

    public static function guillemets(string $text):string {
        return preg_replace('/"([^"]+)"/u', "«\u{202F}$1\u{202F}»", $text);
    }
    public static function lastSaturday(){
        $today = Carbon::today();
        $dernierSamedi = $today->copy()
            ->endOfMonth()
            ->previous(Carbon::SATURDAY);

        if ($dernierSamedi->lt($today)) {
            $dernierSamedi = $today->copy()
                ->addMonth()
                ->endOfMonth()
                ->previous(Carbon::SATURDAY);
        }
        return $dernierSamedi
            ->locale('fr')
            ->translatedFormat('l d F Y');
    }
    public static function convertImgToAmpImg(string $html){
        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTML(
            mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'),
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );
        $images = $dom->getElementsByTagName('img');
        for ($i = $images->length - 1; $i >= 0; $i--) {

            $img = $images->item($i);

            // New amp-img
            $ampImg = $dom->createElement("amp-img");

            // Copy attributes
            foreach ($img->attributes as $attr) {
                $ampImg->setAttribute($attr->nodeName, $attr->nodeValue);
            }

            // AMP requirements
            if (!$ampImg->hasAttribute("layout")) {
                $ampImg->setAttribute("layout", "responsive");
            }

            if (!$ampImg->hasAttribute("width")) {
                $ampImg->setAttribute("width", "850");
            }

            if (!$ampImg->hasAttribute("height")) {
                $ampImg->setAttribute("height", "600");
            }

            // Replace original <img> with <amp-img>
            $img->parentNode->replaceChild($ampImg, $img);
        }
        return $dom->saveHTML();
    }

    public static function convertYoutubeToAmp(string $html)
    {
        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTML(
            mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'),
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );

        $iframes = $dom->getElementsByTagName('iframe');

        for ($i = $iframes->length - 1; $i >= 0; $i--) {

            $iframe = $iframes->item($i);

            // Extract src
            $src = $iframe->getAttribute("src");
            if (!$src) {
                continue;
            }

            // Detect YouTube link
            if (!preg_match('#(youtube\.com|youtu\.be)#i', $src)) {
                continue;
            }

            // Extract video ID
            $videoId = null;

            // Format: https://www.youtube.com/embed/VIDEOID
            if (preg_match('#youtube\.com/embed/([^?&]+)#', $src, $m)) {
                $videoId = $m[1];
            }

            // Format: https://www.youtube.com/watch?v=VIDEOID
            elseif (preg_match('#v=([^?&]+)#', $src, $m)) {
                $videoId = $m[1];
            }

            // Format: https://youtu.be/VIDEOID
            elseif (preg_match('#youtu\.be/([^?&]+)#', $src, $m)) {
                $videoId = $m[1];
            }

            if (!$videoId) {
                continue;
            }

            // Create <amp-youtube>
            $ampYoutube = $dom->createElement("amp-youtube");
            $ampYoutube->setAttribute("data-videoid", $videoId);
            $ampYoutube->setAttribute("layout", "responsive");

            // Provide default size if missing
            $ampYoutube->setAttribute("width", "480");
            $ampYoutube->setAttribute("height", "270");

            // Replace iframe
            $iframe->parentNode->replaceChild($ampYoutube, $iframe);
        }

        return $dom->saveHTML();
    }

    public static function remove_amp_from_url(string $url): string {
        $parsed = parse_url($url);
        $path = $parsed['path'] ?? '';
        // Remove only leading /amp or /amp/
        $path = preg_replace('#^/amp(/|$)#', '/', $path);

        // Normalize double slashes
        $path = preg_replace('#//+#', '/', $path);
        return ($parsed['scheme'] ?? 'http') . '://' .
            ($parsed['host'] ?? '') .
            (isset($parsed['port']) ? ':' . $parsed['port'] : '') .
            $path .
            (isset($parsed['query']) ? '?' . $parsed['query'] : '') .
            (isset($parsed['fragment']) ? '#' . $parsed['fragment'] : '');
    }

    public static function extract(string $html): array
    {
        $html = html_entity_decode($html, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $html = stripslashes($html);

        $dom = new DOMDocument();

        libxml_use_internal_errors(true);
        $dom->loadHTML(
            mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8')
        );
        libxml_clear_errors();

        $results = [];

        // Extraire depuis <source>
        foreach ($dom->getElementsByTagName('source') as $source) {

            $src = $source->getAttribute('src');

            if ($src) {
                $results = [
                    'src' => $src,
                    'social' => self::detectPlatform($src),
                ];
            }
        }

        // Extraire depuis <video>
        foreach ($dom->getElementsByTagName('video') as $video) {

            $src = $video->getAttribute('src');

            if ($src) {
                $results= [
                    'src' => $src,
                    'social' => self::detectPlatform($src),
                ];
            }
        }

        // Extraire depuis <iframe>
        foreach ($dom->getElementsByTagName('iframe') as $iframe) {

            $src = $iframe->getAttribute('src');

            if ($src) {
                $results = [
                    'src' => $src,
                    'social' => self::detectPlatform($src),
                ];
            }
        }
        //dd($results);
        return $results;
    }
    private static function detectPlatform(string $url): string
    {
        return match (true) {

            str_contains($url, 'youtube.com'),
            str_contains($url, 'youtu.be')
            => 'YouTube',

            str_contains($url, 'facebook.com'),
            str_contains($url, 'fb.watch')
            => 'Facebook',

            str_contains($url, 'instagram.com')
            => 'Instagram',

            str_contains($url, 'tiktok.com')
            => 'TikTok',

            str_contains($url, 'twitter.com'),
            str_contains($url, 'x.com')
            => 'X (Twitter)',

            str_contains($url, 'vimeo.com')
            => 'Vimeo',

            str_contains($url, 'dailymotion.com')
            => 'Dailymotion',

            default => 'Inconnu',
        };
    }

    public static function ExtractSrcVideo($string)
    {

        libxml_use_internal_errors(true);

        $dom = new DOMDocument();


        $html = html_entity_decode($string, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $html=  stripslashes($html);
        $dom->loadHTML(
            mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'),
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );
        libxml_clear_errors();
        $attrs=$string;
        $images = $dom->getElementsByTagName('iframe');
        foreach($images as $im)
        {
            $attrs = $im->getAttribute('src');

            break;

        }

        return $attrs;
    }

    public  static function  getYoutubeKey($img)
    {
        $tmpurl=parse_url(self::ExtractSrcVideo($img));

        list($rien,$embed,$clef)= explode("/", $tmpurl["path"]);
        //dd($clef);
        return $clef;
    }
}
