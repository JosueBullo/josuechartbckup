<!-- resources/views/users/categorycreate.blade.php -->

<form id="createUserForm" action="{{ route('users.store') }}" method="POST">
    @csrf
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name" required style="width: 100%; padding: 8px; margin-bottom: 10px;"><br>
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required style="width: 100%; padding: 8px; margin-bottom: 10px;"><br>
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required style="width: 100%; padding: 8px; margin-bottom: 10px;"><br>
    <button type="submit" style="background-color: #0095f6; color: #fff; border: none; border-radius: 3px; padding: 8px 16px; cursor: pointer;">Create User</button>
</form>
