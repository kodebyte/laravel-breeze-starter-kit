<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;

trait HasActivityLogs
{
    /**
     * Nama fungsi ini harus boot[NamaTrait] biar otomatis jalan
     */
    protected static function bootHasActivityLogs(): void
    {
        foreach (['created', 'updated', 'deleted'] as $event) {
            static::$event(function (Model $model) use ($event) {
                ActivityLog::create([
                    'log_name'     => strtolower(class_basename($model)),
                    'description'  => ucfirst($event) . " " . class_basename($model),
                    'subject_id'   => $model->id,
                    'subject_type' => get_class($model),
                    'causer_id'    => auth()->id(),
                    'causer_type'  => auth()->check() ? get_class(auth()->user()) : null,
                    'properties'   => [
                        'attributes' => $model->getAttributes(),
                        'old'        => $event === 'updated' ? $model->getOriginal() : null,
                    ],
                    'ip_address'   => request()->ip(),
                    'user_agent'   => request()->userAgent(),
                ]);
            });
        }
    }
}