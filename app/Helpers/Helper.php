<?php

namespace App\Helpers;

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
}
