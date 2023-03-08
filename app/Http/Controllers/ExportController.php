<?php

namespace App\Http\Controllers;

use App\HelperClasses\Traits\ApiResponse;
use App\Models\Staff;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use Spatie\SimpleExcel\SimpleExcelWriter;

class ExportController extends Controller
{
    use ApiResponse;

    public function export_data(Request $request){

        $query = (new AdvanceSearchController())->searchQuery($request);

        if (is_array($query)) {
            return $this->sendApiSuccessResponse([], 'No data found');
        }
        $search_by=$request->get('search_by');
        $data = $query->get();
        $header_style = (new StyleBuilder())
                        ->setFontBold()
                        ->setFontSize(10)
                        ->setShouldWrapText()
                         ->setCellAlignment('left')
                         ->build();

        $rows_style = (new StyleBuilder())
            ->setFontSize(10)
            ->setShouldWrapText()
            ->setCellAlignment('left')
            ->build();
        if($search_by=='staff'){
            return (new FastExcel($data))
                ->headerStyle($header_style)
                ->rowsStyle($rows_style)
                ->download('staff.xlsx',function ($data) {
                return [
                   'कर्मचारी को नाम'=>$data->title,
                    'कर्मचारी को पदनाम'=>$data->designation,
                    'इमेल'=>$data->email,
                    'फोन'=>$data->phone,
                    'स्थानीय सरकार'=>$data->localgovernment_name

                ];
            });
        }
        if($search_by=='elected_representative'){
            return (new FastExcel($data)) ->headerStyle($header_style)
                ->rowsStyle($rows_style)->download('elected_representative.xlsx',function ($data) {
                return [
                    'निर्वाचित प्रतिनिधि'=>$data->title,
                    'प्रतिनिधि को पदनाम'=>$data->designation,
                    'इमेल'=>$data->email,
                    'फोन'=>$data->phone,
                    'स्थानीय सरकार'=>$data->localgovernment_name
                ];
            });
        }
        if($search_by=='website_directory'){
            return (new FastExcel($data)) ->headerStyle($header_style)
                ->rowsStyle($rows_style)->download('website_directory.xlsx',function ($data) {
                return [
                    'वेबसाइट को नाम'=>$data->name,
                    'जिल्ला'=>$data->district,
                    'प्रकार'=>$data->type,
                    'वेबसाइट'=>$data->website,
                ];
            });
        }
        if($search_by=='document'){
            $excelData =$data->map(function ($item, $key) {
                return [
                    'कागजात को नाम'=>$item->title,
                    'कागजात को प्रकार'=>$item->document_type,
                    'स्थानीय सरकार'=>$item->localgovernment_name,
                ];
            });
            return (new FastExcel($excelData))->headerStyle($header_style)
                ->rowsStyle($rows_style)
                ->download('document.xlsx');
        }
        if($search_by=='service'){
            return (new FastExcel($data))->headerStyle($header_style)
                ->rowsStyle($rows_style)->download('service.xlsx',function ($data) {
                return [
                    'सेवाको नाम'=>$data->title,
                    'सेवा कार्यालय'=>$data->service_office,
                    'ससेवाको समय'=>$data->service_time,
                    'सेवा को प्रकार'=>$data->service_type,
                    'सेवा शुल्क'=> $data->service_fee,
                    'जिम्मेवार अधिकारी'=>$data->responsible_officer,
                ];
            });
        }
        if($search_by=='contact'){
            return (new FastExcel($data))->headerStyle($header_style)
                ->rowsStyle($rows_style)->download('contact.xlsx',function ($data) {
                return [
                    'शीर्षक'=>$data->title,
                    'टेलिफोन'=>$data->telephone,
                    'इमेल'=>$data->email,
                    'ठेगाना'=>$data->address,
                    'स्थानीय सरकारको नाम'=>$data->localgovernment_name
                ];
            });
        }
        if($search_by=='resource_map'){
            return (new FastExcel($data))->headerStyle($header_style)
                ->rowsStyle($rows_style)->download('resource_map.xlsx',function ($data) {
                return [
                    'शीर्षक'=>$data->title,
                    'स्थानीय सरकारको नाम'=>$data->localgovernment_name,
                    'थप जानकारी'=>strip_tags($data->body)
                ];
            });
        }
        if($search_by=='article'){
            return (new FastExcel($data))->headerStyle($header_style)
                ->rowsStyle($rows_style)->download('article.xlsx',function ($data) {
                return [
                    'लेखको नाम'=>$data->title,
                    'लेखको ट्यागहरू'=>$data->tags,
                    'स्थानीय सरकारको नाम'=>$data->localgovernment_names,
                ];
            });
        }




    }
}
