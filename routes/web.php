<?php

use App\Http\Controllers\Auth\LoginController;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/change-locale/{locale}', function ($locale) {
    session()->put('lang', $locale);
    \Illuminate\Support\Facades\App::setLocale($locale);
    return redirect()->route('frontend.index');
})->name('change.locale');

Route::get('login-admin', function () {
    Auth::login(User::find(1));
    return url('secure');
});
Route::get('robots.txt', function () {
    return response()
        ->view('robots')
        ->header('Content-Type', 'text/plain');
});
Route::get('aktar-te', [App\Http\Controllers\AktarController::class, 'aktarte'])->name('aktarte');
Route::get('bakim-modu', [App\Http\Controllers\HomeController::class, 'maintenance'])->name('frontend.maintenance');


Auth::routes();

Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1');
Route::get('/disabled', [App\Http\Controllers\SecureController::class, 'disabled'])->name('panel.disabled');

Route::middleware('rolecheck')->group(function () {
    Route::get('/2fa/active', [App\Http\Controllers\GoogleController::class, 'active'])->name('2fa.active');
    Route::get('/2fa/setup', [App\Http\Controllers\GoogleController::class, 'setup'])->name('2fa.setup');
    Route::post('/2fa/enable', [App\Http\Controllers\GoogleController::class, 'enable'])->name('2fa.enable');
    Route::get('/2fa/verify', [App\Http\Controllers\GoogleController::class, 'verifyForm'])->name('2fa.verify.form');
    Route::post('/2fa/verify', [App\Http\Controllers\GoogleController::class, 'verify'])->name('2fa.verify');
    Route::get('/2fa/disable', [App\Http\Controllers\GoogleController::class, 'disable'])->name('2fa.disable');

});

Route::prefix('secure')->middleware(['rolecheck', 'checkPanel'])->group(function () {
    Route::get('burak-migrate', [App\Http\Controllers\SecureController::class, 'migrate'])->name('migrate');

    Route::get('/', [App\Http\Controllers\SecureController::class, 'index'])->name('secure.index');
    Route::get('/optimize', [App\Http\Controllers\SecureController::class, 'optimize'])->name('optimize');
    Route::get('/jsonsystemcreate', [App\Http\Controllers\SecureController::class, 'jsonsystemcreate'])->name('jsonsystemcreate');
    Route::get('/apijsonfileupdate', [App\Http\Controllers\SettingsController::class, 'apiupdate'])->name('apiupdate');
    Route::get('/activitylogs', [App\Http\Controllers\SecureController::class, 'activitylogs'])->name('activitylogs');
    Route::get('/logs', [App\Http\Controllers\SecureController::class, 'logs'])->name('logs');
    Route::get('/logs/{filename}', [App\Http\Controllers\SecureController::class, 'logDetail'])->name('log.detail');

    # USERS
    Route::get('users', [App\Http\Controllers\UsersController::class, 'index'])->name('users.index');
    Route::get('users/create', [App\Http\Controllers\UsersController::class, 'create'])->name('users.create');
    Route::post('users/create', [App\Http\Controllers\UsersController::class, 'store'])->name('users.store');
    Route::get('users/edit/{id}', [App\Http\Controllers\UsersController::class, 'edit'])->name('users.edit');
    Route::post('users/edit/{id}', [App\Http\Controllers\UsersController::class, 'update'])->name('users.update');
    Route::get('users/destroy/{id}', [App\Http\Controllers\UsersController::class, 'destroy'])->name('users.destroy');
    Route::get('users/trashed', [App\Http\Controllers\UsersController::class, 'trashed'])->name('users.trashed');
    Route::get('users/restore/{id}', [App\Http\Controllers\UsersController::class, 'restore'])->name('users.restore');
    Route::get('users/delete/{id}', [App\Http\Controllers\UsersController::class, 'deleted'])->name('users.delete');

    # CATEGORY
    Route::get('category', [App\Http\Controllers\CategoryController::class, 'index'])->name('category.index');
    Route::get('category/create', [App\Http\Controllers\CategoryController::class, 'create'])->name('category.create');
    Route::post('category/create', [App\Http\Controllers\CategoryController::class, 'store'])->name('category.store');
    Route::get('category/edit/{id}', [App\Http\Controllers\CategoryController::class, 'edit'])->name('category.edit');
    Route::post('category/edit/{id}', [App\Http\Controllers\CategoryController::class, 'update'])->name('category.update');
    Route::get('category/destroy/{id}', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('category.destroy');
    Route::get('category/trashed', [App\Http\Controllers\CategoryController::class, 'trashed'])->name('category.trashed');
    Route::get('category/restore/{id}', [App\Http\Controllers\CategoryController::class, 'restore'])->name('category.restore');

    # POST
    Route::get('post', [App\Http\Controllers\PostController::class, 'index'])->name('post.index');
    Route::get('post/create', [App\Http\Controllers\PostController::class, 'create'])->name('post.create');
    Route::post('post/create', [App\Http\Controllers\PostController::class, 'store'])->name('post.store');
    Route::get('post/edit/{id}', [App\Http\Controllers\PostController::class, 'edit'])->name('post.edit');
    Route::post('post/edit/{id}', [App\Http\Controllers\PostController::class, 'update'])->name('post.update');
    Route::get('post/destroy/{id}', [App\Http\Controllers\PostController::class, 'destroy'])->name('post.destroy');
    Route::get('post/trashed', [App\Http\Controllers\PostController::class, 'trashed'])->name('post.trashed');
    Route::get('post/restore/{id}', [App\Http\Controllers\PostController::class, 'restore'])->name('post.restore');
    Route::post('posteditajaxupdate', [App\Http\Controllers\PostController::class, 'ajaxUpdate'])->name('post.ajaxUpdate');
    Route::post('postallprocess', [App\Http\Controllers\PostController::class, 'ajaxAllProcess'])->name('post.ajaxAllProcess');
    Route::post('ckeditorimageupload', [App\Http\Controllers\PostController::class, 'ckeditorimageupload'])->name('ckeditorimageupload');
    Route::get('homepagejsonallupdate', [App\Http\Controllers\PostController::class, 'MainJsonFileUpdate'])->name('MainJsonFileUpdate');
    Route::get('MainJsonFileUpdateButton', [App\Http\Controllers\PostController::class, 'MainJsonFileUpdateButton'])->name('MainJsonFileUpdateButton');
    Route::post('post/search', [App\Http\Controllers\PostController::class, 'postSearch'])->name('post.search');
    Route::get('post/post-archive', [App\Http\Controllers\PostController::class, 'postArchive'])->name('post_archive');
    Route::post('/gemini-chat', [App\Http\Controllers\GeminiController::class, 'chat'])->name('gemini.chat');
    Route::get('/youtube/get-user-video', [App\Http\Controllers\YoutubeController::class, 'getUserVideo'])->name('youtube.user');
    Route::get('/youtube/get-video-by-title', [App\Http\Controllers\YoutubeController::class, 'getVideoByTitle'])->name('youtube.bytitle');
    Route::post('/post/update-status', [App\Http\Controllers\PostController::class, 'updateStatus'])->name('post.updateStatus');

    # RESİM EDİTÖRÜ
    Route::post('post/editorimageupload', [App\Http\Controllers\PostController::class, 'uploadEditorImages'])->name('post.editor.upload');
    Route::post('post/editorimagesupload', [App\Http\Controllers\PostController::class, 'uploadMultipleEditorImages'])->name('post.editor.upload.multiple');
    Route::post('post/editorimagedelete', [App\Http\Controllers\PostController::class, 'deleteEditorImages'])->name('post.editor.delete');
    Route::get('post/editorimagelist', [App\Http\Controllers\PostController::class, 'listEditorImages'])->name('post.editor.list');
    Route::post('post/originalsave', [App\Http\Controllers\PostController::class, 'originalSaveEditorImages'])->name('post.editor.originalsave');

    # PRODUCT
    Route::get('product', [App\Http\Controllers\ProductController::class, 'index'])->name('product.index');
    Route::get('product/create', [App\Http\Controllers\ProductController::class, 'create'])->name('product.create');
    Route::post('product/create', [App\Http\Controllers\ProductController::class, 'store'])->name('product.store');
    Route::get('product/edit/{id}', [App\Http\Controllers\ProductController::class, 'edit'])->name('product.edit');
    Route::post('product/edit/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('product.update');
    Route::get('product/destroy/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('product.destroy');
    Route::get('product/trashed', [App\Http\Controllers\ProductController::class, 'trashed'])->name('product.trashed');
    Route::get('product/restore/{id}', [App\Http\Controllers\ProductController::class, 'restore'])->name('product.restore');

    # PAGE
    Route::get('page', [App\Http\Controllers\PageController::class, 'index'])->name('page.index');
    Route::get('page/create', [App\Http\Controllers\PageController::class, 'create'])->name('page.create');
    Route::post('page/create', [App\Http\Controllers\PageController::class, 'store'])->name('page.store');
    Route::get('page/edit/{id}', [App\Http\Controllers\PageController::class, 'edit'])->name('page.edit');
    Route::post('page/edit/{id}', [App\Http\Controllers\PageController::class, 'update'])->name('page.update');
    Route::get('page/destroy/{id}', [App\Http\Controllers\PageController::class, 'destroy'])->name('page.destroy');
    Route::get('page/trashed', [App\Http\Controllers\PageController::class, 'trashed'])->name('page.trashed');
    Route::get('page/restore/{id}', [App\Http\Controllers\PageController::class, 'restore'])->name('page.restore');

    # ARTİCLE
    Route::get('article', [App\Http\Controllers\ArticleController::class, 'index'])->name('article.index');
    Route::get('article/create', [App\Http\Controllers\ArticleController::class, 'create'])->name('article.create');
    Route::post('article/create', [App\Http\Controllers\ArticleController::class, 'store'])->name('article.store');
    Route::get('article/edit/{id}', [App\Http\Controllers\ArticleController::class, 'edit'])->name('article.edit');
    Route::post('article/edit/{id}', [App\Http\Controllers\ArticleController::class, 'update'])->name('article.update');
    Route::get('article/destroy/{id}', [App\Http\Controllers\ArticleController::class, 'destroy'])->name('article.destroy');
    Route::get('article/trashed', [App\Http\Controllers\ArticleController::class, 'trashed'])->name('article.trashed');
    Route::get('article/restore/{id}', [App\Http\Controllers\ArticleController::class, 'restore'])->name('article.restore');

    # BIOGRAPHY
    Route::get('biography', [App\Http\Controllers\BiographyController::class, 'index'])->name('biography.index');
    Route::get('biography/create', [App\Http\Controllers\BiographyController::class, 'create'])->name('biography.create');
    Route::post('biography/create', [App\Http\Controllers\BiographyController::class, 'store'])->name('biography.store');
    Route::get('biography/edit/{id}', [App\Http\Controllers\BiographyController::class, 'edit'])->name('biography.edit');
    Route::post('biography/edit/{id}', [App\Http\Controllers\BiographyController::class, 'update'])->name('biography.update');
    Route::get('biography/destroy/{id}', [App\Http\Controllers\BiographyController::class, 'destroy'])->name('biography.destroy');
    Route::get('biography/trashed', [App\Http\Controllers\BiographyController::class, 'trashed'])->name('biography.trashed');
    Route::get('biography/restore/{id}', [App\Http\Controllers\BiographyController::class, 'restore'])->name('biography.restore');

    # Enewspaper
    Route::get('enewspaper', [App\Http\Controllers\EnewspaperController::class, 'index'])->name('enewspaper.index');
    Route::get('enewspaper/create', [App\Http\Controllers\EnewspaperController::class, 'create'])->name('enewspaper.create');
    Route::post('enewspaper/create', [App\Http\Controllers\EnewspaperController::class, 'store'])->name('enewspaper.store');
    Route::get('enewspaper/edit/{id}', [App\Http\Controllers\EnewspaperController::class, 'edit'])->name('enewspaper.edit');
    Route::post('enewspaper/edit/{id}', [App\Http\Controllers\EnewspaperController::class, 'update'])->name('enewspaper.update');
    Route::get('enewspaper/destroy/{id}', [App\Http\Controllers\EnewspaperController::class, 'destroy'])->name('enewspaper.destroy');
    Route::get('enewspaper/trashed', [App\Http\Controllers\EnewspaperController::class, 'trashed'])->name('enewspaper.trashed');
    Route::get('enewspaper/restore/{id}', [App\Http\Controllers\EnewspaperController::class, 'restore'])->name('enewspaper.restore');

    Route::get('enewspaper-images/{id}', [App\Http\Controllers\EnewspaperController::class, 'enewspaperimages'])->name('enewspaperimages');
    Route::post('enewspaper-images/{id}', [App\Http\Controllers\EnewspaperController::class, 'enewspanvperimagespost'])->name('enewspaperimagespost');
    Route::post('enewspaper-image/update/{id}', [App\Http\Controllers\EnewspaperController::class, 'enewspaperimageupdate'])->name('enewspaperimageupdate');
    Route::post('enewspaper-image/update', [App\Http\Controllers\EnewspaperController::class, 'enewspaperimageupdateNotID'])->name('enewspaperimageupdateNotID');
    Route::post('enewspaper-image/sortby', [App\Http\Controllers\EnewspaperController::class, 'enewspaperimagesortby'])->name('enewspaperimagesortby');
    Route::post('enewspaper-image/delete/{id}', [App\Http\Controllers\EnewspaperController::class, 'enewspaperimagedelete'])->name('enewspaperimagedelete');
    Route::post('enewspaper-image/delete', [App\Http\Controllers\EnewspaperController::class, 'enewspaperimagedeleteNotID'])->name('enewspaperimagedeleteNotID');



    # Comment
    Route::get('comment', [App\Http\Controllers\CommentController::class, 'index'])->name('comment.index');
    Route::get('comment/edit/{id}', [App\Http\Controllers\CommentController::class, 'edit'])->name('comment.edit');
    Route::post('comment/edit/{id}', [App\Http\Controllers\CommentController::class, 'update'])->name('comment.update');
    Route::get('comment/destroy/{id}', [App\Http\Controllers\CommentController::class, 'destroy'])->name('comment.destroy');
    Route::get('comment/trashed', [App\Http\Controllers\CommentController::class, 'trashed'])->name('comment.trashed');
    Route::get('comment/restore/{id}', [App\Http\Controllers\CommentController::class, 'restore'])->name('comment.restore');


    # VIDEO GALLERY
    Route::get('video', [App\Http\Controllers\VideoController::class, 'index'])->name('video.index');
    Route::get('video/create', [App\Http\Controllers\VideoController::class, 'create'])->name('video.create');
    Route::post('video/create', [App\Http\Controllers\VideoController::class, 'store'])->name('video.store');
    Route::get('video/edit/{id}', [App\Http\Controllers\VideoController::class, 'edit'])->name('video.edit');
    Route::post('video/edit/{id}', [App\Http\Controllers\VideoController::class, 'update'])->name('video.update');
    Route::get('video/destroy/{id}', [App\Http\Controllers\VideoController::class, 'destroy'])->name('video.destroy');
    Route::get('video/trashed', [App\Http\Controllers\VideoController::class, 'trashed'])->name('video.trashed');
    Route::get('video/restore/{id}', [App\Http\Controllers\VideoController::class, 'restore'])->name('video.restore');

    # PHOTO GALLERY
    Route::get('photogallery', [App\Http\Controllers\PhotoGalleryController::class, 'index'])->name('photogallery.index');
    Route::get('photogallery/create', [App\Http\Controllers\PhotoGalleryController::class, 'create'])->name('photogallery.create');
    Route::post('photogallery/create', [App\Http\Controllers\PhotoGalleryController::class, 'store'])->name('photogallery.store');
    Route::get('photogallery/edit/{id}', [App\Http\Controllers\PhotoGalleryController::class, 'edit'])->name('photogallery.edit');
    Route::post('photogallery/edit/{id}', [App\Http\Controllers\PhotoGalleryController::class, 'update'])->name('photogallery.update');
    Route::get('photogallery/destroy/{id}', [App\Http\Controllers\PhotoGalleryController::class, 'destroy'])->name('photogallery.destroy');
    Route::get('photogallery/trashed', [App\Http\Controllers\PhotoGalleryController::class, 'trashed'])->name('photogallery.trashed');
    Route::get('photogallery/restore/{id}', [App\Http\Controllers\PhotoGalleryController::class, 'restore'])->name('photogallery.restore');
    Route::get('photogalleryimages/{id}', [App\Http\Controllers\PhotoGalleryController::class, 'photogalleryimages'])->name('photogalleryimages');
    Route::post('photogalleryimages/{id}', [App\Http\Controllers\PhotoGalleryController::class, 'photogalleryimagespost'])->name('photogalleryimagespost');
    Route::post('photogalleryimage/update/{id}', [App\Http\Controllers\PhotoGalleryController::class, 'photogalleryimageupdate'])->name('photogalleryimageupdate');
    Route::post('photogalleryimage/update', [App\Http\Controllers\PhotoGalleryController::class, 'photogalleryimageupdateNotID'])->name('photogalleryimageupdateNotID');
    Route::post('photogalleryimage/sortby', [App\Http\Controllers\PhotoGalleryController::class, 'photogalleryimagesortby'])->name('photogalleryimagesortby');
    Route::post('photogalleryimage/delete/{id}', [App\Http\Controllers\PhotoGalleryController::class, 'photogalleryimagedelete'])->name('photogalleryimagedelete');
    Route::post('photogalleryimage/delete', [App\Http\Controllers\PhotoGalleryController::class, 'photogalleryimagedeleteNotID'])->name('photogalleryimagedeleteNotID');

    # SURVEY
    Route::get('survey', [App\Http\Controllers\SurveyController::class, 'index'])->name('survey.index');
    Route::get('survey/create', [App\Http\Controllers\SurveyController::class, 'create'])->name('survey.create');
    Route::post('survey/create', [App\Http\Controllers\SurveyController::class, 'store'])->name('survey.store');
    Route::get('survey/edit/{id}', [App\Http\Controllers\SurveyController::class, 'edit'])->name('survey.edit');
    Route::post('survey/edit/{id}', [App\Http\Controllers\SurveyController::class, 'update'])->name('survey.update');
    Route::get('survey/destroy/{id}', [App\Http\Controllers\SurveyController::class, 'destroy'])->name('survey.destroy');
    Route::get('survey/trashed', [App\Http\Controllers\SurveyController::class, 'trashed'])->name('survey.trashed');
    Route::get('survey/restore/{id}', [App\Http\Controllers\SurveyController::class, 'restore'])->name('survey.restore');

    # ADS
    Route::get('ads', [App\Http\Controllers\AdsController::class, 'index'])->name('ads.index');
    Route::get('ads/edit/{id}', [App\Http\Controllers\AdsController::class, 'edit'])->name('ads.edit');
    Route::post('ads/edit/{id}', [App\Http\Controllers\AdsController::class, 'update'])->name('ads.update');

    # FIRM
    Route::get('firm', [App\Http\Controllers\FirmController::class, 'index'])->name('firm.index');
    Route::get('firm/create', [App\Http\Controllers\FirmController::class, 'create'])->name('firm.create');
    Route::post('firm/create', [App\Http\Controllers\FirmController::class, 'store'])->name('firm.store');
    Route::get('firm/edit/{id}', [App\Http\Controllers\FirmController::class, 'edit'])->name('firm.edit');
    Route::post('firm/edit/{id}', [App\Http\Controllers\FirmController::class, 'update'])->name('firm.update');
    Route::get('firm/destroy/{id}', [App\Http\Controllers\FirmController::class, 'destroy'])->name('firm.destroy');
    Route::get('firm/trashed', [App\Http\Controllers\FirmController::class, 'trashed'])->name('firm.trashed');
    Route::get('firm/restore/{id}', [App\Http\Controllers\FirmController::class, 'restore'])->name('firm.restore');

    # CLSFAD
    Route::get('clsfad', [App\Http\Controllers\ClsfadController::class, 'index'])->name('clsfad.index');
    Route::get('clsfad/create', [App\Http\Controllers\ClsfadController::class, 'create'])->name('clsfad.create');
    Route::post('clsfad/create', [App\Http\Controllers\ClsfadController::class, 'store'])->name('clsfad.store');
    Route::get('clsfad/edit/{id}', [App\Http\Controllers\ClsfadController::class, 'edit'])->name('clsfad.edit');
    Route::post('clsfad/edit/{id}', [App\Http\Controllers\ClsfadController::class, 'update'])->name('clsfad.update');
    Route::get('clsfad/destroy/{id}', [App\Http\Controllers\ClsfadController::class, 'destroy'])->name('clsfad.destroy');
    Route::get('clsfad/trashed', [App\Http\Controllers\ClsfadController::class, 'trashed'])->name('clsfad.trashed');
    Route::get('clsfad/restore/{id}', [App\Http\Controllers\ClsfadController::class, 'restore'])->name('clsfad.restore');

    # OFFİCAL ADVERT
    $module_name = "official_advert";
    Route::get('official-advert', [App\Http\Controllers\OfficialAdvertController::class, 'index'])->name("$module_name.index");
    Route::get("official-advert/create", [App\Http\Controllers\OfficialAdvertController::class, 'create'])->name("$module_name.create");
    Route::post("official-advert/create", [App\Http\Controllers\OfficialAdvertController::class, 'store'])->name("$module_name.store");
    Route::get("official-advert/edit/{id}", [App\Http\Controllers\OfficialAdvertController::class, 'edit'])->name("$module_name.edit");
    Route::post("official-advert/edit/{id}", [App\Http\Controllers\OfficialAdvertController::class, 'update'])->name("$module_name.update");
    Route::get("official-advert/destroy/{id}", [App\Http\Controllers\OfficialAdvertController::class, 'destroy'])->name("$module_name.destroy");
    Route::get("official-advert/trashed", [App\Http\Controllers\OfficialAdvertController::class, 'trashed'])->name("$module_name.trashed");
    Route::get("official-advert/restore/{id}", [App\Http\Controllers\OfficialAdvertController::class, 'restore'])->name("$module_name.restore");

    # MENUS
    Route::get('menus', [App\Http\Controllers\SettingsController::class, 'menus'])->name('menus');
    Route::get('menus-create', [App\Http\Controllers\SettingsController::class, 'menusCreate'])->name('menusCreate');
    Route::get('menus/{id}', [App\Http\Controllers\SettingsController::class, 'menusID'])->name('menusID');
    Route::post('menusajax', [App\Http\Controllers\SettingsController::class, 'menusAjax'])->name('menusajax');
    Route::get('menutrashed/{id}', [App\Http\Controllers\SettingsController::class, 'menuTrashed'])->name('menutrashed');

    # MESSAGE
    Route::get('message', [App\Http\Controllers\SecureController::class, 'message'])->name('message');

    # SEO CHECK
    Route::get('seo-check/{type}', [App\Http\Controllers\SecureController::class, 'seocheck'])->name('seocheck');

    # AGENCY
    Route::get('agency/{title}', [App\Http\Controllers\SecureController::class, 'agency'])->name('agency');

    # SETTİNGS
    Route::get('settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings');
    Route::post('settings', [App\Http\Controllers\SettingsController::class, 'settingsupdate'])->name('settings.update');

    # API MODULES
    Route::get('weatherupdate', [App\Http\Controllers\SettingsController::class, 'weather']);
    Route::get('prayerupdate', [App\Http\Controllers\SettingsController::class, 'prayer']);
    Route::get('currencyupdate', [App\Http\Controllers\SettingsController::class, 'apiupdate']);
    // Route::get('currency', [App\Http\Controllers\SettingsController::class, 'currency']);
    // Route::get('gold', [App\Http\Controllers\SettingsController::class, 'gold']);
    // Route::get('coin', [App\Http\Controllers\SettingsController::class, 'coin']);
    // Route::get('bist', [App\Http\Controllers\SettingsController::class, 'bist']);

    # SORTABLE
    Route::get('sortableSlide', [App\Http\Controllers\SortableController::class, 'sortableSlide'])->name('sortableSlide');
    Route::post('sortableSlide', [App\Http\Controllers\SortableController::class, 'sortableSlidePost'])->name('sortableSlidePost');
    Route::get('sortableHomePage', [App\Http\Controllers\SortableController::class, 'sortableHomePage'])->name('sortableHomePage');
    Route::post('sortableHomePage', [App\Http\Controllers\SortableController::class, 'sortableHomePagePost'])->name('sortableHomePagePost');
    Route::post('sortableHomePagePostOtherSetting', [App\Http\Controllers\SortableController::class, 'sortableHomePagePostOtherSetting'])->name('sortableHomePagePostOtherSetting');

    #AJANSLAR
    // Route::get('/iha', [App\Http\Controllers\AgenciesController::class, 'getIhaNews'])->name('iha');
    // Route::post("/iha/post", [App\Http\Controllers\AgenciesController::class, "getIhaNewsPost"])->name("getIhaNewsPost");

    Route::get('/agencies/{agency}', [App\Http\Controllers\AgenciesController::class, 'getNews'])->name('agencies');
    Route::post("/agencies/post", [App\Http\Controllers\AgenciesController::class, "getIhaNewsPost"])->name("agencies.post");

    #GOOGLE
    Route::get('/auth/google', [App\Http\Controllers\GoogleController::class, "authGoogle"])->name('google.connect')->withoutMiddleware('checkPanel');
    Route::get('/auth/google/callback', [App\Http\Controllers\GoogleController::class, "callbackGoogle"])->withoutMiddleware('checkPanel');
    Route::get("/logout", [App\Http\Controllers\GoogleController::class, "logout"])->name("logoutGoogle")->withoutMiddleware('checkPanel');

    #GOOGLE GMAIL
    Route::get('/gmail', [App\Http\Controllers\MailController::class, 'getGmailPage'])->name('gmail');
    Route::post("/gmail/post", [App\Http\Controllers\MailController::class, "getGmailPost"])->name("getGmailPost");

    #GOOGLE ANALYTIC
    Route::get('google-analytic', [App\Http\Controllers\AnalyticController::class, 'getGoogleAnalyticPage'])->name('googleAnalytic')->withoutMiddleware('checkPanel');
    Route::get('analytic-page-all-data', [App\Http\Controllers\AnalyticController::class, 'fetchAllData'])->name('fetchAllData')->withoutMiddleware('checkPanel');
    Route::get('analytic-page-device-category', [App\Http\Controllers\AnalyticController::class, 'fetchAllDeviceCategory'])->name('fetchAllDeviceCategory')->withoutMiddleware('checkPanel');
    Route::get('analytic-page-operating-system', [App\Http\Controllers\AnalyticController::class, 'fetchAllOperatingSystem'])->name('fetchAllOperatingSystem')->withoutMiddleware('checkPanel');
    Route::get('analytic-page-browser', [App\Http\Controllers\AnalyticController::class, 'fetchAllBrowser'])->name('fetchAllBrowser')->withoutMiddleware('checkPanel');

    #GOOGLE ANALYTIC - Habere özel istatistik getiren route
    Route::get('/post-stats', [App\Http\Controllers\AnalyticController::class, 'getArticleStats'])->name('getArticleStats')->withoutMiddleware('checkPanel');

    #GOOGLE ANALYTIC - Anasayfa istatistik getiren route
    Route::get('/homepage-stats', [App\Http\Controllers\AnalyticController::class, 'getHomepageStats'])->name('getHomepageStats')->withoutMiddleware('checkPanel');


    #IMAGE GALLERY
    Route::get('/image-gallery', [App\Http\Controllers\ImageGalleryController::class, 'index'])->name('image-gallery');
    Route::delete('/galeri/{filename}', [App\Http\Controllers\ImageGalleryController::class, 'destroy'])->name('gallery.destroy');
    Route::get('/gallery/modal-content', [App\Http\Controllers\ImageGalleryController::class, 'modalContent'])->name('gallery.modal.content');

    #SERP
    Route::get('/serp', [App\Http\Controllers\GoogleController::class, 'serp'])->name('serp');


    #GOOGLE TRENDS
    Route::get('/trends', [App\Http\Controllers\GoogleController::class, 'trends'])->name('trends');
    Route::get('/get-trends', [App\Http\Controllers\GoogleController::class, 'getTrends'])->name('getTrends');


    #PLUGINS
    Route::get('/plugins', [App\Http\Controllers\PluginsController::class, 'index'])->name('plugins.index');
    Route::get('/plugin-market', [App\Http\Controllers\PluginsController::class, 'market'])->name('plugin.market');

});

Route::prefix('secure')->middleware(['rolecheckeditor'])->group(function () {
    Route::get('/', [App\Http\Controllers\SecureController::class, 'index'])->name('secure.index');
    Route::get('/optimize', [App\Http\Controllers\SecureController::class, 'optimize'])->name('optimize');


    Route::get('users/edit/{id}', [App\Http\Controllers\UsersController::class, 'edit'])->name('users.edit');
    Route::post('users/edit/{id}', [App\Http\Controllers\UsersController::class, 'update'])->name('users.update');

    # CATEGORY
    Route::get('category', [App\Http\Controllers\CategoryController::class, 'index'])->name('category.index');
    Route::get('category/create', [App\Http\Controllers\CategoryController::class, 'create'])->name('category.create');
    Route::post('category/create', [App\Http\Controllers\CategoryController::class, 'store'])->name('category.store');
    Route::get('category/edit/{id}', [App\Http\Controllers\CategoryController::class, 'edit'])->name('category.edit');
    Route::post('category/edit/{id}', [App\Http\Controllers\CategoryController::class, 'update'])->name('category.update');
    Route::get('category/destroy/{id}', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('category.destroy');
    Route::get('category/trashed', [App\Http\Controllers\CategoryController::class, 'trashed'])->name('category.trashed');
    Route::get('category/restore/{id}', [App\Http\Controllers\CategoryController::class, 'restore'])->name('category.restore');

    # POST
    Route::get('post', [App\Http\Controllers\PostController::class, 'index'])->name('post.index');
    Route::get('post/create', [App\Http\Controllers\PostController::class, 'create'])->name('post.create');
    Route::post('post/create', [App\Http\Controllers\PostController::class, 'store'])->name('post.store');
    Route::get('post/edit/{id}', [App\Http\Controllers\PostController::class, 'edit'])->name('post.edit');
    Route::post('post/edit/{id}', [App\Http\Controllers\PostController::class, 'update'])->name('post.update');
    Route::get('post/destroy/{id}', [App\Http\Controllers\PostController::class, 'destroy'])->name('post.destroy');
    Route::get('post/trashed', [App\Http\Controllers\PostController::class, 'trashed'])->name('post.trashed');
    Route::get('post/restore/{id}', [App\Http\Controllers\PostController::class, 'restore'])->name('post.restore');
    Route::post('posteditajaxupdate', [App\Http\Controllers\PostController::class, 'ajaxUpdate'])->name('post.ajaxUpdate');
    Route::post('postallprocess', [App\Http\Controllers\PostController::class, 'ajaxAllProcess'])->name('post.ajaxAllProcess');
    Route::post('ckeditorimageupload', [App\Http\Controllers\PostController::class, 'ckeditorimageupload'])->name('ckeditorimageupload');
    Route::get('homepagejsonallupdate', [App\Http\Controllers\PostController::class, 'MainJsonFileUpdate'])->name('MainJsonFileUpdate');
    Route::get('MainJsonFileUpdateButton', [App\Http\Controllers\PostController::class, 'MainJsonFileUpdateButton'])->name('MainJsonFileUpdateButton');
});

Route::middleware(['theme', 'maintenance', 'frontmid'])->group(function () {

    // Route::get('sitemap', [App\Http\Controllers\HomeController::class, 'sitemap'])->name('sitemap');
    Route::get('sitemap-news', [App\Http\Controllers\HomeController::class, 'sitemapNews'])->name('sitemapNews');
    Route::get('sitemap-google', [App\Http\Controllers\HomeController::class, 'sitemapgoogle'])->name('sitemapgoogle');
    Route::get('sitemap.xml', [App\Http\Controllers\HomeController::class, 'sitemapList'])->name('sitemapList');
    Route::get('generate-news-sitemap/{year?}', [App\Http\Controllers\HomeController::class, 'generateNewsSitemap'])->name('generateNewsSitemap');
    Route::get('generate-category-sitemap', [App\Http\Controllers\HomeController::class, 'generateCategorySitemap'])->name('generateCategorySitemap');
    Route::get('generate-article-sitemap/{year?}', [App\Http\Controllers\HomeController::class, 'generateArticleSitemap'])->name('generateArticleSitemap');



    Route::get('', [App\Http\Controllers\HomeController::class, 'index'])->name('frontend.index');
    Route::get('sayfa/{slug}', [App\Http\Controllers\HomeController::class, 'page'])->name('page');
    Route::get('foto-galeriler', [App\Http\Controllers\HomeController::class, 'photo_galleries'])->name('photo_galleries');
    Route::get('foto-galeri/{categoryslug?}/{slug}/{id}', [App\Http\Controllers\HomeController::class, 'photo_gallery'])->name('photo_gallery');
    Route::get('video-galeriler', [App\Http\Controllers\HomeController::class, 'video_galleries'])->name('video_galleries');
    Route::get('video-galeri/{categoryslug?}/{slug}/{id}', [App\Http\Controllers\HomeController::class, 'video_gallery'])->name('video_gallery');
    Route::get('yazarlar', [App\Http\Controllers\HomeController::class, 'authors'])->name('authors');
    Route::get('makale/{slug}/{id}', [App\Http\Controllers\HomeController::class, 'article'])->name('article');
    Route::get('{author}/{slug}', [App\Http\Controllers\HomeController::class, 'newArticle'])->name('frontend_article');

    Route::post('yorumgonder/{type}/{post_id}', [App\Http\Controllers\HomeController::class, 'commentsubmit'])->middleware('throttle:1,1')->name('commentsubmit');
    Route::post('makale-gonder', [App\Http\Controllers\HomeController::class, 'articlesend'])->name('articlesend');
    Route::post('arama', [App\Http\Controllers\HomeController::class, 'search'])->name('search');
    Route::get('arama', [App\Http\Controllers\HomeController::class, 'search'])->name('search.get');


    Route::post('uye-girisi', [App\Http\Controllers\HomeController::class, 'userloginfrontend'])->middleware('throttle:5,1')->name('userloginfrontend');
    Route::post('uye-kayit', [App\Http\Controllers\HomeController::class, 'userregisterfrontend'])->name('userregisterfrontend');
    Route::post('profil-guncelle', [App\Http\Controllers\HomeController::class, 'userprofileupdate'])->name('userprofileupdate');
    Route::get('profilim', [App\Http\Controllers\HomeController::class, 'userprofile'])->name('userprofile');
    Route::get('oturum-kapat', [App\Http\Controllers\HomeController::class, 'userlogout'])->name('userlogout');

    Route::get('/resize-image', [\App\Http\Controllers\ImageController::class, 'resizeImage'])->name("resizeImage");
    Route::get('rss/{category?}', [App\Http\Controllers\HomeController::class, 'rss'])->name('rss');
    Route::get('resmi-ilanlar', [App\Http\Controllers\HomeController::class, 'officialAdvert'])->name('home.offficial_advert');
    Route::get('resmi-ilanlar/{id?}', [App\Http\Controllers\HomeController::class, 'officialAdvertDetail'])->name('home.offficial_advert_detail');
    Route::post('artice-image-upload', [App\Http\Controllers\HomeController::class, 'ckeditorimageupload'])->name('home.ckeditorimageupload');

    Route::get('egazete', [App\Http\Controllers\HomeController::class, 'eNews'])->name('home.enews');
    Route::get('egazete/{id}', [App\Http\Controllers\HomeController::class, 'eNewsDetail'])->name('home.enews-detail');
    Route::post('e-news-images', [App\Http\Controllers\HomeController::class, 'enewsImages'])->name('home.enewsImages');


    Route::post('/notify-news', [App\Http\Controllers\HomeController::class, 'notifyNews'])->name('notify.news');



    //wordpress haber entegrasyonu için kullanılan route
    /*
    Route::get('public',function (){
        return redirect( route('frontend.index'),301);
    });
    Route::get('public/{slug}',  function ($slug){
        return redirect( route('category',$slug),301);
    });
    /////////////////////

    */
    Route::get('{slug}', [App\Http\Controllers\HomeController::class, 'category'])->name('category');
    Route::get('/category/{slug}/load-more', [App\Http\Controllers\HomeController::class, 'loadMore'])->name('category.loadMore');
    Route::get('{categoryslug?}/{slug?}/{id?}', [App\Http\Controllers\HomeController::class, 'post'])->name('post');
    Route::get('amp/{categoryslug?}/{slug?}/{id?}', [App\Http\Controllers\HomeController::class, 'amppost'])->name('amppost');


});
