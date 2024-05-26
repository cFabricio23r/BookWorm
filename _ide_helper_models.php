<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string|null $user_id
 * @property string|null $title
 * @property string|null $author
 * @property string|null $year
 * @property string|null $summary
 * @property array|null $key_aspects
 * @property array|null $context
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\User|null $updatedBy
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\SummaryFactory factory($count = null, $state = [])
 * @method static \App\Builders\SummaryQueryBuilder|Summary newModelQuery()
 * @method static \App\Builders\SummaryQueryBuilder|Summary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Summary onlyTrashed()
 * @method static \App\Builders\SummaryQueryBuilder|Summary query()
 * @method static \App\Builders\SummaryQueryBuilder|Summary whereAuthor($value)
 * @method static \App\Builders\SummaryQueryBuilder|Summary whereContext($value)
 * @method static \App\Builders\SummaryQueryBuilder|Summary whereCreatedAt($value)
 * @method static \App\Builders\SummaryQueryBuilder|Summary whereCreatedBy($value)
 * @method static \App\Builders\SummaryQueryBuilder|Summary whereDeletedAt($value)
 * @method static \App\Builders\SummaryQueryBuilder|Summary whereId($value)
 * @method static \App\Builders\SummaryQueryBuilder|Summary whereKeyAspects($value)
 * @method static \App\Builders\SummaryQueryBuilder|Summary whereSummary($value)
 * @method static \App\Builders\SummaryQueryBuilder|Summary whereTitle($value)
 * @method static \App\Builders\SummaryQueryBuilder|Summary whereUpdatedAt($value)
 * @method static \App\Builders\SummaryQueryBuilder|Summary whereUpdatedBy($value)
 * @method static \App\Builders\SummaryQueryBuilder|Summary whereUser(string $user)
 * @method static \App\Builders\SummaryQueryBuilder|Summary whereUserId($value)
 * @method static \App\Builders\SummaryQueryBuilder|Summary whereYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Summary withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Summary withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperSummary {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $lastname
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUser {}
}

