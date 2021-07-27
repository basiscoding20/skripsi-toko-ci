<?php

namespace App\Controllers\Back;
use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportsController extends BaseController
{
	public function __construct(){
		//
	}
	
	public function index()
	{
		if(!in_groups(['admin'])){
			return redirect()->to('/dashboard')->with('error', 'You do not have permission on this page.');
		}

		$status = $this->request->getGet('status')?$this->request->getGet('status'):'';
		$type = $this->request->getGet('type')?$this->request->getGet('type'):'';
		$from = $this->request->getGet('from')?$this->request->getGet('from'):date('Y-m-d');
		$to = $this->request->getGet('to')?$this->request->getGet('to'):date('Y-m-d');

		$order = $this->orderModel->select('orders.*, users.name as customer, users.address as customer_address, users.phone as customer_phone, users.email as customer_email, users.nik as customer_nik')
					  ->join('users', 'users.id = orders.user_id')
					  ->where('orders.deleted_at IS NULL');
		if($status){
			$order = $order->where('orders.status', $status);
		}
		if($from==$to){
			$order = $order->where('DATE(toko_orders.created_at)', $from);
		}elseif($from>$to){
			$order = $order->where('DATE(toko_orders.created_at) BETWEEN "'.$to.'" AND "'.$from.'"');
		}elseif($from<$to){
			$order = $order->where('DATE(toko_orders.created_at) BETWEEN "'.$from.'" AND "'.$to.'"');
		}
		$orders = $order->orderBy('orders.id', 'DESC')->get()->getResult();
		$order_id = array();
		if(@count($orders)>0){
			foreach ($orders as $row) {
				array_push($order_id, $row->id);
			}
		}

		$orderDetail = $this->orderDetailModel->select('order_details.*, users.name as seller, products.seller_id, products.photo, products.title')
					 ->selectSUM('order_details.quantity')
					 ->join('products', 'products.id = order_details.product_id')
					 ->join('users', 'users.id = products.seller_id')
					 ->where('order_details.deleted_at IS NULL');
		if(@count($order_id)>0){
			$orderDetail = $orderDetail->whereIn('order_details.order_id', $order_id);
		}
		if($from==$to){
			$orderDetail = $orderDetail->where('DATE(toko_order_details.created_at)', $from);
		}elseif($from>$to){
			$orderDetail = $orderDetail->where('DATE(toko_order_details.created_at) BETWEEN "'.$to.'" AND "'.$from.'"');
		}elseif($from<$to){
			$orderDetail = $orderDetail->where('DATE(toko_order_details.created_at) BETWEEN "'.$from.'" AND "'.$to.'"');
		}
		if($type){
			$orderDetail = $orderDetail->where('order_details.type', $type);
		}
		$orderDetails = $orderDetail->groupBy('order_details.product_id')->get()->getResult();

		$orderstatus = array('order', 'paid', 'on progress', 'receive', 'completed', 'rejected');
		$producttype = array('product', 'service');
		$data = [
			"title" => "Report Orders",
			"orders" => $orderDetails,
			"status" => $status,
			"type" => $type,
			"from" => $from,
			"to" => $to,
			"orderstatus" => $orderstatus,
			"producttype" => $producttype,
		];
		return view('back/reports/index', $data);
	}
	
	public function export()
	{
		if(!in_groups(['admin'])){
			return redirect()->to('/dashboard')->with('error', 'You do not have permission on this page.');
		}

		$status = $this->request->getGet('status')?$this->request->getGet('status'):'';
		$type = $this->request->getGet('type')?$this->request->getGet('type'):'';
		$from = $this->request->getGet('from')?$this->request->getGet('from'):date('Y-m-d');
		$to = $this->request->getGet('to')?$this->request->getGet('to'):date('Y-m-d');

		$order = $this->orderModel->select('orders.*, users.name as customer, users.address as customer_address, users.phone as customer_phone, users.email as customer_email, users.nik as customer_nik')
					  ->join('users', 'users.id = orders.user_id')
					  ->where('orders.deleted_at IS NULL');
		if($status){
			$order = $order->where('orders.status', $status);
		}
		if($from==$to){
			$order = $order->where('DATE(toko_orders.created_at)', $from);
		}elseif($from>$to){
			$order = $order->where('DATE(toko_orders.created_at) BETWEEN "'.$to.'" AND "'.$from.'"');
		}elseif($from<$to){
			$order = $order->where('DATE(toko_orders.created_at) BETWEEN "'.$from.'" AND "'.$to.'"');
		}
		$orders = $order->orderBy('orders.id', 'DESC')->get()->getResult();
		$order_id = array();
		if(@count($orders)>0){
			foreach ($orders as $row) {
				array_push($order_id, $row->id);
			}
		}

		$orderDetail = $this->orderDetailModel->select('order_details.*, users.name as seller, products.seller_id, products.photo, products.title')
					 ->selectSUM('order_details.quantity')
					 ->join('products', 'products.id = order_details.product_id')
					 ->join('users', 'users.id = products.seller_id')
					 ->where('order_details.deleted_at IS NULL');
		if(@count($order_id)>0){
			$orderDetail = $orderDetail->whereIn('order_details.order_id', $order_id);
		}
		if($from==$to){
			$orderDetail = $orderDetail->where('DATE(toko_order_details.created_at)', $from);
		}elseif($from>$to){
			$orderDetail = $orderDetail->where('DATE(toko_order_details.created_at) BETWEEN "'.$to.'" AND "'.$from.'"');
		}elseif($from<$to){
			$orderDetail = $orderDetail->where('DATE(toko_order_details.created_at) BETWEEN "'.$from.'" AND "'.$to.'"');
		}
		if($type){
			$orderDetail = $orderDetail->where('order_details.type', $type);
		}
		$orderDetails = $orderDetail->groupBy('order_details.product_id')->orderBy('order_details.product_id', 'DESC')->get()->getResult();
		$judul = 'Report Order';
		if($type){
			$judul .= ' Type '.$type;
		}
		if($status){
			$judul .= ' Status '.$status;
		}
		if($from){
			$judul .= ' Dari '.date('d-m-Y', strtotime($from));
		}
		if($to){
			$judul .= ' Sampai '.date('d-m-Y', strtotime($to));
		}

		$spreadsheet = new Spreadsheet();
		$spreadsheet->getActiveSheet()->mergeCells('A1:F1');
	    $spreadsheet->setActiveSheetIndex(0)
	                ->setCellValue('A1', $judul);
	    // tulis header/nama kolom 
	    $spreadsheet->setActiveSheetIndex(0)
	                ->setCellValue('A2', 'No')
	                ->setCellValue('B2', 'Nama Product')
	                ->setCellValue('C2', 'Type Product')
	                ->setCellValue('D2', 'Price')
	                ->setCellValue('E2', 'Order')
	                ->setCellValue('F2', 'Subtotal');
	    
	    $column = 3;
	    // tulis data mobil ke cell
	    $i=1;
	    $total = 0;
	    foreach($orderDetails as $row) {
	    	$price = "Rp".number_format($row->price,0,",",".");
	    	$e = '';
	    	if($row->type == 'product'){
	    		$e = $row->quantity;
	    	}elseif($row->type == 'service'){
	    		$e = $row->quantity;
	    		// $e = $row->datetime?date('d F Y H:i', strtotime($row->datetime)):date('d F Y H:i');
	    	}
	    	$subtotal = ($row->quantity*$row->price);
	    	$f = "Rp".number_format($subtotal,0,",",".");
	        $spreadsheet->setActiveSheetIndex(0)
	                    ->setCellValue('A' . $column, $i++)
	                    ->setCellValue('B' . $column, $row->title)
	                    ->setCellValue('C' . $column, $row->type)
	                    ->setCellValue('D' . $column, $price)
	                    ->setCellValue('E' . $column, $e)
	                    ->setCellValue('F' . $column, $f);
	        $total += $subtotal;
	        $column++;
	    }
	    $ftotal = "Rp".number_format($total,0,",",".");
		$spreadsheet->getActiveSheet()->mergeCells('A'.$column.':E'.$column);
        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A' . $column, 'Total')
                    ->setCellValue('F' . $column, $ftotal);
	    // tulis dalam format .xlsx
	    $writer = new Xlsx($spreadsheet);
	    $fileName = 'Report-'.date('YmdHis');

	    // Redirect hasil generate xlsx ke web client
	    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	    header('Content-Disposition: attachment;filename='.$fileName.'.xls');
	    header('Cache-Control: max-age=0');

	    $writer->save('php://output');
	}
}
