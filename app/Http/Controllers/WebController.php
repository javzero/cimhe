<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Article;
use App\Category;
use App\Tag;
use App\Contact;
use App\CatalogimgArticle;
use App\CatalogimgCategory;
use App\CatalogimgTag;
use Mail;
use App\Mail\WebContactMail;

class WebController extends Controller
{

	public function __construct()
	{
		Carbon::setLocale('es');
	}

	public function home()
    {
        return view('web/web');
	}

	/*
    |--------------------------------------------------------------------------
    | Gallery
    |--------------------------------------------------------------------------
	*/

	public function gallery(Request $request)
	{
		$articles = CatalogimgArticle::search($request->name)->orderBy('id', 'DESC')->where('status', '1')->paginate(12);
		$categories = CatalogimgCategory::all();
		$tags = CatalogimgTag::all();
		if($request->name != null){
			$searchInfo = 'Búsqueda: '. $request->name;
		} else {
			$searchInfo = null;
		}

		return view('web.galeria.galeria')
			->with('articles', $articles)
			->with('categories', $categories)
			->with('tags', $tags)
			->with('searchInfo', $searchInfo);
	}

	
    public function showCatalogimgWithSlug($slug) {

        $article = CatalogimgArticle::where('slug', '=', $slug)->first();
		$categories = CatalogimgCategory::all();
		$tags = CatalogimgTag::all();

		return view('web.galeria.item')
			->with('article', $article)
			->with('categories', $categories)
			->with('tags', $tags);
    }

	public function searchCatalogimgCategory($name)
	{
		$category = CatalogimgCategory::SearchCategory($name)->first();
		$articles = $category->articles()->paginate(12);
		// $articles->each(function($articles){
		// 		$articles->category;
		// 		$articles->images;
		// });
		$searchInfo = 'Categoría: '. $name;
		
		$categories = CatalogimgCategory::all();
		$tags = CatalogimgTag::all();
		
		return view('web.galeria.galeria')
			->with('articles', $articles)
			->with('categories', $categories)
			->with('tags', $tags)
			->with('searchInfo', $searchInfo);
	}

	public function searchCatalogimgTag($name)
    {
        $tag = CatalogimgTag::SearchTag($name)->first();
        $articles = $tag->articles()->paginate(12);

		$searchInfo = 'Etiqueta: '.$name;
		
		$categories = CatalogimgCategory::all();
		$tags = CatalogimgTag::all();

		return view('web.galeria.galeria')
			->with('articles', $articles)
			->with('categories', $categories)
			->with('tags', $tags)
			->with('searchInfo', $searchInfo);
    }

	
    public function viewCatalogimgArticle($id)
    {
        $article = CatalogimgArticle::find($id);
        $categories = CatalogimgCategory::all();
		$tags = CatalogimgTag::all();

		return view('web.galeria.galeria')
			->with('articles', $articles)
			->with('categories', $categories)
			->with('tags', $tags);
	}
	

	/*
    |--------------------------------------------------------------------------
    | BLOG
    |--------------------------------------------------------------------------
	*/

	public function portfolio(Request $request)
	{
        $articles = Article::search($request->title)->orderBy('id', 'DESC')->where('status', '1')->paginate(12);
        $articles->each(function($articles){
            $articles->category;
            $articles->images;
		}); 

		$categories = Category::all();
		$tags = Tag::all();

    	return view('web.blog.blog')
			->with('articles', $articles)
			->with('categories', $categories)
			->with('tags', $tags);
    }

	public function searchCategory($name)
	{
		$category = Category::SearchCategory($name)->first();
		$articles=$category->article()->paginate(12);
		$articles->each(function($articles){
				$articles->category;
				$articles->images;
		});
		
		$categories = Category::all();
		$tags = Tag::all();

		return view('web.blog.blog')
			->with('articles', $articles)
			->with('categories', $categories)
			->with('tags', $tags);
	}

    public function searchTag($name)
    {
        $tag = Tag::SearchTag($name)->first();
        $articles = $tag->article()->paginate(12);
        $articles->each(function($articles){
                $articles->category;
                $articles->images;
        });
		
		$categories = Category::all();
		$tags = Tag::all();

		return view('web.blog.blog')
			->with('articles', $articles)
			->with('categories', $categories)
			->with('tags', $tags);
    }

    public function viewArticle($id)
    {
        $article = Article::find($id);
        $article->each(function($article){
                $article->category;
                $article->images;
                $article->tags;
                $article->colors;
		});
		
        $categories = Category::all();
		$tags = Tag::all();

		return view('web.blog.blog')
			->with('articles', $articles)
			->with('categories', $categories)
			->with('tags', $tags);
    }

    public function showWithSlug($slug) {

        $article = Article::where('slug', '=', $slug)->first();
		$categories = Category::all();
		$tags = Tag::all();

		return view('web.blog.article')
			->with('article', $article)
			->with('categories', $categories)
			->with('tags', $tags);
    }


	/*
    |--------------------------------------------------------------------------
    | CONTACT
    |--------------------------------------------------------------------------
    */

    public function contact()
    {  
        return view('contacto');
    }

	public function mainContactMailSender(Request $request)
    {

		try{
			$contact = new Contact();
			$contact->fill($request->all());
			$contact->save();
			$subject = 'Nuevo contacto desde la web';

            $data = $request->all();
            $view = 'vadmin.components.mailWebContact';

            Mail::to(["comercial@cimhe.com", "cimhe.tecnica@gmail.com"])->send(new WebContactMail($subject, $data, $view));
			
			return response()->json(['response' => 1,
									 'error'    => '0',
									 'message'   => 'Mail sended']); 
		} catch(Exception $e) {
			return response()->json(['response' => 0,
									 'error'    => $e]); 
		}
    }		
    
    public function suelosMailSender(Request $request)
    {
		try{
			$contact = new Contact();
			$contact->fill($request->all());
			$contact->save();
			$subject = 'Solicitud de presupuesto de suelos';

            $data = $request->all();
            $view = 'vadmin.components.mailSuelosContact';

			Mail::to(["cimhe.hys@gmail.com", "cimhe.tecnica@gmail.com"])->send(new WebContactMail($subject, $data, $view));
			
			return response()->json(['response' => 1,
									 'error'    => '0']); 
		} catch(Exception $e) {
			return response()->json(['response' => 0,
									 'error'    => $e]); 
		}
    }		

    public function hormigonMailSender(Request $request)
    {
		try{
			$contact = new Contact();
			$contact->fill($request->all());
			$contact->save();
			$subject = 'Solicitud de presupuesto de suelos';

            $data = $request->all();
            $view = 'vadmin.components.mailHormigonContact';

			Mail::to(["cimhe.tecnica@gmail.com", "cimhe.contable@gmail.com", "comercial@cimhe.com"])->send(new WebContactMail($subject, $data, $view));
			
			return response()->json(['response' => 1,
									 'error'    => '0']); 
		} catch(Exception $e) {
			return response()->json(['response' => 0,
									 'error'    => $e]); 
		}
    }		
    
}
