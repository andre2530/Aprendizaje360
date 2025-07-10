<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar perfil</title>
</head>
<body>
    <h1>Editar Perfil</h1>

    @if (session('status') === 'profile-updated')
        <p style="color: green;">Perfil actualizado correctamente.</p>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')

        <div>
            <label for="name">Nombre:</label><br>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            @error('name')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-top: 10px;">
            <label for="email">Correo electrónico:</label><br>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-top: 20px;">
            <button type="submit">Actualizar</button>
        </div>
    </form>

    <div style="margin-top: 30px;">
        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')

            <p>¿Deseas eliminar tu cuenta?</p>
            <input type="password" name="password" placeholder="Confirma tu contraseña" required>
            @error('password', 'userDeletion')
                <p style="color: red;">{{ $message }}</p>
            @enderror

            <button type="submit" style="color: red;">Eliminar cuenta</button>
        </form>
    </div>
</body>
</html>

</x-app-layout>
