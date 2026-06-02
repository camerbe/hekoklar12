<?php

namespace App\Console\Commands;

use App\Helpers\Helper;
use App\Models\Video;
//use Illuminate\Console\Attributes\Description;
//use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/*
#[Signature('app:extract-video-key-command')]
#[Description('Command description')]*/
class ExtractVideoKeyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:extract-video-key-command';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update video';
    /**
     * Execute the console command.
     */
    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $this->info('updating Video...');
        //$videos = DB::connection('hekokdb')->table('videos')->get();
        $videos = Video::on('mysql')->get();
        //dd($videos);
        if(!$videos) return;
        foreach ($videos as $row){
            $videoKey=Helper::getYoutubeKey($row->video);
            if(!$videoKey) continue;

            Video::on('mysql')
                    ->where('id',$row->id)
                    ->update([
                    'video'=>$videoKey,
                    'updated_at'=>now(),
                ]);
            $videoKey=null;
        }
        $this->info('Update done successfully');
    }
}
