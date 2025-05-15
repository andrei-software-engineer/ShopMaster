<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Order\OrderPrintController;
use App\Orchid\Screens\Order\OrderDetailsListScreen;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;


class PrintController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(Request $request)
    {
        $params = array();

        return $this->GetPrintView('Prints.layouts.mainPrint', $params);     
    }


    public function GetPrintView($view, $params = array(), $otherData = array())
    {
        $request = request();
        $params = (array)$params;
        $params['_mainParams'] = array();
        $params['_mainParams']['_headParams'] = $this->headParams($request);
        $params['_mainParams']['_topContentParams'] = $this->headerParams($request);
        $params['_mainParams']['_footerParams'] = $this->footerParams($request);

        return view($view, $params);
    }


    protected function headParams(Request $request): array
    {
        $rez = array();

        return $rez;
    }


    protected function headerParams(Request $request): array
    {
        $rez = array();
        
        return $rez;
    }


    protected function footerParams(Request $request): array
    {
        $rez = array();
        
        return $rez;
    }


    public function printOrderDetailsPDF(Request $request)
    {
        $id = $request->idorder;
        return $this->prepareOrderDetailsPDF('Prints.Template.Order.printOrderDetails', "OrderDetails", "portrait", $id);
    }


    public static function prepareOrderDetailsPDF($content, $file_name = "", $orientation = "portrait", $id)
    {

        $params = OrderPrintController::getOrderDetailsPDF($id);


        $pdf = PDF::loadView($content, ['data' => $params])->setPaper('a4', $orientation);

        return $pdf->download($file_name.'.pdf');
    }
}