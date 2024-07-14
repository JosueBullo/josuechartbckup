<!-- resources/views/users/categoryedit.blade.php -->

<form id="editUserForm" action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name" value="{{ $user->name }}" required style="width: 100%; padding: 8px; margin-bottom: 10px;"><br>
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" value="{{ $user->email }}" required style="width: 100%; padding: 8px; margin-bottom: 10px;"><br>
    <label for="password">New Password:</label><br>
    <input type="password" id="password" name="password" style="width: 100%; padding: 8px; margin-bottom: 10px;"><br>
    <button type="submit" style="background-color: #0095f6; color: #fff; border: none; border-radius: 3px; padding: 8px 16px; cursor: pointer;">Update User</button>
</form>
