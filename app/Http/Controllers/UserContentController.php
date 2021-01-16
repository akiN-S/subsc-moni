<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\UserContent;
use App\Models\SubscContent;
// use App\Lib\phpQuery;


use Illuminate\Http\Request;

class UserContentController extends Controller
{

    //
    public function __construct()
    {
      $this->middleware('auth');
    }


    //
    public function list(Request $request) {
        
        // ユーがモニタしているコンテンツを取得
        $userContents = UserContent::where('userId', Auth::id())->orderBy('id', 'asc')->get();
        $subscContents = array();
        // 新しいコンテンツが配信されていないか確認
        
        $netflixUrl = "https://www.netflix.com/jp/title/";

        foreach ($userContents as $userContent){
            $subscContent = SubscContent::where('id', $userContent->subscContentId)->take(1)->get();
            // var_dump($subscContent[0]->contentLocalId); //debug
            $url = $netflixUrl . $subscContent[0]->contentLocalId;
            // var_dump(\phpQuery::newDocument($html)->find(".episode-title")); //debug

            $dom = \phpQuery::newDocumentFile($url);

            $contentNum = count($dom->find('.episode-title')); // エピソード数をカウント
            $lstContentNum = $contentNum -1; // 最新エピソードのインデックスを計算
            $latestContent =  $dom->find(".episode-title:eq($lstContentNum)")->text(); // 最新エピソードのタイトルを取得

            // var_dump($lastContent); //debug

            if($userContent->lastContent != $latestContent){
                // var_dump("new!");
                $userContent->lastContent = $userContent->currentContent;
                $userContent->currentContent = $latestContent;
                $userContent->watched = 0;
                $userContent->save();
            }
            // var_dump($userContent);
            
        }

        //ビューの表示
        return view('list', ['userContents' => $userContents]);
      }
}
