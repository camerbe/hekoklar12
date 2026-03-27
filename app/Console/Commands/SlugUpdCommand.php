<?php

namespace App\Console\Commands;

use App\Helpers\Helper;
use App\Models\Article;
//use Illuminate\Console\Attributes\Description;
//use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
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
        $articles=Article::with(['countries','typenews'])->whereNull('slug')->get();
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

        }
        $this->info('Update done successfully');
    }

}
