<amp-accordion animate expand-single-section>
    @foreach($communautes as $communaute)
        @php
            $typeArticle=(strtolower($communaute['typearticles']['typearticle']) ==='article') ? 'article' :'communaute';
            $articleUrl = url("amp/". $typeArticle."/" . $communaute['slug']);
            $articleDate = \Carbon\Carbon::parse($communaute['datearticle'])->format('Y-m-d\TH:i:s+00:00');
            $today = now()->format('Y-m-d\TH:i:s+00:00');
            $title=$communaute['titre'];

        @endphp
        <section {{ $loop->first ? 'expanded' : '' }}>

            <h4>{{ $communaute['titre'] }}</h4>

            <div class="communaute-content card">

                <div class="communaute-image">
                    <amp-img
                        src="{{ $communaute['image'] }}"
                        alt="{{ $communaute['titre'] }}"
                        width="400"
                        height="282"
                        layout="responsive">
                    </amp-img>
                </div>

                <div class="communaute-text">
                    {!! $communaute['chapeau'] !!}
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
