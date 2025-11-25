<?
namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResourcePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user, $model)
    {
        return $user->can('view_any_' . strtolower(class_basename($model)));
    }

    public function view(User $user, $model)
    {
        return $user->can('view_' . strtolower(class_basename($model)));
    }

    public function create(User $user, $model)
    {
        return $user->can('create_' . strtolower(class_basename($model)));
    }

    public function update(User $user, $model)
    {
        return $user->can('update_' . strtolower(class_basename($model)));
    }

    public function delete(User $user, $model)
    {
        return $user->can('delete_' . strtolower(class_basename($model)));
    }
}
