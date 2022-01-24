<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name','size'];

    public function count()
    {
        return $this->members()->count();
    }

    public function add($user)
    {
        $this->guardAgainstTooManyMembers();

        // it is just a way
        /* if ($user instanceof User) {
            $this->members()->save($user);
        }
        $this->members()->saveMany($user);
        */

        $method = $user instanceof User ? 'save' : 'saveMany';

        $this->members()->$method($user);

    }

    public function members()
    {
        return $this->hasMany(User::class);
    }

    private function guardAgainstTooManyMembers()
    {
        if ($this->count() >= $this->size) {
            throw new \Exception('Exception');
        }
    }

    public function remove(User $user)
    {
        $user->leaveteam();
    }

    public function removeMany(Collection $users)
    {
       $usersId = $users->pluck('id');

       return $this->members()
           ->whereIn('id', $usersId)
           ->update(['team_id' => null]);
    }

    public function restart()
    {
        $this->members()->update(['team_id' => null]);
    }
}
