<?php

namespace App\Console\Commands;

use App\Helpers\Helper;
use App\Models\Article;
//use Illuminate\Console\Attributes\Description;
//use Illuminate\Console\Attributes\Signature;
use App\Models\Membre;
use App\Models\Pays;
use App\Models\Typearticle;
use App\Models\Typemessage;
use Carbon\Carbon;
use Html2Text\Html2Text;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

//#[Signature('app:slug-upd-command')]
//#[Description('Command description')]
class SlugUpdCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:upd-slug-article';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all slugs  in articles';
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('updating slugs...');
        $donnees = DB::connection('mysql_read')->table('typemessages')->get();
        $type_articles = DB::connection('mysql_read')->table('typearticles')->get();
        $countries = DB::connection('mysql_read')->table('pays')->get();
        $membres = DB::connection('mysql_read')->table('membres')->get();
        $articles = DB::connection('mysql_read')->table('articles')->get();

        foreach ($donnees as $row) {
            Typemessage::on('mysql')->updateOrCreate([
                    //'id' => (string) Str::uuid(),
                    'typemessage' => Str::title($row->typemessage),
                    'slug'=>Str::slug($row->typemessage,'-'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

        }
        foreach ($type_articles as $row) {
            Typearticle::on('mysql')->updateOrCreate([
                    //'id' => (string) Str::uuid(),
                    'typearticle' => Str::title($row->typearticle),
                    'slug'=>Str::slug($row->typearticle,'-'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

        }
        foreach ($countries as $row) {
            Pays::on('mysql')->updateOrCreate([
                    'id' => $row->code,
                    'pays' => Str::title($row->pays),
                    'country' => Str::title($row->country),
                    'code3'=>$row->code3,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

        }
        foreach ($membres as $row) {
            $dateinscription=$row->dateinscription==='0000-00-00 00:00:00'?null : $row->dateinscription ;
            $datefinstage=$row->datefinstage==='0000-00-00 00:00:00'?null : $row->datefinstage ;
            $status = (int)$row->actif > 0 ? 'Actif' : 'Inactif';

            Membre::on('mysql')->create(
                //'id' => $row->code,
                [
                    'email' => $row->email, // 🔎 condition unique
                    'datefinstage' => $datefinstage,
                    'nom' => $row->nom,
                    'prenom' => Str::title($row->prenom),
                    'tel' => $row->tel,
                    'statut' => $status,
                    'dateinscription' => $dateinscription,
                    'civilite' => $row->civilite ?? null,
                ]

            );

        }
        foreach ($articles as $row) {

            $countries=Pays::where('id',$row->fkpays)->first();
            $bled = $countries?->pays ?? '';
            $typearticles=$type_articles->where('idtypearticle',$row->fktypearticle)->first();
            $tmpTypearticle=Typearticle::where('slug',Str::slug($typearticles->typearticle))->first();
            $html=new Html2Text($row->article);
            if($countries){
                Article::on('mysql')->updateOrCreate(
                //'id' => $row->code,
                    [
                        'article' => $row->article, // 🔎 condition unique
                        'chapeau' => Str::of($html->getText())->limit(160),
                        'auteur' => Str::title($row->auteur),
                        'source' => Str::title($row->source),
                        'slug' => Str::slug(Helper::getTitle($bled,$row->titre),'-'),
                        'keyword' => $row->keyword,
                        'image' => $row->image,
                        'titre' => $row->titre,
                        'datearticle' => $row->datearticle,
                        'pays_id' => $row->fkpays,
                        'typearticle_id' => $tmpTypearticle->id,
                    ]

                );
            }


        }
        /*$articles=Article::with(['countries','typenews'])->whereNull('slug')->get();
        foreach ($articles as $article){
            if(is_null($article->slug) ){
                if ($article->countries){
                    foreach ($article->countries as $bled){
                        $currentTitle=Helper::getTitle($article->countries->pays,$article->titre);
                        $slug=Str::slug($currentTitle,'-');

                            $article->slug=$slug;
                            $article->save();


                    }
                }



            }

        }*/
        $this->info('Update done successfully');
    }

}
