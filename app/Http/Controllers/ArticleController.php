<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function createArticle(Request $request) {
        return Article::createWithReq($request);
    }
    public function fetchArticleList(Request $request) {
        
        return Article::fetchArticleList($request->token);
    }
}
