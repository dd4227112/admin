<?php


namespace App\Imports;
use App\Models\Expense;
use Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use DB;

class ImportExpense implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     * */
  
    
    public function model(array $row)
    {
        $payer_name = $row['recipient'];
        $i = 0;
        $status = 1;
        $refer_expense = \App\Models\ReferExpense::where('name', $row['name'])->first();
        if (empty($refer_expense)) {
            $obj = [
                'name' => $row['category'],
                "financial_category_id" => 2,
            ];

            $check = DB::table('account_groups')->where('name', $row['category'])->first();
            $account_group_id = !empty($check) ? $check->id : DB::table('account_groups')->insertGetId($obj);
            $check = DB::table('account_groups')->where('name', $row['category'])->first();
            $array = array(
                "name" => trim($row['category']),
                "financial_category_id" => $check->financial_category_id,
                "note" => $row['note'],
                "account_group_id" => $account_group_id,
                'code' => $row['code'] == '' ? date('is').$i++ : $row['code'],
                'open_balance' => 0,
                "status" => 1
            );

            $refer_expense = \App\Models\ReferExpense::create($array);
        }
      
        $check_unique = \App\Models\Expense::where('transaction_id', $row['transaction_id'])->first();
        if (empty($check_unique)) {
            $status .= '<p class="alert alert-danger">This transaction ID <b>' . $row['transaction_id'] . '</b> already being used. Information skipped</p>';
        }

        $bank = \App\Models\BankAccount::where('number', $row['account_number'])->first();
        $payment_type = \App\Models\PaymentType::where(DB::raw('lower(name)'), 'ilike', trim(strtolower($row['payment_method'])))->first();

        $array = array(
            "date" => $row['date'],
            "note" => $row['note'],
            "ref_no" => $row['transaction_id'],
            "payment_type_id" => $payment_type->id,
            "payment_method" => $row['payment_method'],
            "transaction_id" => $row['transaction_id'],
            "refer_expense_id" => $refer_expense->id,
            "expenseyear" => date('Y'),
            'expense_subcategories' => 3,
            'expense_subcategories_id' => 3,
            "expense" => $row['note'],
            "depreciation" => 0,
            'user_id' => Auth::user()->id,
            "bank_account_id" => !empty($bank) ? $bank->id : '1',
            "amount" => $row['amount']
        );

        $voucher_no = DB::table('expense')->max('voucher_no');
        $user = \App\Models\User::where('name', 'ilike', '%' . $payer_name . '%')->first();
        if ((int) $row['user_in_shulesoft'] == 1 && !empty($user)) {
            $obj = array_merge($array, [
                'recipient' => $user->firstname . ' ' . $user->lastname,
                'voucher_no' => $voucher_no + 1,
                'payer_name' => $payer_name,
            ]);

        } else {
            $obj = array_merge($array, [
                'recipient' => $row['recipient'],
                'voucher_no' => $voucher_no + 1,
                'payer_name' => $payer_name,
            ]);
        }
        return new Expense($obj);
       
    }
}



