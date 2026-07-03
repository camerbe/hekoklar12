{{-- resources/views/rss/communaute.blade.php --}}
{!! '<'.'?xml version="1.0" encoding="UTF-8"?>' !!}
<rss version="2.0"
     xmlns:atom="http://www.w3.org/2005/Atom"
     xmlns:content="http://purl.org/rss/1.0/modules/content/"
     xmlns:media="http://search.yahoo.com/mrss/">
    <link>
        <title>Le flux rss de hekok.org</title>
        <link>https://www.hekok.org/</link>
        <description><![CDATA[Hekok.org, Le Munen en nous, la force en chacun ]]></description>
        <language>fr-FR</language>

        <lastBuildDate>{{ now()->toRssString() }}</lastBuildDate>
        <atom:link href="{{ url('/') }}/rss" rel="self" type="application/rss+xml" />
        <atom:link href="https://pubsubhubbub.appspot.com/" rel="hub"/>
        @foreach($items as $item)
            @php
                $image= $item["image"] ?? 'https://picsum.photos/850/600';
                //dd($image);
                 $auteur=str_replace("&", "et", $item["auteur"]);
                 $rub=strtolower($item["typearticles"]["typearticle"]);
                 $titre=App\Helpers\Helper::getTitle($item["countries"]["pays"],$item["titre"]);
            @endphp
            <item>
                <title><![CDATA[{{ $titre }}]]></title>
                <link>{{ url('/' . $rub.'/'.$item["slug"]) }}</link>
                <description>
                    <![CDATA[
                    <p>{!! $item["chapeau"] !!}</p>
                    <p><img src="{{ $image }}" alt="{{ $titre }}" width="850"/></p>

                    ]]>
                </description>
                <guid isPermaLink="true">{{$item["id"]}}</guid>
                <content:encoded><![CDATA[{!! $item["article"] ?? $item["chapeau"] !!}]]></content:encoded>
                <pubDate>{{ \Carbon\Carbon::parse($item["datearticle"])->toRssString()}}</pubDate>
                <author>{{$auteur}}</author>
                <category>{{ $rub }}</category>
                <enclosure url="{{ $image }}" type="webp" length="1250" />
                <media:thumbnail url="{{ $image }}" />
            </item>
        @endforeach
    </channel>
</rss>
