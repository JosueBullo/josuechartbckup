@foreach($users as $user)
    <div class="user-profile">
        <img src="{{ $user->avatar }}" alt="User Avatar">
        <div class="user-details">
            <h3>{{ $user->name }}</h3>
            <p>Email: {{ $user->email }}</p>
        </div>
        <div class="user-actions">
            <a href="#" class="editUser" data-id="{{ $user->id }}">Edit</a>
            <a href="#" class="deleteUser" data-id="{{ $user->id }}">Delete</a>
        </div>
    </div>
@endforeach
