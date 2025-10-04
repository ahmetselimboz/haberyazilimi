<?php

namespace App\Jobs;

use Exception;
use App\Models\Page;
use App\Models\Post;
use App\Models\User;
use App\Models\Video;
use App\Models\Article;
use App\Models\Category;
use App\Models\OfficialAdvert;
use Illuminate\Support\Str;
use App\Models\PhotoGallery;
use App\Models\PostLocation;
use Illuminate\Bus\Queueable;
use App\Models\PhotoGalleryImages;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TebilisimNewİmportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $sourceTable;
    protected $destinationTable;
    /**
     * Create a new job instance.
     */
    public function __construct($sourceTable, $destinationTable)
    {

        $this->sourceTable = $sourceTable;
        $this->destinationTable = $destinationTable;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $data = DB::connection('hadibaglan');

        // try {
            if ($this->sourceTable == "categories") {
                $sourceData = $data->table($this->sourceTable)->get();
                // HABER KATEGORİLERİ YORUM SATIRI
                # haber kategorileri
                foreach ($sourceData as $haberkat_item) {

                    if(Category::where('id', $haberkat_item->id)->exists()){
                        continue;
                    }

                    $category = new Category();
                    $category->id = $haberkat_item->id;
                    $category->parent_category = ($haberkat_item->parent_id != null) ? strip_tags($haberkat_item->parent_id) : 0;
                    $category->title = strip_tags($haberkat_item->name);
                    $category->slug = slug_format($haberkat_item->name);
                    $category->description = strip_tags($haberkat_item->description);
                    $category->color = strip_tags($haberkat_item->color);
                    $category->show_category_ads = 1;
                    $category->created_at = $haberkat_item->created_at;
                    $category->updated_at = $haberkat_item->updated_at;
                    $category->save();

                }
                $message[] =  "HABER KATEGORİLERİ EKLENDİ";
                ## haber kategorileri
            }

            if ($this->sourceTable == "posts") {
                // PostLocation::truncate();
                // Post::truncate();
                // OfficialAdvert::truncate();
                
                try {
                $sayy = 0;
                $data->table($this->sourceTable)
                    ->orderBy('id',"desc")
                    // ->where('id', '<', 22686)
                    ->chunk(500, function ($sourceData) use ($data, $sayy) {
                        $haberSay = 0;
                        foreach ($sourceData as $haber) {

                            $postCategories = $data->table("categorieables")
                            ->where(['categorieable_id'=>$haber->id,'categorieable_type'=>"TE\Blog\Models\Post"])
                            ->select('category_id')->first();

                            $postProperties =  $data->table('post_properties')
                            ->where('post_id', $haber->id)
                            ->orderBy('id')
                            // ->select('id', 'post_id','description','bik_id','image','created_at','updated_at','comments_off','embed')
                            ->first();

                      
                            $postSlug = $data->table("slugs")
                            ->where(['reference_id'=>$haber->id,'reference_type'=>"TE\Blog\Models\Post"])
                            ->select('key')->first()?->key;

                            if(!$postSlug){
                                $postSlug = $haber->id;
                            }

                            if ($postCategories->category_id  == 1700002 ||  $postCategories->category_id  == 37) {  
                                
                                if(OfficialAdvert::where('id', $haber->id)->exists()){
                                    $haberSay++;
                                    continue;
                                }

                                $aricleContent = $data->table("contents")
                                ->where(['reference_id'=>$haber->id,'reference_type'=>"TE\Blog\Models\Post"])
                                ->select('content')->first()?->content ?? '';
    

                                $officialAdvert = new OfficialAdvert();
                                $officialAdvert->id = $haber->id;
                                $officialAdvert->title = strip_tags($haber->name);
                                $officialAdvert->slug = $postSlug? $postSlug : slug_format($haber->name);
                                $officialAdvert->detail = strip_tags($aricleContent);
                                $officialAdvert->images = $postProperties->image;
                                $officialAdvert->publish = ($haber->status == "published") ? 0 : 1;
                                $officialAdvert->create_date = date("Y-m-d h:i:s", strtotime($haber->created_at));
                                $officialAdvert->created_at = date("Y-m-d h:i:s", strtotime($haber->created_at));
                                $officialAdvert->updated_at =date("Y-m-d h:i:s", strtotime($haber->updated_at));
                                $officialAdvert->category_id = $postCategories->category_id;
                                $officialAdvert->ilan_id = strip_tags($postProperties->bik_id);
                                $officialAdvert->save();
                                $haberSay++;
                                continue;
                            }

                            if(Post::where('id', $haber->id)->exists()){
                                $haberSay++;
                                continue;
                            }

                            $postContent = $data->table("contents")
                            ->where(['reference_id'=>$haber->id,'reference_type'=>"TE\Blog\Models\Post"])
                            ->select('content')->first()->content;


                            $post = new Post();
                            $post->id = $haber->id;
                            $post->category_id = $postCategories->category_id;
                            $post->title = strip_tags($haber->name);
                            $post->slug = $postSlug? $postSlug : slug_format($haber->name);
                            $post->author_id = $haber->author_id;
                            $anahtar_yapistir = [];
                            foreach ($data->table("post_tags")->where('post_id', $haber->id)->select('tag_id')->get() as $keywords_id) {
                                foreach ($data->table("tags")->where('id', $keywords_id->tag_id)->select('name')->get() as $keyword) {
                                    $anahtar_yapistir[] = $keyword->name;
                                }
                            }
                            $post->keywords = implode(",", $anahtar_yapistir);
                            $post->description = Str::limit(strip_tags($postContent),150); 
                            $post->detail = strip_tags($postContent);
                            $post->meta_title = strip_tags($haber->name);
                            $post->meta_description = Str::limit(strip_tags($postContent),150);
                            // $post->detail = $haber->detay;
                            $post->position = 3; // hepsini standart haber ekle
                            // $post->redirect_link = strip_tags($haber->direct_link);
                            $post->show_title_slide = 0;
                            $post->hit = intval($data->table("hits")->where(['reference_id'=>$haber->id,'reference_type'=>"TE\Blog\Models\Post"])->first()?->hit ?? 0);
                            $post->created_at = date("Y-m-d h:i:s", strtotime($haber->created_at));
                            $post->updated_at =date("Y-m-d h:i:s", strtotime($haber->updated_at));
                            $post->publish = ($haber->status == "published") ? 0 : 1;
                            $post->images = $postProperties->image;
                            $fb_image =  $postProperties->image;

                            $extra_array = [
                                "comment_status" => $postProperties->comments_off,
                                "video_embed" => $postProperties->embed ?? "",
                                "fb_image" => $fb_image ?? "",
                                "show_post_ads" => $postProperties->advertising_off,
                                "author" => $haber->author_id,
                            ];
                            $post->extra = json_encode($extra_array);

                            $post->save();

                            //@location 0 => dortlu_manset, 1 => ana_manset, 2 => mini_manset, 3 => standart_haberler, 4 => sondakika_manset

                            // $post->locations()->create([
                            //         'post_id' => $haber->id,
                            //         'location_id' => 3,
                            // ]);

                            //         $post->locations()->create([
                            //             'post_id' => $post->id,
                            //             'location_id' => 1,
                            //         ]);
                            //         $post->locations()->create([
                            //             'post_id' => $post->id,
                            //             'location_id' => 0,
                            //         ]);
         
                            //         $post->locations()->create([
                            //             'post_id' => $post->id,
                            //             'location_id' => 2,
                            //         ]);
                            
                            //         $post->locations()->create([
                            //             'post_id' => $post->id,
                            //             'location_id' => 4,
                            //         ]);


                            $haberSay++;
                        }

                        $sayy += $haberSay;
                        Log::info('HABER   ' .  $sayy);
                                          
                    });
                } catch (\Exception $e) {
                    Log::error('Error in TebilisimNewİmportJob posts import: ' . $e->getMessage());
                    throw $e;
                }
                $message[] = ($sayy) . " ADET HABER  EKLENDİ SON EKLENEN HABER br>";
            }
            if ($this->sourceTable == "video_kategori") {
                $vKaySay = 0;
                $data->table($this->sourceTable)
                    ->orderBy('id')
                    ->chunk(500, function ($sourceData) use ($vKaySay) {

                        foreach ($sourceData as $haberkat_item) {

                            Category::firstOrCreate(
                                [
                                    'id' => $haberkat_item->id,
                                    'category_type' => 2],

                                [
                                    'parent_category' => ($haberkat_item->parent != null) ? strip_tags($haberkat_item->parent) : 0,
                                    'title' => strip_tags($haberkat_item->baslik),
                                    'slug' => slug_format($haberkat_item->baslik),
                                    'description' => strip_tags($haberkat_item->baslik),
                                    'show_category_ads' => 0,
                                    'created_at' => $haberkat_item->tarih,
                                    'updated_at' => $haberkat_item->tarih,
                                ]
                            );
                            $category = new Category();
                            $category->id = $haberkat_item->id;
                            $category->parent_category = ($haberkat_item->parent != null) ? strip_tags($haberkat_item->parent) : 0;
                            $category->title = strip_tags($haberkat_item->baslik);
                            $category->slug = slug_format($haberkat_item->baslik);
                            $category->description = strip_tags($haberkat_item->baslik);
                            $category->category_type = 2;
                            $category->show_category_ads = 0;
                            $category->created_at = $haberkat_item->tarih;
                            $category->save();
                            $vKaySay++;
                        }
                    });
                dump('VİDEO KATEGORİLERİ  ' . $vKaySay);
                $message[] = "VİDEO KATEGORİLERİ EKLENDİ<br>";
            }
            if ($this->sourceTable == "video") {
                $vSay = 0;
                $data->table($this->sourceTable)
                    ->orderBy('id')
                    ->chunk(500, function ($sourceData) use ($vSay) {
                        foreach ($sourceData as $request) {
                            $video = new Video();
                            $video->id = strip_tags($request->id);
                            $video->category_id = strip_tags($request->catid);
                            $video->title = strip_tags($request->baslik);
                            $video->slug = slug_format($request->baslik);
                            $video->detail = $request->aciklama;
                            $video->embed = $request->video_kodu;
                            $video->hit = strip_tags($request->hit == "" ? 0 : $request->hit);
                            $video->publish = ($request->aktif == 1) ? 0 : 1;
                            $video->images = $request->resim;
                            $video->created_at = $request->tarih;
                            $video->save();
                            $vSay++;
                        }
                    });
                dump("VİDEO GALERİLER " . $vSay);
                $message[] =  "VİDEO GALERİLER EKLENDİ<br>";
            }
            if ($this->sourceTable == "albumkat_asil") {

                $vSay = 0;
                $data->table($this->sourceTable)
                    ->orderBy('id')
                    ->chunk(500, function ($sourceData) use ($vSay) {
                        foreach ($sourceData as $haberkat_item) {
                            $category = new Category();
                            $category->id = $haberkat_item->id;
                            $category->parent_category = ($haberkat_item->parent != null) ? strip_tags($haberkat_item->parent) : 0;
                            $category->title = strip_tags($haberkat_item->baslik);
                            $category->slug = slug_format($haberkat_item->baslik);
                            $category->description = strip_tags($haberkat_item->baslik);
                            $category->category_type = 1;
                            $category->show_category_ads = 0;
                            $category->created_at = $haberkat_item->tarih;
                            $category->save();
                            $vSay++;
                        }
                    });
                dump("VİDEO GALERİLER " . $vSay);
                $message[] = "FOTO KATEGORİLERİ EKLENDİ<br>";
            }
            if ($this->sourceTable == "albumkat") {
                $data->table($this->sourceTable)
                    ->orderBy('id')
                    ->chunk(500, function ($sourceData) {
                        foreach ($sourceData as $request) {
                            $photogallery = new PhotoGallery();
                            $photogallery->id = strip_tags($request->id);
                            //$photogallery->category_id = strip_tags($request->catid);
                            $photogallery->category_id = 2;
                            $photogallery->title = strip_tags($request->baslik);
                            $photogallery->slug = slug_format($request->hta);
                            $photogallery->detail = "";
                            $photogallery->hit = strip_tags($request->hit == "" ? 0 : $request->hit);
                            $photogallery->publish = ($request->aktif == 1) ? 0 : 1;
                            $photogallery->images = $request->kapak;
                            $photogallery->created_at = $request->tarih;
                            $photogallery->save();
                        }
                    });
                $message[] = "FOTO GALERİLER KAT EKLENDİ<br>";
            }
            if ($this->sourceTable == "album") {
                $data->table($this->sourceTable)
                    ->orderBy('id')
                    ->chunk(500, function ($sourceData) {
                        foreach ($sourceData as $request) {
                            $result = new PhotoGalleryImages();
                            $result->id = $request->id;
                            $result->photogallery_id = $request->catid;
                            $result->images = $request->resim;
                            $result->title = $request->aciklama;
                            $result->created_at = $request->tarih;
                            $result->save();
                        }
                    });
                $message[] = "FOTO GALERİLER ALBÜM EKLENDİ<br>";
            }
            if ($this->sourceTable == "icerik_icerik") {
                $data->table($this->sourceTable)
                    ->orderBy('id')
                    ->chunk(500, function ($sourceData) {
                        foreach ($sourceData as $request) {
                            $page = new Page();
                            $page->id = strip_tags($request->id);
                            $page->title = strip_tags($request->baslik);
                            $page->slug = slug_format($request->hta);
                            $page->detail = $request->detay;
                            $page->publish = strip_tags($request->aktif);
                            $page->created_at = $request->tarih;
                            $page->save();
                        }
                    });
                $message[] = "İÇERİK EKLENDİ<br>";
            }
            if ($this->sourceTable == "articles") {

                $sourceData =  $data->table($this->sourceTable)
                    ->orderBy('id')->get();

                foreach ($sourceData as $request) {

                    if(Article::where('id', $request->id)->exists()){
                        continue;
                    }

                    $postCategories = $data->table("categorieables")
                    ->where(['categorieable_id'=>$request->id,'categorieable_type'=>"TE\Blog\Models\Post"])
                    ->select('category_id')->first();

                    $aricleContent = $data->table("contents")
                    ->where(['reference_id'=>$request->id,'reference_type'=>"TE\Authors\Models\Article"])
                    ->select('content')->first()->content;

                    $postSlug = $data->table("slugs")
                    ->where(['reference_id'=>$request->id,'reference_type'=>"TE\Authors\Models\Article"])
                    ->select('key')->first()->key;
                    
                    if(Article::where('slug', $postSlug)->exists()){
                        $postSlug = $postSlug . "-" . $request->id;
                    }

                    



                    $article = new Article();
                    $article->id = strip_tags($request->id);
                    $article->title = strip_tags($request->name);
                    $article->slug = slug_format($postSlug);
                    $article->detail = $aricleContent;
                    $article->publish = ($request->status == "published") ? 0 : 1;
                    $article->author_id = $request->user_id;
                    $article->created_at = $request->created_at;
                    $article->updated_at = $request->updated_at;
                    $article->save();
                }
                $message[] = "MAKALELER EKLENDİ<br>";
            }
            if ($this->sourceTable == "users") {
                $sourceData =  $data->table($this->sourceTable)
                    ->orderBy('id')
                    // ->whereNotNull('email')
                    ->get();

                $saveCount = 0;
                foreach ($sourceData as $editor) {

                    if(User::where('id', $editor->id)->exists()){
                        continue;
                    }

                    $editorUser = new User();
                    $editorUser->id = $editor->id;
                    $editorUser->name = strip_tags($editor->first_name).' '.strip_tags($editor->last_name);
                    $editorUser->email = $editor->email ? strip_tags($editor->email) : slug_format($editor->baslik . "-" . $saveCount) . '@yuzhaber.com';
                    $editorUser->about = strip_tags($editor->about);
                    $editorUser->status = 2;
                    $editorUser->avatar = $editor->profile_image;
                    $editorUser->password = Hash::make('11111001');
                    $editorUser->phone = $editor->phone;

                    $editorUser->save();

                    Article::where('author_id', strip_tags($editor->id))->update([
                        'author_id' => $editorUser->id,
                    ]);
                    $saveCount++;
                }
                $message[] = "MAKALELER EKLENDİ<br>";
            }
            if ($this->sourceTable == "authors") {
                $sourceData =  $data->table($this->sourceTable)
                    ->orderBy('id')
                    // ->whereNotNull('email')
                    ->get();

                $saveCount = 0;
                foreach ($sourceData as $editor) {
                  
                    $editorUser = new User();
                    $editorUser->id = $editor->id;
                    $editorUser->name = strip_tags($editor->first_name).' '.strip_tags($editor->last_name);
                    $editorUser->email = $editor->email ? strip_tags($editor->email) : slug_format($editor->baslik . "-" . $saveCount) . '@yuzhaber.com';
                    $editorUser->about = strip_tags($editor->aciklama);
                    $editorUser->status = 2;
                    $editorUser->avatar = $editor->profile_image;
                    $editorUser->password = Hash::make('11111001');
                    $editorUser->phone = $editor->phone;
                    $editorUser->save();

                    Article::where('author_id', strip_tags($editor->id))->update([
                        'author_id' => $editorUser->id,
                    ]);
                    $saveCount++;
                }
                dump($saveCount);
                $message[] = "MAKALELER EKLENDİ<br>";
            }


            Log::info("Database Aktarım Tamamlandı -", $message);
        // } catch (Exception $e) {
        //     // Hata durumunda logla
        //     Log::error('Error in TransferDataJob: ' . $e->getMessage());
        //     throw $e; // Hatanın yukarıya fırlatılması
        // }
    }

    public function failed(\Exception $exception)
    {
        Log::error('Job Failed: ', [
            'sourceTable' => $this->sourceTable,
            'destinationTable' => $this->destinationTable,
            'exception' => $exception->getMessage(),
        ]);
    }
}
