<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Url;
use App\Models\UrlClick;

class HomeController extends BaseController
{
    public function index()
    {
        helper('url');
        $agent = $this->request->getUserAgent();
        $urls = new Url();
        $segment = $this->request->uri->getSegment(1);
        $url = $urls->where('code', $segment)->first();
        if($url && $url['status'] == 1){
            $urlClick = new UrlClick();
            $urlClick->insert([
                'shorten_url_id' => $url['id'],
                'device' => $agent->isMobile() ? 'mobile' : 'desktop',
                'browser' => $this->request->getUserAgent()->getBrowser(),
                'platform' => $this->request->getUserAgent()->getPlatform(),
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $url['clicks'] = $url['clicks'] + 1;
            $urls->update($url['id'], $url);
            return redirect()->to($url['url']);      
        }
        return view('errors/html/error_404' , ['message' => 'URL IS NOT AVAILABLE OR NOT FOUND']);
    }
}
