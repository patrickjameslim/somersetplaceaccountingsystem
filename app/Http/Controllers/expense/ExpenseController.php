<?php

namespace App\Http\Controllers\expense;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityHelper;

class ExpenseController extends Controller
{
    use UtilityHelper;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tExpenseList = $this->getExpense(null);
        $eExpenseList = array();

        foreach ($tExpenseList as $tExpense) {
            $eExpenseList[$this->formatString($tExpense->id)] = $tExpense;
        }
        
        return view('expense.expense_list',
                        compact('eExpenseList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dateToday = date('m/d/y');
        $receiptNumber = 1;
        $ehomeOwnerMembersList = $this->getHomeOwnerInformation(null);
        $eReceiptLastRecord = $this->getObjectLastRecord('expense_cash_voucher','');
        if(count($eReceiptLastRecord)>0){
            $receiptNumber =  ($eReceiptLastRecord->id + 1);
        }
        $receiptNumber = $this->formatString($receiptNumber);
        $expenseAccountTitleGroupId = $this->getObjectFirstRecord('account_groups',array('account_group_name'=>'Expense'));
        $eExpenseAccountTitlesList = $this->getObjectRecords('account_titles',array('account_group_id'=>$expenseAccountTitleGroupId->id));
        return view('expense.create_expense',
                        compact('dateToday',
                                'receiptNumber',
                                'eExpenseAccountTitlesList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->input('data');
        $paidTo = $request->input('paidTo');
        $totalAmount = $request->input('totalAmount');
        $nReceiptId = $this->insertRecord('expense_cash_voucher',array('paid_to' => $paidTo,
                                                                        'total_amount' => $totalAmount));

        $dataToInsert = $this->populateListOfToInsertItems($data,'Expense','expense_cash_voucher_id',$nReceiptId,'expense_cash_voucher');
        $this->insertBulkRecord('expense_cash_voucher_items',$dataToInsert);
        //Create journal entry
        $this->insertBulkRecord('journal_entry',$this->createJournalEntry($dataToInsert,
                                                                            'Expense',
                                                                            'expense_id',
                                                                            $nReceiptId,
                                                                            'Created Cash Voucher for ' . $paidTo));
        flash()->success('Record successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $eExpense = $this->getExpense($id);
        $eExpenseId = $this->formatString($eExpense->id);
        $eExpenseItemsList = $this->getObjectRecords('expense_cash_voucher_items', array('expense_cash_voucher_id' => $id));
        $eCashier = $this->getObjectFirstRecord('users',array('id'=>$eExpense->created_by));
        $expenseAccountTitleGroupId = $this->getObjectFirstRecord('account_groups',array('account_group_name'=>'Expense'));
        $eExpenseAccountTitlesList = $this->getObjectRecords('account_titles',array('account_group_id'=> $expenseAccountTitleGroupId->id));
        $tExpenseAccountTitlesList = array();
        foreach ($eExpenseAccountTitlesList as $eIncomeAccountTitle) {
            $tExpenseAccountTitlesList[$eIncomeAccountTitle->id] = $eIncomeAccountTitle->account_sub_group_name;
        }
        if($eCashier->home_owner_id != NULL){
            $eCashier = $this->getObjectFirstRecord('home_owner_member_information',array('id'=>$eCashier->home_owner_id));
        }
        return view('expense.show_expense',
                        compact('eExpense',
                                'eExpenseId',
                                'eExpenseItemsList',
                                'eCashier',
                                'tExpenseAccountTitlesList'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tExpenseAccountTitlesList = array();
        $eExpense = $this->getExpense($id);
        $eExpenseId = $this->formatString($eExpense->id);
        $eCashier = $this->getObjectFirstRecord('users',array('id'=>$eExpense->created_by));
        $eExpenseItemsList = $this->getObjectRecords('expense_cash_voucher_items', array('expense_cash_voucher_id' => $id));
        $expenseAccountTitleGroupId = $this->getObjectFirstRecord('account_groups',array('account_group_name'=>'Expense'));
        $eExpenseAccountTitlesList = $this->getObjectRecords('account_titles',array('account_group_id'=> $expenseAccountTitleGroupId->id));     
        foreach ($eExpenseAccountTitlesList as $eIncomeAccountTitle) {
            $tExpenseAccountTitlesList[$eIncomeAccountTitle->id] = $eIncomeAccountTitle->account_sub_group_name;
        }
        if($eCashier->home_owner_id != NULL){
            $eCashier = $this->getObjectFirstRecord('home_owner_member_information',array('id'=>$eCashier->home_owner_id));
        }
        return view('expense.edit_expense',
                        compact('eExpense',
                                'eExpenseId',
                                'eExpenseItemsList',
                                'eCashier',
                                'eExpenseAccountTitlesList',
                                'tExpenseAccountTitlesList'));
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
        $toDeleteExpItems = array();
        $toDeleteJournalEntry = array();
        $data = $request->input('data');
        $paidTo = $request->input('paidTo');
        $totalAmount = $request->input('totalAmount');
        $this->updateRecord('expense_cash_voucher',$id,array('total_amount' => $totalAmount));
        //Get expense items from database for deletion
        $eExpenseItemsList = $this->getObjectRecords('expense_cash_voucher_items', array('expense_cash_voucher_id' => $id));
        $eJournalEntriesList = $this->getObjectRecords('journal_entry',array('expense_id'=>$id));
        foreach ($eExpenseItemsList as $eExpenseItem) {
            $toDeleteExpItems[] = $eExpenseItem->id;
        }

        foreach ($eJournalEntriesList as $eJournalEntry) {
            $toDeleteJournalEntry[] = $eJournalEntry->id;
        }
        $this->deleteRecord('journal_entry',$toDeleteJournalEntry);
        $this->deleteRecord('expense_cash_voucher_items',$toDeleteExpItems);


        $dataToInsert = $this->populateListOfToInsertItems($data,'Expense','expense_cash_voucher_id',$id,'expense_cash_voucher');
        $this->insertBulkRecord('expense_cash_voucher_items',$dataToInsert);
        //Create journal entry
        $this->insertBulkRecord('journal_entry',$this->createJournalEntry($dataToInsert,
                                                                            'Expense',
                                                                            'expense_id',
                                                                            $id,
                                                                            'Created Cash Voucher for ' . $paidTo));
        flash()->success('Record successfully updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $toDeleteItems = array();
        $eExpense = $this->getExpense($id);
        $eExpenseItemsList = $this->getObjectRecords('expense_cash_voucher_items', array('expense_cash_voucher_id' => $id));
        $eJournalEntriesList = $this->getObjectRecords('journal_entry',array('expense_id'=>$id));
        foreach ($eExpenseItemsList as $eExpenseItem) {
            $toDeleteItems[] = $eExpenseItem->id;
        }
        foreach ($eJournalEntriesList as $eJournalEntry) {
            $toDeleteJournalEntry[] = $eJournalEntry->id;
        }
        $this->deleteRecord('journal_entry',$toDeleteJournalEntry);
        $this->deleteRecord('expense_cash_voucher_items',$toDeleteItems);
        $this->deleteRecord('expense_cash_voucher',array($id));
        flash()->success('Record successfully deleted')->important();
        return redirect('expense');
    }
}
