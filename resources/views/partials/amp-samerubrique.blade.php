<div class="related-articles">

    @foreach($related as $item)
        @php

            $typeArticle=strtolower($item['typearticles']['typearticle']);
            $articleUrl = url("amp/". $typeArticle."/" . $item['slug']);
        @endphp
        <a href="{{ $articleUrl }}" class="related-item">

            <amp-img
                class="flex-1"
                src="{{ $item['image'] }}"

                layout="fixed"
                alt="{{ $item['titre']  }}">
            </amp-img>

            <h3>{{ $item['titre'] }}</h3>

        </a>
    @endforeach

</div>
