<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\UserContent;
use App\Models\SubscContent;
use DOMWrap\Document;
use GuzzleHttp\Client;


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
            // $dom = \phpQuery::newDocumentFile($url);
            
            $conn = \curl_init(); // cURLセッションの初期化
            \curl_setopt($conn, CURLOPT_URL, $url); //　取得するURLを指定
            \curl_setopt($conn, CURLOPT_RETURNTRANSFER, true); // 実行結果を文字列で返す。
            $res =  \curl_exec($conn);
            \curl_close($conn); //セッションの終了

            $doc = new \DOMWrap\Document;
            $node = $doc->html($res);

            // $client = new \GuzzleHttp\Client();
            // $response = $client->request(
            //     'GET',
            //     $url,// URLを設定
            // );

            // $html = (string) $response->getBody();
            // $doc = new \DOMWrap\Document;
            // $node = $doc->html($html);

            $contentNum = count($node->find('.episode-title')); // エピソード数をカウント
            $lstContentNum = $contentNum -1; // 最新エピソードのインデックスを計算
            $latestContent =  $node->find('.episode-title')->eq(63)->text(); // 最新エピソードのタイトルを取得

            // $contentNum = count($dom->find('.episode-title')); // エピソード数をカウント
            // $lstContentNum = $contentNum -1; // 最新エピソードのインデックスを計算
            // $latestContent =  $dom->find(".episode-title:eq($lstContentNum)")->text(); // 最新エピソードのタイトルを取得

            // var_dump($latestContent); //debug

            if($userContent->lastContent != $latestContent){
                // var_dump("new!");
                $userContent->lastContent = $userContent->currentContent;
                $userContent->currentContent = $latestContent;
                $userContent->watched = 0;
                $userContent->save();

            }
            
        }

        //ビューの表示
        return view('list', ['userContents' => $userContents]);
      }
}
