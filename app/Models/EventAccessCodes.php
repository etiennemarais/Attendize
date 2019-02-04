<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class EventAccessCodes extends MyBaseModel
{
    use SoftDeletes;

    /**
     * The validation rules.
     *
     * @return array $rules
     */
    public function rules()
    {
        return [
            'code' => 'required|string',
        ];
    }

    /**
     * The Event associated with the event access code.
     *
     * @return BelongsTo
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }

    /**
     * @param $code
     * @param $event_id
     * @return Collection
     */
    public static function findFromCode($code, $event_id)
    {
        return (new static())
            ->where('code', $code)
            ->where('event_id', $event_id)
            ->get();
    }

    /**
     * @return BelongsToMany
     */
    function tickets()
    {
        return $this->belongsToMany(
            Ticket::class,
            'ticket_event_access_code',
            'event_access_code_id',
            'ticket_id'
        )->withTimestamps();
    }
}