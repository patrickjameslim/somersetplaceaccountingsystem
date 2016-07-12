<?php

namespace App\Http\Controllers\receipt;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityHelper;

class ReceiptController extends Controller
{
    use UtilityHelper;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $eInvoiceModelList = array();
        $invoiceNumberList = array();
        $eHomeOwnerReceiptList = array();
        $eHomeOwnersList = array();
        $tHomeOwnerReceiptList = $this->getHomeOwnerReceipt(null);
        $tinvoiceModelList = $this->getHomeOwnerInvoice(null);
        $tHomeOwnersList = $this->getHomeOwnerInformation(null);
        foreach ($tHomeOwnerReceiptList as $tHomeOwnerReceipt) {
            $eHomeOwnerReceiptList[$this->formatString($tHomeOwnerReceipt->id)] = $tHomeOwnerReceipt;
        }
        foreach ($tinvoiceModelList as $tinvoiceModel) {
            $eInvoiceModelList[($tinvoiceModel->id)] = $tinvoiceModel;
            $invoiceNumberList[$tinvoiceModel->id] = $this->formatString($tinvoiceModel->id);
        }
        foreach ($tHomeOwnersList as $tHomeOwner) {
            $eHomeOwnersList[$tHomeOwner->id] = $tHomeOwner;
        }
        return view('receipt.receipt_list',
                        compact('eHomeOwnerReceiptList',
                                'eInvoiceModelList',
                                'invoiceNumberList',
                                'eHomeOwnersList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $dateToday = date('m/d/y');
        $homeOwnerInvoice = $this->getHomeOwnerInvoice($id);
        $pendingPaymentsList = $this->getObjectRecords('home_owner_invoice_items', array('invoice_id' => $homeOwnerInvoice->id));
        $eHomeOwner = $this->getHomeOwnerInformation($homeOwnerInvoice->home_owner_id);
        $invoiceNumber = $this->formatString($homeOwnerInvoice->id);
        $eCashier = $this->getObjectFirstRecord('users',array('id'=>$homeOwnerInvoice->created_by));
        
        $receiptNumber = 1;
        $receiptList = $this->getObjectLastRecord('home_owner_payment_transaction','');
        if(count($receiptList)>0){
            $receiptNumber =  ($receiptList->id + 1);
        }
        $receiptNumber = $this->formatString($receiptNumber);
        $incomeAccountTitleGroupId = $this->getObjectFirstRecord('account_groups',array('account_group_name'=>'Income'));
        $eIncomeAccountTitlesList = $this->getObjectRecords('account_titles',array('account_group_id'=>$incomeAccountTitleGroupId->id));
        $tIncomeAccountTitlesList = array();
        foreach ($eIncomeAccountTitlesList as $eIncomeAccountTitle) {
            $tIncomeAccountTitlesList[$eIncomeAccountTitle->id] = $eIncomeAccountTitle->account_sub_group_name;
        }
        if($eCashier->home_owner_id != NULL){
            $eCashier = $this->getObjectFirstRecord('home_owner_member_information',array('id'=>$eCashier->home_owner_id));
        }
        return view('receipt.create_receipt',
                        compact('homeOwnerInvoice',
                                'pendingPaymentsList',
                                'invoiceNumber',
                                'eHomeOwner',
                                'receiptNumber',
                                'dateToday',
                                'eCashier',
                                'tIncomeAccountTitlesList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $invoiceid = $request->input('payment_id');
        //Updates Invoice Record
        $this->updateRecord('home_owner_invoice',array('id'=>$invoiceid),array('is_paid' => 1));


        $receiptId = $this->insertRecord('home_owner_payment_transaction',array('payment_id'=>$invoiceid,
                                                                                'file_related'=>$request->input('file_related')));
        
        
        $toInsertData = array();
        //create journal entry
        $this->insertBulkRecord('journal_entry',$this->createJournalEntry($toInsertData,
                                                                            'Receipt',
                                                                            'receipt_id',
                                                                            $receiptId,
                                                                            'Created Receipt for invoice #'. $this->formatString($invoiceid)));
        // //create journal entry
        // $this->insertRecord('journal_entry',array('receipt_id'=>$receiptId,
        //                                             'type'=>'Receipt',
        //                                             'description'=>'Created Receipt for invoice '. $invoiceid));
        flash()->success('Record successfully created');
        return redirect('receipt/'. $receiptId);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tIncomeAccountTitlesList = array();
        $homeOwnerPaymentTrans = $this->getHomeOwnerReceipt($id);
        $homeOwnerInvoice = $this->getHomeOwnerInvoice($homeOwnerPaymentTrans->payment_id);
        $homeOwnerInfo = $this->getHomeOwnerInformation($homeOwnerInvoice->home_owner_id);
        $receiptNumber = $this->formatString($homeOwnerPaymentTrans->id);
        $invoiceNumber = $this->formatString($homeOwnerPaymentTrans->payment_id);
        $eCashier = $this->getObjectFirstRecord('users',array('id'=>$homeOwnerPaymentTrans->created_by));
        $pendingPaymentsList = $this->getObjectRecords('home_owner_invoice_items', array('invoice_id' => $homeOwnerPaymentTrans->payment_id));
        $incomeAccountTitleGroupId = $this->getObjectFirstRecord('account_groups',array('account_group_name'=>'Income'));
        $eIncomeAccountTitlesList = $this->getObjectRecords('account_titles',array('account_group_id'=>$incomeAccountTitleGroupId->id));
        foreach ($eIncomeAccountTitlesList as $eIncomeAccountTitle) {
            $tIncomeAccountTitlesList[$eIncomeAccountTitle->id] = $eIncomeAccountTitle->account_sub_group_name;
        }
        if($eCashier->home_owner_id != NULL){
            $eCashier = $this->getObjectFirstRecord('home_owner_member_information',array('id'=>$eCashier->home_owner_id));
        }
        return view('receipt.show_receipt',
                        compact('homeOwnerPaymentTrans',
                                'receiptNumber',
                                'invoiceNumber',
                                'pendingPaymentsList',
                                'homeOwnerInfo',
                                'homeOwnerInvoice',
                                'eCashier',
                                'tIncomeAccountTitlesList'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
