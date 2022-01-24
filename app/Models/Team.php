<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Integer;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name','size'];

    public function count()
    {
        return $this->members()->count();
    }

    /**
     * @throws Exception
     */
    public function add($user)
    {
        $this->guardAgainstTooManyMembers($user);

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

    private function guardAgainstTooManyMembers($users)
    {
        $newTeamCount = $this->count() + $this->extractNewUsersCount($users);

        if ($newTeamCount > $this->size) {
            throw new \Exception;
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

   private function extractNewUsersCount($users): int
   {
       return  ($users instanceof User) ? 1 : count($users);
   }
}
