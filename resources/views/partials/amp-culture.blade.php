<amp-accordion animate expand-single-section>
    @foreach($cultures as $culture)
        @php
            $typeArticle=(strtolower($culture['typearticles']['typearticle']) ==='article') ? 'article' :'communaute';
            $articleUrl = url("amp/". $typeArticle."/" . $culture['slug']);
            $articleDate = \Carbon\Carbon::parse($culture['datearticle'])->format('Y-m-d\TH:i:s+00:00');
            $today = now()->format('Y-m-d\TH:i:s+00:00');
            $title=$culture['titre'];

        @endphp
        <section {{ $loop->first ? 'expanded' : '' }}>

            <h4>{{ $culture['titre'] }}</h4>

            <div class="communaute-content card">

                <div class="communaute-image">
                    <amp-img
                        src="{{ $culture['image'] }}"
                        alt="{{ $culture['titre'] }}"
                        width="400"
                        height="282"
                        layout="responsive">
                    </amp-img>
                </div>

                <div class="communaute-text">
                    {!! $culture['chapeau'] !!}
                    <p style="margin-top:20px;">
                        <a href="{{ $articleUrl }}"
                           class="btn btn-primary">
                            Lire
                        </a>
                    </p>
                </div>

            </div>

        </section>
    @endforeach
</amp-accordion>
