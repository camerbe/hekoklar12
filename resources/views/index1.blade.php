@php
    //dd($article);
    $today= now()->format('Y-m-d\TH:i:s+00:00');
    $image=\App\Helpers\Helper::extractImgSrc($article['image']);
    $image_width=850;
    $image_height=600;
    $typeArticle=(strtolower($article['typenews']['typearticle'])=='article')? 'article' : 'communaute';
    $articleUrl = url("amp/".$typeArticle."/" . $article['slug']);

    $keyword=$article['keyword'];
    //dd($keyword);
    $year = \Carbon\Carbon::parse($article['datearticle'])->year;
    $articleDate = \Carbon\Carbon::parse($article['datearticle'])->format('Y-m-d\TH:i:s+00:00');
    $description =$article['chapeau'];
    $description = mb_substr($description, 0, 155, 'UTF-8') . '…';
    $section=$typeArticle;
    $author=$article["auteur"];
    $source=$article["source"];
    $canonical= url()->current();
    $modified_time=$now=now()->format('Y-m-d\TH:i:s+00:00');
    $published_time=\Carbon\Carbon::parse($article['datearticle'])->format('Y-m-d\TH:i:s+00:00');
    $titre=\App\Helpers\Helper::getTitle($article['countries']['pays'],$article['titre']);
    $title=$titre;
    //$canonical=\App\Helpers\Helper::remove_amp_from_url($canonical);
    //$canonical=\App\Helpers\Helper::remove_amp_from_url($canonical);
    $newsArticle=\App\Helpers\Helper::convertImgToAmpImg($article['article']);
    $newsArticle=\App\Helpers\Helper::convertYoutubeToAmp($newsArticle);
@endphp
@extends('layouts.amp-master')
@section('content')
    @include('partials.amp-article')
@endsection
