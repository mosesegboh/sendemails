<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailSchedule extends Model
{
    use HasFactory;

    protected $fillable = ['email_template_id', 'group_id', 'scheduled_time'];

    /**
     * Get the email template associated with the schedule.
     */
    public function emailTemplate()
    {
        return $this->belongsTo(EmailTemplate::class);
    }

    /**
     * Get the customer group associated with the schedule.
     */
    public function group()
    {
        return $this->belongsTo(CustomerGroup::class);
    }
}
