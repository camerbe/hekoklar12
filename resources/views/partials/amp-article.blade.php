<section id="actualites" class="section-alt hero-content">
    <article itemscope itemtype="https://schema.org/NewsArticle">
        <link itemprop="url" href="{{ $articleUrl }}">
        <div class="card">
            <amp-img
                title="{{$title}}"
                alt="{{$article['titre']}}"
                src="{{$image}}"
                width="850"
                height="600"
                layout="responsive">


            </amp-img>
            <meta itemprop="thumbnailUrl" content="{{$image}}" />
            <meta itemprop="description" content="{{$description}}" />
            <meta itemprop="datePublished" content="{{ $articleDate }}">
            <meta itemprop="dateModified" content="{{ $today }}">
            <span itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
            <meta itemprop="name" content="Hekok.org" />
            <span itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
              <meta itemprop="url" content="{{ url('assets/img/camer-logo.png')}}" />
              <meta itemprop="width" content="190" />
              <meta itemprop="height" content="52" />
            </span>
        </span>
            <div itemprop="author" itemscope itemtype="https://schema.org/Person">
                <meta itemprop="name" content="{{$author}}">
                <meta itemprop="url" content="{{url()->current()}}" />
            </div>
            <div itemprop="contentLocation" itemscope itemtype="https://schema.org/Place">
                <meta itemprop="name" content="{{$article['countries']['pays']}}">
            </div>
            <div itemprop="interactionStatistic" itemscope itemtype="https://schema.org/InteractionCounter">
                <meta itemprop="interactionType" content="https://schema.org/ReadAction" />
                <meta itemprop="userInteractionCount" content="{{$article['hit']}}" />
            </div>

            <div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                <meta itemprop="url" content="{{$image}}" />
                <meta itemprop="width" content="{{$image_width}}" />
                <meta itemprop="height" content="{{$image_height}}" />
            </div>
            <meta itemprop="keywords" content="{{$keyword}}" />
            <meta itemprop="articleSection" content="{{$typeArticle}}" />
            <meta itemprop="inLanguage" content="fr-FR">
            <em class="news-post-info">
                <span>&copy; {{$article['source']}} : {{$article['auteur']}}</span>  |
                <span>{{ \Carbon\Carbon::parse($article['datearticle'])->translatedFormat('d M Y')}}</span>  |
                <span><i class="fa fa-eye"></i> {{$article['hit']}}</span>
            </em>
            <h3 class="news-post-title uppercase" itemprop="headline" >{{$title}}</h3>

            <div itemprop="articleBody" class="content">
                {!!$newsArticle!!}
                <p class="social-share">
                    <amp-social-share type="twitter" width="45" height="33" data-param-url="{{$canonical}}"></amp-social-share>
                    <amp-social-share type="facebook" width="45" height="33" data-attribution="254325784911610" data-param-url="{{$canonical}}"></amp-social-share>
                    <amp-social-share type="whatsapp" width="45" height="33" data-param-url="{{$canonical}}"></amp-social-share>
                    <amp-social-share type="linkedin" width="45" height="33" data-param-url="{{$canonical}}"></amp-social-share>
                    <amp-social-share type="pinterest" width="45" height="33" data-param-url="{{$canonical}}"></amp-social-share>
                </p>
            </div>
            <em>Pour plus d'informations sur l'actualité, abonnez vous sur :
                <a href="https://chat.whatsapp.com/CtYk9hlYGigJN4k0RDWfYG"><strong> notre chaîne WhatsApp </strong></a>
            </em>

        </div>
    </article>

    <script type="application/ld+json">
        {!! json_encode($jsonLdArticle, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
</section>

