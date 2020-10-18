<?php

namespace App\Services\User;

use App\TempTable;
use App\User;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

class UserImport 
{
	protected $users = [];
	protected $valid = true;
	protected $errorRows = [];
	protected $rows = [];
	protected $errorRowId;
	protected $validRowId;

	public function checkImportData($data, $company_id)
	{
		
		$emails = [];
		$phone_numbers = [];
		$account_numbers = [];

		//dump($data);

		foreach ($data as $key => $row) {

			$this->rows[] = $row;
			//check for valid email
			if (!validateEmail($row['email'])) {
				$row['messageemail'] = 'Invalid email';
				$this->errorRows[$key] = $row;
				$this->valid = false;
			} else {
				$emails[] = $row['email'];
			}

			//check for valid phone number
			if (!isValidPhoneNumber($row['phone_number'])) {
				$row['messagephone'] = 'Invalid phone number';
				$this->errorRows[$key] = $row;
				$this->valid = false;
			} else {
				$phone_numbers[] = $row['phone_number'];
			}

			$account_numbers[] = $row['account_number'];

		}

		//check existing email
		$emailexist = $this->checkEmailUserExist($emails, $company_id);

		if (count($emailexist) > 0) {
			$this->valid = false;
			$this->addEmailUserExistErrorMessage($emailexist, $data);
		}

		//check existing phone number
		$phonenumberexist = $this->checkPhoneNumberUserExist($phone_numbers, $company_id);

		if (count($phonenumberexist) > 0) {
			$this->valid = false;
			$this->addPhoneNumberUserExistErrorMessage($phonenumberexist, $data);
		}

		//check existing account number
		$accountnumberexist = $this->checkAccountNumberUserExist($account_numbers, $company_id);

		if (count($accountnumberexist) > 0) {
			$this->valid = false;
			$this->addAccountNumberUserExistErrorMessage($accountnumberexist, $data);
		}

		return $this->valid;

	}

	public function createUsers($data, $company_id) {

		//try {
			
			DB::beginTransaction();
			//insert data
	        foreach ($data as $key => $value) {
	            
	            // create user
	            $userData = [
	                'account_number' => $value->account_number,
	                'first_name' => $value->first_name,
	                'last_name' => $value->last_name,
	                'gender' => $value->gender,
	                'email' => $value->email,
	                'phone_number' => formatPhoneNumber($value->phone_number),
	                'company_id' => $company_id,
	                'created_by' => auth()->user()->id,
	                'updated_by' => auth()->user()->id
	            ];

	            //dump($userData);

	            $user = User::create($userData);

	        }
	        DB::commit();
			
		/*} catch (\Exception $e) {
			
			DB::rollBack();
			\Log::info($e->getMessage());

		}*/

	}

	public function getErrorRowId()
	{
		 if (count($this->errorRows)) {

			ksort($this->errorRows);

			//store row data in db
			$row = TempTable::create([
				'uuid' => Uuid::generate(),
				'user_id' => auth()->user()->id,
				'data' => serialize($this->errorRows),
			]);

			$this->errorRowId = $row->uuid->string;

			return $row->uuid->string;

		} else {
			return [];
		}

	}

	private function checkEmailUserExist($emails, $company_id)
	{
		return User::whereIn('email', $emails)
			->where('company_id', $company_id)
		    ->get()
		    ->pluck('email')
		    ->toArray();
	}

	private function checkPhoneNumberUserExist($phone_numbers, $company_id)
	{
		return User::whereIn('phone_number', $phone_numbers)
			->where('company_id', $company_id)
		    ->get()
		    ->pluck('phone_number')
		    ->toArray();
	}

	private function checkAccountNumberUserExist($account_numbers, $company_id)
	{
		return User::whereIn('account_number', $account_numbers)
			->where('company_id', $company_id)
		    ->get()
		    ->pluck('account_number')
		    ->toArray();
	}

	/*email exists message*/
	private function addEmailUserExistErrorMessage($emailexist, $rows)
	{
		foreach ($rows as $key => $row) {
			if (in_array($row['email'], $emailexist)) {
				$row['messageemail'] = 'Email exists';
				$this->errorRows[$key] = $row;
			} 
		}
		//dump("email exist - ");
		//dd($rows);
		return $rows;
	}

	/*phone number exists message*/
	private function addPhoneNumberUserExistErrorMessage($phonenumberexist, $rows)
	{
		foreach ($rows as $key => $row) {
			if (in_array($row['phone_number'], $phonenumberexist)) {
				$row['messagephone'] = 'Phone number exists';
				$this->errorRows[$key] = $row;
			} 
		}
		//dump("phone exist - ");
		//dd($rows);
		return $rows;
	}

	/*account number exists message*/
	private function addAccountNumberUserExistErrorMessage($accountnumberexist, $rows)
	{
		foreach ($rows as $key => $row) {
			if (in_array($row['account_number'], $accountnumberexist)) {
				$row['messageaccount'] = 'Account number exists';
				$this->errorRows[$key] = $row;
			} 
		}
		//dump("acct exist - ");
		//dd($rows);
		return $rows;
	}


	/*get valid users*/
	public function getValidRowId()
	{
		//$errorRows = $this->getErrorRows();
		$errorRows = TempTable::where('uuid', $this->errorRowId)->first();
		$errorRows = unserialize($errorRows->data);

		$validUsers = [];

		$emails = array_column($errorRows, 'email');
		$account_numbers = array_column($errorRows, 'account_number');
		$phone_numbers = array_column($errorRows, 'phone_number');

		foreach ($this->rows as $row) {
			if 	(
					(!in_array($row['email'], $emails)) 
					&& (!in_array($row['account_number'], $account_numbers)) 
					&& (!in_array($row['phone_number'], $phone_numbers))
				) 
			{
				$validUsers[] = $row;
			}
		}

		if (count($validUsers))  {
			//store row data in db
			$row = TempTable::create([
				'uuid' => Uuid::generate(),
				'user_id' => auth()->user()->id,
				'data' => serialize($validUsers),
			]);

			return $row->uuid->string;

		} else {

			return [];

		}

	}

}