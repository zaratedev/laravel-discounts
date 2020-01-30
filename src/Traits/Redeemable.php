<?php

namespace Zaratedev\Discounts\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * @property \Illuminate\Support\Carbon $redeemed_at
 * @property \Illuminate\Support\Carbon $expires_at
 */
trait Redeemable
{
    /**
     * @return bool
     */
    public function redeem(): bool
    {
        if ($this->isRedeemed() || $this->fireModelEvent('redeeming') === false) {
            return false;
        }

        $this->setAttribute('redeemed_at', $this->freshTimestamp());

        if ($saved = $this->save()) {
            $this->fireModelEvent('redeemed');
        }

        return $saved;
    }

    /**
     * @return bool
     */
    public function isRedeemed(): bool
    {
        return (bool) $this->redeemed_at;
    }

    /**
     * @return bool
     */
    public function isNotRedeemed(): bool
    {
        return ! $this->isRedeemed();
    }

    /**
     * @return bool
     */
    public function isExpired(): bool
    {
        return (bool) optional($this->expires_at)->isPast();
    }

    /**
     * @return bool
     */
    public function isNotExpired(): bool
    {
        return ! $this->isExpired();
    }

    /**
     * Query scope redeemed.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRedeemed(Builder $query): Builder
    {
        return $query->whereNotNull('redeemed_at');
    }

    /**
     * Query scope not redeemed.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotRedeemed(Builder $query): Builder
    {
        return $query->whereNull('redeemed_at');
    }

    /**
     * Query scope expires.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotExpires(Builder $query): Builder
    {
        return $query->whereDate('expires_at', '>=', now());
    }
}
