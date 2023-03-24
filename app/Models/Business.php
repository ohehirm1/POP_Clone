<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'abn',
        'xero_key',
    ];

    public function is_verified(): bool
    {
        return boolval($this->verified_at);
    }

    public function getXeroContact(): \XeroAPI\XeroPHP\Models\Accounting\Contact
    {
        $contact = new \XeroAPI\XeroPHP\Models\Accounting\Contact;
        $contact->setContactId($this->xero_key);

        return $contact;
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function allocations(): HasMany
    {
        return $this->hasMany(Allocation::class);
    }
}
