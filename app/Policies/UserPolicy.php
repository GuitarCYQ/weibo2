<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //update 方法接收两个参数，第一个参数默认为当前登录用户实例，第二个参数则为要进行授权的用户实例。 如果 id 不相同的话，将抛出 403 异常信息来拒绝访问。
    public function update(User $currentUser, User $user)
    {
      return $currentUser->id === $user->id;
    }

    //只有当前用户拥有管理员权限且删除的用户不是自己时才显示链接
    public function destroy(User $currentUser, User $user)
    {
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }

    public function follow(User $currentUser, User $user)
    {
      return $currentUser->id !== $user->id;
    }
}
