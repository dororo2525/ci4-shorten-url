<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\User;
use App\Models\Url;
use App\Models\UrlClick;

class ManageUrlController extends BaseController
{
    public function index()
    {
        helper('url');
        $url = new Url();
        $urls = $url->where('user_id', session()->get('auth')['id'])->findAll();
        return view('backend/manage-url/list' , compact('urls'));
    }



    public function create()
    {
        helper('url');
        $url = new Url();
        $this->validate([
            'url' => 'required|valid_url'
        ]);
        $shorten_url = $this->ShortUrl();
        // var_dump(base_url() . '/' . $shorten_url);die();
        $data = [
            'url' => $this->request->getPost('url'),
            'short_url' => base_url() . $shorten_url,
            'code' => $shorten_url,
            'user_id' => $this->request->getPost('user_id') ?? session()->get('auth')['id'],
            'created_at' => date('Y-m-d H:i:s')
        ];
        try{
            $url->db->transStart();
            $url = new Url();
            $result = $url->insert($data);
            if($result){
                $url->db->transCommit();
                return redirect()->to(base_url('manage-url'))->with('success', 'Url created successfully');
            }
            return redirect()->to(base_url('manage-url'))->with('error', 'Url failed to create');
        } catch (\Exception $e) {
            $url->db->transRollback();
            $this->logger->log('error', $e->getMessage());
            return redirect()->to(base_url('manage-url'))->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $url = new Url();
        $url = $url->where('code', $id)->first();
        return view('backend/manage-url/edit' , compact('url'));
    }

    public function update($id)
    {
        $url = new Url();
        $this->validate([
            'url' => 'required|valid_url',
            'status' => 'required',
        ]);
        $data = [
            'url' => $this->request->getPost('url'),
            'status' => $this->request->getPost('status') ? 1 : 0,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        try{
            $url->db->transStart();
            $result = $url->where('code' , $id)->set($data)->update();
            if($result){
                $url->db->transCommit();
                return redirect()->to(base_url('manage-url'))->with('success', 'Url updated successfully');
            }
            return redirect()->to(base_url('manage-url'))->with('error', 'Url failed to update');
        } catch (\Exception $e) {
            $url->db->transRollback();
            $this->logger->log('error', $e->getMessage());
            return redirect()->to(base_url('manage-url'))->with('error', $e->getMessage());
        }
    }

    public function delete($id)
    {
        $url = new Url();
        $urlclick = new UrlClick();
        try{
            $url->db->transStart();
            $urlData = $url->where('code', $id)->first();
            $result = $url->where('code',$id)->delete();
            if($result){
                $urlclick->where('url_id', $urlData['id'])->delete();
                $url->db->transCommit();
                return response()->setJSON(['status' => true, 'msg' => 'Url ' . $id . ' deleted successfully']);
            }
            return response()->setJSON(['status' => false, 'msg' => 'Url ' . $id . ' failed to delete']);
        } catch (\Exception $e) {
            $url->db->transRollback();
            $this->logger->log('error', $e->getMessage());
            return response()->setJSON(['status' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function report(){
        $code = $this->request->uri->getSegment(2);
        $urls = new Url();
        $url = $urls->where('code', $code)->first();
        if(!$url || $url['user_id'] != session()->get('auth')['id']){
            return redirect()->to(base_url('manage-url'))->with('error', 'Url not found');
        }
        return view('backend/manage-url/report' , compact('url'));
        // var_dump($url->countClicksByMonthRange('2023-05-01' , '2023-07-31')); die();
    }

    public function getReportByCurrentYear(){
        $code = $this->request->getPost('code');
        $urls = new Url();
        $url = $urls->countClicksByCurrentYear($code);
        return response()->setJSON(['status' => true, 'data' => $url]);
    }

    public function getReportByDateRange(){
        $code = $this->request->getPost('code');
        $startDate = $this->request->getPost('startDate');
        $endDate = $this->request->getPost('endDate');
        $urls = new Url();
        $url = $urls->countClicksByMonthRange($code,$startDate , $endDate);
        return response()->setJSON(['status' => true, 'data' => $url]);
    }

    public function ShortUrl(){
        $url = new Url();
        $result = base_convert(rand(1000,99999), 10, 36);
        $check = $url->where('code', $result)->first();

        if($check != null){
            $this->ShortUrl();
        }

        return $result;
    }
    
    public function switchStatus(){
        $url = new Url();
        $id = $this->request->getPost('code');
        $status = $this->request->getPost('status');
        $data = [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        try{
            $url->db->transStart();
            $result = $url->where('code', $id)->set($data)->update();
            if($result){
                $url->db->transCommit();
                return response()->setJSON(['status' => true, 'msg' => 'Url ' . $id . ' updated successfully']);
            }
            return response()->setJSON(['status' => false, 'msg' => 'Url ' . $id . ' failed to update']);
        } catch (\Exception $e) {
            $url->db->transRollback();
            $this->logger->log('error', $e->getMessage());
            return response()->setJSON(['status' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function generateQrCode(){
         // Create a new QRCode writer
         $writer = new Writer(new Png());

         // Set QR code options (e.g., size, color, etc.)
         $writer->setSize(300);
 
         // Generate the QR code image as a string
         $qrCodeData = $writer->writeString('555');
 
         // Set the response content type to image/png
         $this->response->setContentType('image/png');
 
         // Output the QR code image
         echo $qrCodeData;
    }
}
