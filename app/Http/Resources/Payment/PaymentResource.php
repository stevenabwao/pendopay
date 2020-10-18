<?php

namespace App\Http\Resources\Payment;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    /* public function toArray22($request)
    {

        if ($this->created_at) { $created_at = $this->created_at->toIso8601String(); } else { $created_at = null; }
        if ($this->updated_at) { $updated_at = $this->updated_at->toIso8601String(); } else { $updated_at = null; }
        if ($this->processed_at) { $processed_at = $this->processed_at->toIso8601String(); } else { $processed_at = null; }
        if ($this->failed_at) { $failed_at = $this->failed_at->toIso8601String(); } else { $failed_at = null; }
        if ($this->reposted_at) { $reposted_at = $this->reposted_at->toIso8601String(); } else { $reposted_at = null; }

        // get payment method name
        $payment_method = $this->getPaymentMethod($this->payment_method_id);
        if ($payment_method) { $payment_method_name = $payment_method->name; } else { $payment_method_name = null; }

        return [

          'id' => (int)$this->id,
          'currency_id' => $this->currency_id,
          'amount' => $this->amount,
          'payment_method_id' => $this->payment_method_id,
          'payment_method_name' => $payment_method_name,
          'phone' => $this->phone,
          'browser' => $this->browser,
          'company_id' => (int)$this->company_id,
          'company_name' => $this->company_name,
          'account_no' => $this->account_no,
          'account_name' => $this->account_name,
          'paybill_number' => $this->paybill_number,
          'full_name' => $this->full_name,
          'trans_id' => (int)$this->trans_id,
          'trans_time' => $this->trans_time,
          'date_stamp' => $this->date_stamp,
          'modified' => $this->modified,
          'processed' => $this->processed,
          'failed' => $this->failed,
          'fail_times' => (int)$this->fail_times,
          'fail_reason' => $this->fail_reason,
          'comments' => $this->comments,
          'updated_by' => $this->updated_by,
          'reposted_by' => $this->reposted_by,
          'created_by' => $this->created_by,
          'updated_by' => $this->updated_by,
          'deleted_by' => $this->deleted_by,
          'browser_version' => $this->browser_version,
          'os' => $this->os,
          'device' => $this->device,
          'src_ip' => $this->src_ip,
          'created_at' => $created_at,
          'updated_at' => $updated_at,
          'processed_at' => $processed_at,
          'failed_at' => $failed_at,
          'reposted_at' => $reposted_at
        ];

    } */
}
