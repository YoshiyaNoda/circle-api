<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function saveRawHTML(Request $request) {
        return Article::saveRawHTML($request);
    }
    public function fetchRawHTML(Request $request) {
        return Article::fetchRawHTML($request);
    }
    public function saveArticleData(Request $request) {
        return Article::saveJson($request);
    }
    public function fetchArticleData(Request $request) {
        return Article::fetchArticleData($request);
    }
    public function createArticle(Request $request) {
        return Article::createWithReq($request);
    }
    public function fetchArticleList(Request $request) {
        return Article::fetchArticleList($request->token);
    }
}
