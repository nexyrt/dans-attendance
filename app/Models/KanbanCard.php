<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\QueueableEntity;
use Illuminate\Contracts\Queue\QueueableCollection;

class KanbanCard extends Model implements QueueableEntity
{
    use HasFactory, SerializesModels;

    protected $fillable = [
        'title',
        'description',
        'status',
        'order',
        'assigned_to',
        'due_date'
    ];

    /**
     * Get the name of the "created at" column.
     *
     * @return string|null
     */
    public function getCreatedAtColumn()
    {
        return 'created_at';
    }

    /**
     * Get the name of the "updated at" column.
     *
     * @return string|null
     */
    public function getUpdatedAtColumn()
    {
        return 'updated_at';
    }

    /**
     * Get the queueable identity for the entity.
     *
     * @return mixed
     */
    public function getQueueableId()
    {
        return $this->getKey();
    }

    /**
     * Get the queueable connection for the entity.
     *
     * @return string|null
     */
    public function getQueueableConnection()
    {
        return $this->getConnectionName();
    }

    /**
     * Get the queueable relationships for the entity.
     *
     * @return array
     */
    public function getQueueableRelations()
    {
        return ['user'];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}