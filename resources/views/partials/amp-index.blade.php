<section id="actualites" class="section-alt hero-content">
    <h2>Actualité</h2>
    <div class="grid">
        @foreach($articles as $article)
            @php
                $typeArticle=(strtolower($article['typearticles']['typearticle']) ==='article') ? 'article' :'communaute';
                $articleUrl = url("amp/". $typeArticle."/" . $article['slug']);
                $articleDate = \Carbon\Carbon::parse($article['datearticle'])->format('Y-m-d\TH:i:s+00:00');
                $today = now()->format('Y-m-d\TH:i:s+00:00');
                $title=$article['titre'];

            @endphp
            <div itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <meta itemprop="position" content="{{ $loop->iteration }}">
                <link itemprop="url" href="{{ $articleUrl }}">
                <div class="card">
                    <amp-img
                        itemprop="image"
                        alt="{{$article['titre']}}"
                        title="{{$title}}"
                        src="{{$article['image']}}"
                        width="400"
                        height="282"
                        layout="responsive">

                    </amp-img>
                    <meta itemprop="datePublished" content="{{ $articleDate }}">
                    <meta itemprop="dateModified" content="{{ $today }}">
                    <meta itemprop="inLanguage" content="fr-FR">
                    <div itemprop="contentLocation" itemscope itemtype="https://schema.org/Place">
                        <meta itemprop="name" content="{{$article['countries']['pays']}}">
                    </div>
                    <div itemprop="interactionStatistic" itemscope itemtype="https://schema.org/InteractionCounter">
                        <meta itemprop="interactionType" content="https://schema.org/ReadAction" />
                        <meta itemprop="userInteractionCount" content="{{$article['hit']}}" />
                    </div>
                    <div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                        <meta itemprop="url" content="{{$article['image']}}" />
                        <meta itemprop="width" content="850" />
                        <meta itemprop="height" content="600" />
                    </div>
                    <meta itemprop="keywords" content="{{$article['keyword']}}" />
                    <meta itemprop="articleSection" content="{{$article['typearticles']['typearticle']}}" />
                    <h3 itemprop="headline">{{$article['titre']}}</h3>
                    <p itemprop="description"> {{$article['chapeau']}}</p>
                    <a href="{{$articleUrl}}" class="btn btn-primary">Lire</a>
                </div>
            </div>

        @endforeach

    </div>
</section>
<div class="news-item">
    <nav>
        <ul class="pagination">
            @if ($articles->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link" style="opacity:0.5;" ><</span>
                </li>
            @else
                <li class="page-item">
                    <a href="{{ $articles->previousPageUrl() }}" class="page-link"><</a>
                </li>
            @endif

            @foreach ($articles->links()->elements[0] ?? [] as $page => $url)

                @if ($page == $articles->currentPage())
                    <li class="page-item active">
                        <span class="page-link">{{$page}}</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page page-link" href="{{$url}}">{{$page}}</a>
                    </li>
                @endif
            @endforeach
            @if ($articles->hasMorePages())
                <li class="page-item">
                    <a href="{{ $articles->nextPageUrl() }}" class="page page-link">></a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link" style="opacity:0.5;">></span>
                </li>
            @endif

        </ul>
    </nav>
</div>
<script type="application/ld+json">
    {!! json_encode($jsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
