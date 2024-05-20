<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full bg-gray-100" :value="old('name', $user->name)" required autofocus autocomplete="name" readonly />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="mt-4">
            <x-input-label for="user_code" :value="__('User Code')" />
            <x-text-input id="user_code" name="user_code" type="text" class="mt-1 block w-full bg-gray-100" :value="old('user_code', $user->user_code)" required autocomplete="username" readonly />
            <x-input-error class="mt-2" :messages="$errors->get('user_code')" />
        </div>

    </form>
</section>
